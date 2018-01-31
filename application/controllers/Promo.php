<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Promo extends MY_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->redirect_if_not_admin();
		// $this->load->helper(array(''));
		$this->load->model(array('promos_m', 'users_promos_m', 'users_m'));
	}

	public function index($row  = NULL)
	{
		if (empty($row)) {
			$row = 20;
		} 

		$filter 	= $this->session->userdata('filter_categories');
		$order_by 	= $this->session->userdata('ob_categories');
		$order_type = $this->session->userdata('ot_categories');

		$this->load->database(); 
		$jumlah_data = $this->promos_m
		->where($filter, 'like', '%')
		->order_by($order_by, $order_type)	
		->count_rows();

		$this->load->library('pagination'); 

		$config['total_rows'] = $jumlah_data;
		$config['per_page'] = $row; 
		$config['base_url'] = base_url().'/promo/index/'.$row;  
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

		$data['promos'] = $this->promos_m  
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
		$this->render('admin/promos/index', $data);
	}

	public function tambah()
	{
		$this->generateCsrf();
		$this->render('admin/promos/create');
	}

	public function simpan()
	{
		$input = $this->input->post();

		//cek keberadaan kode
		$already_exist_code = $this->promos_m->get(array('code' => $input['code']));
		if ($already_exist_code) {
			$this->message('Kode promo/voucher sudah ada!', 'warning');
			$this->go('promo/tambah');
		}else{
			//kode belum ada
			if (empty($input['end_date'])) {
				$input['end_date'] = NULL;
			}

			if (empty($input['max_use']) || $input['max_use'] == 0) {
				$input['max_use'] = NULL;
			}

			$input['discount'] = $input['discount'] / 100;

			$insert = $this->promos_m
			->from_form(NULL, array(
				'discount' => $input['discount'],
				'max_use' => $input['max_use'],
				'end_date' => $input['end_date']
				))->insert();

			if ($insert === FALSE) {
				$this->message('Terjadi kesalahan sistem saat menambahkan promo baru. Coba lagi nanti.', 'danger');
				$this->go('promo/tambah');
			}else{
				//insert semua member ke users_promo
				$user_ids = $this->users_m->fields('id')->where('id <>', 1)->get_all();

				$insert_batch = array();

				foreach ($user_ids as $user_id) {
					array_push($insert_batch, array(
						'user_id' => $user_id->id,
						'promo_id' => $insert,
						'remaining_use' => $input['max_use']
						));
				}
				$insert = $this->users_promos_m->insert($insert_batch);

				if ($insert === FALSE) {
					$this->message('Terjadi kesalahan sistem saat menambahkan semua member untuk menggunakan promo. Coba lagi nanti.', 'danger');
					$this->go('promo/tambah');
				}else{
					$this->message('Promo berhasil ditambahkan', 'success');
					$this->go('promo');
				}
			}
		}
	}

	public function sunting($id = NULL)
	{
		if (is_null($id) || empty($id)) {
			$this->message('Promo/Voucher tidak ditemukan.', 'warning');
			$this->go('promo');
		}else{
			$data['promo'] = $this->promos_m->get($id);		

			$this->generateCsrf();
			$this->render('admin/promos/edit', $data);
		}
	}

	public function ubah($id = NULL)
	{
		if (is_null($id) || empty($id)) {
			$this->message('Promo/Voucher tidak ditemukan.', 'warning');
		}else{
			$update = $this->input->post();

			//cek keberadaan kode
			//ambil code data sebelumnya
			$prev_code = $this->promos_m->get($id)->code;
			$already_exist_code = $this->promos_m->get(array('code' => $update['code']));

			if (($update['code'] != $prev_code) && $already_exist_code) {
				$this->message('Kode promo/voucher sudah ada!', 'warning');
			}else{
			//kode belum ada
				if (empty($update['end_date'])) {
					$update['end_date'] = NULL;
				}

				if (empty($update['max_use']) || $update['max_use'] == 0) {
					$update['max_use'] = NULL;
				}

				$update['discount'] = $update['discount'] / 100;

				//update ke promos
				$query = $this->promos_m
				->from_form(NULL, array(
					'discount' => $update['discount'],
					'max_use' => $update['max_use'],
					'end_date' => $update['end_date']
					), array('id' => $id))
				->update();

				if ($query === FALSE) {
					$this->message('Terjadi kesalahan pada sistem saat mengubah promo. Coba lagi nanti.', 'danger');
				}else{
					$this->message('Sukses mengubah promo.', 'success');
				}
			}
		}
		$this->go('promo');
	}

	public function hapus($id = NULL)
	{
		if (is_null($id) || empty($id)) {
			$this->message('Promo tidak ditemukan.', 'warning');
		}else{
			$delete = $this->promos_m->delete($id);
			if ($delete === FALSE) {
				$this->message('Terjadi kesalahan pada sistem saat menghapus promo. Coba lagi nanti.', 'danger');
			}else{
				$this->message('Promo berhasil dihapus.', 'success');
			}
		}
		$this->go('promo');
	}


	//AJAX Requests
	public function generateCode()
	{
		$promo_code = $this->promos_m->get_last_id("PRM", 8);
		echo json_encode($promo_code);
	}
}