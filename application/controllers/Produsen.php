<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Produsen extends MY_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->redirect_if_not_admin();
		$this->load->helper(array('dump', 'potong_teks', 'cek_file'));
		$this->load->model(array('producers_m'));

		$this->slug_config($this->producers_m->table, 'name');
	}

	public function index($row = NULL)
	{
		if (empty($row)) {
			$row = 20;
		}

        $filter 	= $this->session->userdata('filter_producer');
        $order_by 	= $this->session->userdata('ob_producer');
        $order_type = $this->session->userdata('ot_producer');

		$this->load->database(); 
		$jumlah_data = $this->producers_m
            ->where($filter, 'like', '%')
	        ->order_by($order_by, $order_type)
	        ->count_rows();

		$this->load->library('pagination');
		$config['base_url'] = base_url().'/produsen/index/'.$row.'/';
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
 
		$data['producer'] = $this->producers_m  
            ->where($filter, 'like', '%')
	        ->order_by($order_by, $order_type)	
			->limit($config['per_page'],$offset=$from)  
			->get_all();

		$data['row'] 		 = $row;
		$data['jumlah_data'] = $jumlah_data;
		$data['paginasi']    = $this->pagination->create_links();
		$data['filter'] 	 = $filter;
		$data['order_by']	 = $order_by;
		$data['order_type']	 = $order_type; 
 
        $this->generateCsrf();
		$this->render('admin/producers/index', $data);
	}
    public function search()
    { 
        $filter_data 	= $this->input->post();
        $ob 			= $this->input->post('order_by');
        $ot 			= $this->input->post('order_type');
  
        // dump($filter_data);
        unset($filter_data['order_by']);
        unset($filter_data['order_type']); 

        $this->session->set_userdata('ob_producer', $ob);
        $this->session->set_userdata('ot_producer', $ot); 

        $this->session->unset_userdata('filter_producer');
        $this->session->set_userdata('filter_producer', $filter_data);
        $this->go('produsen');
    }
    public function refresh()
    {
        $this->session->unset_userdata(array('filter_producer', 'ob_producer', 'ot_producer'));
        $this->go('produsen');
    }

	public function tambah()
	{  
		$this->generateCsrf();
		$this->render('admin/producers/create');
	}

	public function simpan()
	{
		$input['data'] = $this->input->post();

		$slug 		 = $this->slug->create_uri($input['data']);
		$input['slug'] = array( 'slug' => $slug );

		$file_name 	 = $this->upload_foto($slug);

		if (!empty($file_name)) {
			$input['image'] = array(
				'image' => $file_name, 
			); 
		}  

		$data = array_merge($input['data'], $input['image'], $input['slug']);  
		$insert = $this->producers_m->insert($data); 
  
		if ($insert === FALSE) {
			$this->message('Kategori gagal ditambahkan.', 'warning');
		}else{
			$this->message('Kategori berhasil ditambahkan.', 'success');
		}

		$this->go('produsen');
	}

	public function sunting($id = NULL)
	{
		if (is_null($id) || empty($id)) {
			$this->message('Terjadi kesalahan saat mengunjungi halaman', 'danger');
			$this->go('Produsen');
		}else{   
			$data['producer'] = $this->producers_m->fields('id,name,description,image')->where('id',$id)->get();

			$this->generateCsrf();
			$this->render('admin/producers/edit', $data);
		}
	}

	public function ubah()
	{ 
		$id 		   = $this->input->post('id');
		$input['data'] = $this->input->post();

		$slug 		   = $this->slug->create_uri($input['data']);
		$input['slug'] = array( 'slug' => $slug );

		$file_name 	 = $this->upload_foto($slug);

		// pengecekan gambar ada atau tidak
		if (!empty($file_name)) {
			$input['image'] = array(
				'image' => $file_name, 
			); 
			$data = array_merge($input['data'], $input['image'], $input['slug']);   
		} else {
			$data = array_merge($input['data'], $input['slug']);    
		}  

		$insert = $this->producers_m->update($data, array('id' => $id)); 
 
		if ($insert === FALSE) {
			$this->message('Produsen gagal disunting.', 'warning');
		}else{
			$this->message('Produsen berhasil disunting.', 'success');
		}

		$this->go('Produsen'); 
	} 

	public function hapus($id)
	{  
		$this->producers_m->delete($id);  
 		$this->go("Produsen/index"); 
	}

	public function selengkapnya($id = NULL)
	{
		if (is_null($id) || empty($id)) {
			$this->message('Terjadi kesalahan saat mengunjungi halaman', 'danger');
			$this->go('Produsen');
		}else{   
			$data['producer'] = $this->producers_m->fields('id,name,description,image')->where('id',$id)->get();

			$this->generateCsrf();
			$this->render('admin/producers/show', $data);
		}
	}

	function upload_foto($slug){
		$set_name 	= fileName(0, $slug, NULL, 3);
		$path 		= $_FILES['foto']['name'];
        if (empty($path)) {
			return NULL;
		}
		$extension  = ".".pathinfo($path, PATHINFO_EXTENSION); 

		$config['upload_path']          = './assets/images/producers/';
		$config['allowed_types']        = 'jpg|png';
		$config['max_size']             = 1024;
		$config['file_name']            = $set_name.$extension;
        $config['encrypt_name'] = TRUE;
		$this->load->library('upload', $config);
		  // proses upload
		$upload = $this->upload->do_upload('foto');

		if ($upload == FALSE) { 
 			$this->message($this->upload->display_errors(), 'warning');
		}
        $upload = $this->upload->data();
        return $upload['file_name'];
	}
}