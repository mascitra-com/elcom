<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Kategori extends MY_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->redirect_if_not_admin();
		$this->load->helper(array('dump', 'potong_teks', 'cek_file', 'ambil_sub_kategori'));
		$this->load->model(array('categories_m'));

		$this->slug_config($this->categories_m->table, 'name');
	}

	public function index($row = NULL)
	{  
		if (empty($row)) {
			$row = 20;
		} 

		$filter 	= $this->session->userdata('filter_categories');
		$order_by 	= $this->session->userdata('ob_categories');
		$order_type = $this->session->userdata('ot_categories');
		
		$this->load->database(); 
		$jumlah_data = $this->categories_m;
		if(!is_null($filter['name'])){
		 $jumlah_data->where('name', 'LIKE', $filter['name']);   
		}
		$jumlah_data->order_by($order_by, $order_type);	
		if(!is_null($filter['parent_id'])){
	    	$jumlah_data->where('parent_id', $filter['parent_id']);
		}
		
		$jumlah_data = $jumlah_data->count_rows();
		

		$this->load->library('pagination'); 

		$config['total_rows'] = $jumlah_data;
		$config['per_page'] = $row; 
		$config['base_url'] = base_url().'/kategori/index/'.$row.'/';
		$config['uri_segment'] = 4;

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

		$data['categories_c'] = $this->categories_m;
			if(!empty($filter['name'])){
		 $data['categories_c']->where('name', 'LIKE', $filter['name']);   
		}
		$data['categories_c']->order_by($order_by, $order_type);

		if($filter['parent_id'] !== "NULL"){
	    	$data['categories_c']->where('parent_id', $filter['parent_id']);
        }

        $data['categories_c']->limit($config['per_page'],$offset=$from);
        $data['categories_c'] = $data['categories_c']->get_all();
		
		//ambil data kategori untuk keperluan option
		$data['sub_categories_c'] = $this->categories_m->fields('id,name')->get_all();

        $data['row'] 		 = $row;
        $data['jumlah_data'] = $jumlah_data;
        $data['paginasi']    = $this->pagination->create_links();
        $data['filter'] 	 = $filter;
        $data['order_by']	 = $order_by;
        $data['order_type']	 = $order_type;

        $this->generateCsrf();
		$this->render('admin/categories/index', $data);
	}
	public function search()
	{ 
		$filter_data 	= $this->input->post();
		$ob 			= $this->input->post('order_by');
		$ot 			= $this->input->post('order_type');

		unset($filter_data['order_by']);
		unset($filter_data['order_type']); 

		$this->session->set_userdata('ob_categories', $ob);
		$this->session->set_userdata('ot_categories', $ot); 

		$this->session->unset_userdata('filter_categories');
		$this->session->set_userdata('filter_categories', $filter_data);
		$this->go('kategori');
	}
	public function refresh()
	{
		$this->session->unset_userdata(array('filter_categories', 'ob_categories', 'ot_categories'));
		$this->go('kategori');
	}

	public function tambah()
	{
		//ambil data kategori untuk keperluan datalist
		$data['categories'] = $this->categories_m->fields('id,name')->get_all();

		$this->generateCsrf();
		$this->render('admin/categories/create', $data);
	}

	public function simpan()
	{
		$input = $this->input->post();
		
		//ambil hanya id sub
		$input['parent_id'] = $this->categories_m->splitIdAndName($input['parent_id']);
		
		//cek keberadaan data
		if (!$this->categories_m->checkDataAvailabilityById($input['parent_id'])) {
			$this->message('Terjadi kesalahan pada sistem. Ikuti format pengisian sub-kategori dengan benar');
			$this->go('kategori/create');
		}

		//menentukan level kategori baru
		$input['level'] = $this->categories_m->defineLevelCategoryByParentId($input['parent_id'], 0);
		
		$input['slug'] = $this->slug->create_uri($input);

		//jika parent_id tidak ada
		if (empty($input['parent_id'])) {
			$input['parent_id'] = NULL;
		}

		//upload banner
		$image_name = $this->do_upload(3 ,$input['slug'], 'banner_image', '', 'images/categories/');

		//insert ke db
		$query = $this->categories_m
		->from_form(NULL, array(
		    'name' => $input['name'],
			'parent_id' => $input['parent_id'],
			'slug' => $input['slug'],
			'level' => $input['level'],
			'banner_image' => $image_name
			))
		->insert();
		if ($query === FALSE) {
			$this->message('Kategori gagal ditambahkan.', 'warning');
		}else{
			$this->message('Kategori berhasil ditambahkan.', 'success');
		}

		$this->go('kategori');
	}

	public function sunting($id = NULL)
	{
		if (is_null($id) || empty($id)) {
			$this->message('Terjadi kesalahan saat mengunjungi halaman', 'danger');
			$this->go('kategori');
		}else{
			$data['category_c'] = $this->categories_m->get($id);

			$data['parent_category_id'] = $this->categories_m->get($id)->parent_id;
			$data['parent_category_name'] = $this->categories_m->get($data['parent_category_id'])->name;

			//ambil data kategori untuk keperluan datalist
			$data['categories_c'] = $this->categories_m->fields('id,name')->get_all();

			$this->generateCsrf();
			$this->render('admin/categories/edit', $data);
		}
	}

public function ubah($id = NULL)
	{
		if (is_null($id) || empty($id)) {
			$this->message('Terjadi kesalahan saat mengunjungi halaman', 'danger');
			$this->go('kategori');
		}else{
			$input = $this->input->post();

		//ambil hanya id sub
			$input['parent_id'] = $this->categories_m->splitIdAndName($input['parent_id']);

		//cek keberadaan data
			if (!$this->categories_m->checkDataAvailabilityById($input['parent_id'])) {
				$this->message('Terjadi kesalahan pada sistem. Ikuti format pengisian sub-kategori dengan benar');
				$this->go('kategori/sunting/'.$id);
			}

		//menentukan level kategori baru
			$input['level'] = $this->categories_m->defineLevelCategoryByParentId($input['parent_id'], 1, $id);

			if ($input['level'] === '0') {
				$input['parent_id'] = NULL;
			}

			$input['slug'] = $this->slug->create_uri($input);

			//hapus banner_image sebelumnya
			$prev_banner_image_name = $this->categories_m->get(array('id' => $id))->banner_image;
			//tidak hapus jika nama banner_image 'default'
			if ($prev_banner_image_name !== 'default.png') {
				$this->delete_files($prev_banner_image_name, 'images/categories/');
			}

			//upload banner
			$image_name = $this->do_upload(3 ,$input['slug'], 'banner_image', '', 'images/categories/');

		//update ke db
			$query = $this->categories_m
			->from_form(NULL, array(
				'parent_id' => $input['parent_id'],
				'slug' => $input['slug'],
				'level' => $input['level'],
				'banner_image' => $image_name
				), array('id' => $id))
			->update();
			if ($query === FALSE) {
				$this->message('Kategori gagal disunting.', 'warning');
			}else{
				$this->message('Kategori berhasil disunting.', 'success');
			}

			$this->go('kategori');
		}
	}

	public function hapus($id = NULL)
	{
		if (is_null($id) || empty($id)) {
			$this->message('Terjadi kesalahan saat mengunjungi halaman', 'danger');
		}else{
			//soft delete category
			$query = $this->categories_m->delete($id);

			//soft delete semua sub kategori dengan parent_id = id kategori induk
			// $sub_category_query = $this->categories_m->delete(array('parent_id' => $id));

			if ($query === FALSE || $sub_category_query === FALSE) {
				$this->message('Terjadi kesalahan sistem. Coba lagi nanti.','warning');
			}else{
				$this->message('Berhasil menon-aktifkan kategori dan sub-kategori yang bersangkutan','success');
			}
		}
		$this->go('kategori');
	}
}