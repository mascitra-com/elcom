<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Produk extends MY_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->redirect_if_not_admin();
		$this->load->helper(array('dump', 'potong_teks', 'cek_file'));
		$this->load->model(array('products_m', 'categories_m', 'producers_m'));

		$this->slug_config($this->categories_m->table, 'name');
	}

	public function index($row = NULL)
	{  
		if (empty($row)) {
			$row = 20;
		} elseif ($this->uri->segment(2) == "search") { 
			$row = 20;
		}

		$filter 	= $this->session->userdata('filter_product');
		$order_by 	= $this->session->userdata('ob_product');
		$order_type = $this->session->userdata('ot_product');

		$this->load->database(); 
		$jumlah_data = $this->products_m
		->where($filter, 'like', '%')
            ->where('archived', '0')
            ->order_by($order_by, $order_type)
		->with_category('fields:name')
		->with_category('order_by:name,asc') 
		->with_producer('fields:name')
		->count_rows();

		$this->load->library('pagination');
		$config['base_url'] = base_url().'/produk/index/'.$row.'/';
		$config['total_rows'] = $jumlah_data;
		$config['uri_segment'] = 4;
		$config['per_page'] = $row;

		$config['full_tag_open'] = "<ul class='pagination pagination-sm' style='position:relative; top:-68px;'>";
		$config['full_tag_close'] ="</ul>";
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = "<li>";
		$config['next_tagl_close'] = "</li>";
		$config['prev_tag_open'] = "<li>";
		$config['prev_tagl_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tagl_close'] = "</li>"; 

		$from = $this->uri->segment(4);
		$from = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		if ($from == 0) {
			$from = "0";
		}  

		$this->pagination->initialize($config);		   

		$data['products'] = $this->products_m
		->where($filter, 'like', '%')
		->where('archived', '0')
		->order_by($order_by, $order_type)
		->with_category('fields:name')
		->with_category('order_by:name,asc') 
		->with_producer('fields:name') 
		->limit($config['per_page'],$offset=$from)
		->get_all();

		$data['categories'] = $this->categories_m
		->fields('id,name')
		->get_all();

		$data['producers'] = $this->producers_m
		->fields('id,name')
		->get_all();

		$data['row'] 		 = $row;
		$data['jumlah_data'] = $jumlah_data;
		$data['paginasi']    = $this->pagination->create_links();
		$data['filter'] 	 = $filter;
		$data['order_by']	 = $order_by;
		$data['order_type']	 = $order_type;
		$data['data_option'] = $this->session->userdata('data_option');

		$this->generateCsrf();
		$this->render('admin/products/index', $data);
	}
	public function search()
	{ 
		$filter_data 	= $this->input->post();
		$ob 			= $this->input->post('order_by');
		$ot 			= $this->input->post('order_type');

		$data_split 	= array(
			'category_id' => $this->categories_m->splitIdAndName($this->input->post('category_id')),
			'producer_id' => $this->categories_m->splitIdAndName($this->input->post('producer_id'))
			);

		$data_option = array( 
			'category_name' => $this->input->post('category_id'),
			'producer_name' => $this->input->post('producer_id'),
			);
		$filter_data = array_merge($filter_data, $data_split); 

        // dump($filter_data);
		unset($filter_data['order_by']);
		unset($filter_data['order_type']); 

		$this->session->set_userdata('ob_product', $ob);
		$this->session->set_userdata('ot_product', $ot);
		$this->session->set_userdata('data_option', $data_option);

		$this->session->unset_userdata('filter_product');
		$this->session->set_userdata('filter_product', $filter_data);
		$this->go('produk');
	}
	public function refresh()
	{
		$this->session->unset_userdata(array('filter_product', 'ob_product', 'ot_product', 'data_option'));
		$this->go('produk');
	}

	public function selengkapnya($code = NULL)
	{
		if (is_null($code) || empty($code)) {
			$this->message('Produk tidak ditemukan', 'warning');
			$this->go('produk');
		}else{
			$data['product'] = $this->products_m
			->with_category('fields:name')
			->with_producer('fields:name')
			->get(array('code' => $code));

			$this->render('admin/products/show', $data);
		}
	}

	public function tambah()
	{
		$data['categories'] = $this->categories_m
		->fields('id,name')
		->get_all();

		$data['producers'] = $this->producers_m
		->fields('id,name')
		->get_all();

		$this->generateCsrf();
		$this->render('admin/products/create', $data);
	}

	public function simpan()
	{
		$input = $this->input->post();


		//jika id kategori ada isinya
		if (!is_null($input['category_id']) || !empty($input['category_id'])) {
			//ambil hanya id kategori
			$input['category_id'] = $this->categories_m->splitIdAndName($input['category_id']);
			//cek keberadaan kategori
			if (!$this->categories_m->checkDataAvailabilityById($input['category_id'])) {
				$this->message('Terjadi kesalahan pada sistem. Ikuti format pengisian kategori produk dengan benar');
				$this->go('produk/tambah');
			}
		}

		//jika id produsen ada isinya
		if (!is_null($input['producer_id']) || !empty($input['producer_id']))  {
			//ambil hanya id produsen
			$input['producer_id'] = $this->producers_m->splitIdAndName($input['producer_id']);
			//cek keberadaan produsen
			if (!$this->producers_m->checkDataAvailabilityById($input['producer_id'])) {
				$this->message('Terjadi kesalahan pada sistem. Ikuti format pengisian produsen produk dengan benar');
				$this->go('produk/tambah');
			}
		}

		if (!isset($input['tax'])) {
			$input['tax'] = '0';
		}

		if (!isset($input['size'])) {
			$input['size'] = NULL;
		}else{
			$input['size'] = implode('|', $input['size']);
		}

		if (empty($input['discount'])) {
			$input['discount'] = NULL;
		}else{
			$input['discount'] = $input['discount'] / 100;
		}

		$input['code'] = $this->products_m->get_last_id();

		//upload gambar
		for ($i=1; $i <5; $i++) { 
			$image_name = $this->do_upload(1 ,$input['code'], 'image_'.$i, $i, 'images/products/');

			if (!empty($image_name)) {
				$input['image_'.$i]  = $image_name; 
			}  
		}

		//insert ke db
		$query = $this->products_m
		->from_form(NULL, array(
			'category_id' => $input['category_id'],
			'producer_id' => $input['producer_id'],
			'code' => $input['code'],
			'slug' => $this->slug->create_uri($input),
			'tax' => $input['tax'],
			'size' => $input['size'],
			'discount' => $input['discount'],
			'image_1' => $input['image_1'],
			'image_2' => $input['image_2'],
			'image_3' => $input['image_3'],
			'image_4' => $input['image_4'],
			))
		->insert();
		if ($query === FALSE) {
			$this->message('Produk gagal ditambahkan.', 'warning');
		}else{
			$this->message('Produk berhasil ditambahkan.', 'success');
		}

		$this->go('produk');
	}

	public function sunting($code = NULL)
	{
		if (is_null($code) || empty($code)) {
			$this->message('Produk tidak ditemukan', 'warning');
			$this->go('produk');
		}else{
			$query = $this->products_m
			->with_category('fields:name')
			->with_producer('fields:name')
			->get(array('code' => $code));

			if ($query) {
				$data['product'] = $query;
				$data['categories'] = $this->categories_m
				->fields('id,name')
				->get_all();

				$data['producers'] = $this->producers_m
				->fields('id,name')
				->get_all();
				$this->generateCsrf();
				$this->render('admin/products/edit', $data);
			}else{
				$this->message('Produk tidak ditemukan.', 'warning');
				$this->go('produk/index');
			}
		}
	}

	public function ubah($id= NULL)
	{
		if (is_null($id) || empty($id)) {
			$this->message('Produk tidak ditemukan', 'warning');
		}else{
            $input = $this->input->post();
            $input['code'] = $this->products_m->get(array('id' => $id))->code;

			//jika id kategori ada isinya
			if (!is_null($input['category_id']) || !empty($input['category_id'])) {
			//ambil hanya id kategori
				$input['category_id'] = $this->categories_m->splitIdAndName($input['category_id']);
			//cek keberadaan kategori
				if (!$this->categories_m->checkDataAvailabilityById($input['category_id'])) {
					$this->message('Terjadi kesalahan pada sistem. Ikuti format pengisian kategori produk dengan benar');
					$this->go('produk/sunting');
				}
			}

			//jika id produsen ada isinya
			if (!is_null($input['producer_id']) || !empty($input['producer_id']))  {
			//ambil hanya id produsen
				$input['producer_id'] = $this->producers_m->splitIdAndName($input['producer_id']);
			//cek keberadaan produsen
				if (!$this->producers_m->checkDataAvailabilityById($input['producer_id'])) {
					$this->message('Terjadi kesalahan pada sistem. Ikuti format pengisian produsen produk dengan benar');
					$this->go('produk/sunting');
				}
			}

			if (!isset($input['tax'])) {
				$input['tax'] = '0';
			}

			if (!isset($input['size'])) {
				$input['size'] = NULL;
			}else{
				$input['size'] = implode('|', $input['size']);
			}

			if (empty($input['discount'])) {
				$input['discount'] = NULL;
			}else{
				$input['discount'] = $input['discount'] / 100;
			}
            if(!empty($_FILES['image_1']['name'])) {
                //hapus image_1 sebelumnya
                $prev_image_1_name = $this->products_m->get(array('id' => $id))->image_1;
                //tidak hapus jika nama image_1 'default'
                if ($prev_image_1_name !== 'default.png') {
                    $this->delete_files($prev_image_1_name, 'images/products/');
                }

                //upload image_1
                $image_name_1 = $this->do_upload(1, $input['code'], 'image_1', '1', 'images/products/');
            } else {
                $image_name_1 = $this->products_m->get(array('id' => $id))->image_1;
            }

            if(!empty($_FILES['image_2']['name'])) {
                //hapus image_2 sebelumnya
                $prev_image_2_name = $this->products_m->get(array('id' => $id))->image_2;
                //tidak hapus jika nama image_2 'default'
                if ($prev_image_2_name !== 'default.png') {
                    $this->delete_files($prev_image_2_name, 'images/products/');
                }

                //upload image_2
                $image_name_2 = $this->do_upload(1, $input['code'], 'image_2', '2', 'images/products/');
            } else {
                $image_name_2 = $this->products_m->get(array('id' => $id))->image_2;
            }

            if(!empty($_FILES['image_3']['name'])) {
                //hapus image_3 sebelumnya
                $prev_image_3_name = $this->products_m->get(array('id' => $id))->image_3;
                //tidak hapus jika nama image_3 'default'
                if ($prev_image_3_name !== 'default.png') {
                    $this->delete_files($prev_image_3_name, 'images/products/');
                }

                //upload image_3
                $image_name_3 = $this->do_upload(1, $input['code'], 'image_3', '3', 'images/products/');
            } else {
                $image_name_3 = $this->products_m->get(array('id' => $id))->image_3;
            }

            if(!empty($_FILES['image_4']['name'])) {
                //hapus image_4 sebelumnya
                $prev_image_4_name = $this->products_m->get(array('id' => $id))->image_4;
                //tidak hapus jika nama image_4 'default'
                if ($prev_image_4_name !== 'default.png') {
                    $this->delete_files($prev_image_4_name, 'images/products/');
                }

                //upload image_4
                $image_name_4 = $this->do_upload(1, $input['code'], 'image_4', '4', 'images/products/');
            } else {
                $image_name_4 = $this->products_m->get(array('id' => $id))->image_4;
            }

			//update ke db
			$query = $this->products_m
			->from_form(NULL, array(
				 'category_id' => $input['category_id'],
				'producer_id' => $input['producer_id'],
				'tax' => $input['tax'],
				'image_1' => $image_name_1,
				'image_2' => $image_name_2,
				'image_3' => $image_name_3,
				'image_4' => $image_name_4,
				), array('id' => $id))
			->update();
			if ($query === FALSE) {
				$this->message('Produk gagal disunting.', 'warning');
			}else{
				$this->message('Produk berhasil disunting.', 'success');
			}
		}
		$this->go('produk');
	}

	public function hapus($code = NULL)
	{
		if (is_null($code) || empty($code)) {
			$this->message('Produk tidak ditemukan.', 'warning');
		}else{
			//hapus semua gambar yang berhubungan dengan produk yg akan dihapus
			//ambil semua nama file gambar pada produk yg bersangkutan
			$images_name = array_values($this->products_m->fields('image_1, image_2, image_3, image_4')->as_array()->get(array('code' => $code)));

			//hapus elemen pada array images_name yang mempunyai nilai 'default.png'
			foreach (array_keys($images_name, 'default.png') as $key) {
				unset($images_name[$key]);
			}

			$images_name = array_values($images_name);

			//hapus file gambar produk
			for ($i=0; $i <sizeof($images_name) ; $i++) { 
				$this->delete_files($images_name[$i], 'images/products/');
			}

			// hapus produk
			$query = $this->products_m->delete(array('code' => $code));
			if ($query === FALSE) {
				$this->message('Terjadi kesalahan sistem saat menghapus produk! Coba lagi nanti.', 'danger');
			}else{
				$this->message('Produk berhasil dihapus', 'success');
			}
		}
		$this->go('produk');
	}

    public function arsip($row = NULL)
    {
        if (empty($row)) {
            $row = 20;
        } elseif ($this->uri->segment(2) == "search") {
            $row = 20;
        }

        $filter 	= $this->session->userdata('filter_product_a');
        $order_by 	= $this->session->userdata('ob_product_a');
        $order_type = $this->session->userdata('ot_product_a');

        $this->load->database();
        $jumlah_data = $this->products_m
            ->where($filter, 'like', '%')
            ->where('archived', '1')
            ->order_by($order_by, $order_type)
            ->with_category('fields:name')
            ->with_category('order_by:name,asc')
            ->with_producer('fields:name')
            ->count_rows();

        $this->load->library('pagination');
        $config['base_url'] = base_url().'/produk/arsip/'.$row.'/';
        $config['total_rows'] = $jumlah_data;
        $config['uri_segment'] = 4;
        $config['per_page'] = $row;

        $config['full_tag_open'] = "<ul class='pagination pagination-sm' style='position:relative; top:-68px;'>";
        $config['full_tag_close'] ="</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tagl_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";

        $from = $this->uri->segment(4);
        $from = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        if ($from == 0) {
            $from = "0";
        }

        $this->pagination->initialize($config);

        $data['products'] = $this->products_m
            ->where($filter, 'like', '%')
            ->where('archived', '1')
            ->order_by($order_by, $order_type)
            ->with_category('fields:name')
            ->with_category('order_by:name,asc')
            ->with_producer('fields:name')
            ->limit($config['per_page'],$offset=$from)
            ->get_all();

        $data['categories'] = $this->categories_m
            ->fields('id,name')
            ->get_all();

        $data['producers'] = $this->producers_m
            ->fields('id,name')
            ->get_all();

        $data['row'] 		 = $row;
        $data['jumlah_data'] = $jumlah_data;
        $data['paginasi']    = $this->pagination->create_links();
        $data['filter'] 	 = $filter;
        $data['order_by']	 = $order_by;
        $data['order_type']	 = $order_type;
        $data['data_option'] = $this->session->userdata('data_option');
        $data['arsip'] = TRUE;
        $this->generateCsrf();
        $this->render('admin/products/index', $data);
	}

    public function arsipkan($code)
    {
        $update_data = array('archived'=>'1', 'code' => $code);
        $this->products_m->update($update_data, 'code');
        $this->message('Produk berhasil di arsipkan', 'success');
        $this->go('produk');
	}

    public function nonarsipkan($code)
    {
        $update_data = array('archived'=>'0', 'code' => $code);
        $this->products_m->update($update_data, 'code');
        $this->message('Produk berhasil di nonarsipkan', 'success');
        $this->go('produk/arsip');
	}

	public function check_products_usage($code){
        $this->load->model(array('order_details_m', 'cart_details_m'));
        $product = $this->products_m->where('code', $code)->get();
        $cart = $this->cart_details_m->where('product_id', $product->id)->get();
        $order = $this->order_details_m->where('product_id', $product->id)->get();
        if(!empty($cart) || !empty($order)){
            echo json_encode(array('status' => true));
        } else {
            echo json_encode(array('status' => false));
        }
    }
}