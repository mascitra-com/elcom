<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Membership extends MY_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->redirect_if_not_admin();
		$this->load->model(array('membership_m', 'users_membership_m', 'users_m'));
        $this->slug_config($this->membership_m->table, 'name');
    }

	public function index($row  = NULL)
	{
		if (empty($row)) {
			$row = 20;
		} 

		$filter 	= $this->session->userdata('filter_membership');
		$order_by 	= $this->session->userdata('ob_membership');
		$order_type = $this->session->userdata('ot_membership');

		$this->load->database(); 
		$jumlah_data = $this->membership_m
		->count_rows();

		$this->load->library('pagination'); 

		$config['total_rows'] = $jumlah_data;
		$config['per_page'] = $row; 
		$config['base_url'] = base_url().'/admin/membership/index/'.$row;
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

		$data['membership'] = $this->membership_m
		->limit($config['per_page'], $offset=$from)
		->get_all();

		$data['row'] 		 = $row;
		$data['jumlah_data'] = $jumlah_data;
		$data['paginasi']    = $this->pagination->create_links();
		$data['filter'] 	 = $filter;
		$data['order_by']	 = $order_by;
		$data['order_type']	 = $order_type; 

		$this->generateCsrf();
		$this->render('admin/membership/index', $data);
	}

	public function tambah()
	{
		$this->generateCsrf();
		$this->render('admin/membership/create');
	}

	public function simpan()
	{
		$input = $this->input->post();

		//cek keberadaan kode
		$already_exist = $this->membership_m->get(array('name' => $input['name']));
		if ($already_exist) {
			$this->message('Nama membership sudah ada!', 'warning');
			$this->go('membership/tambah');
		}else{
			$input['discount'] = $input['discount'] / 100;

			$insert = $this->membership_m
			->from_form(NULL, array(
				'discount' => $input['discount'],
				))->insert();

			if ($insert === FALSE) {
				$this->message('Terjadi kesalahan sistem saat menambahkan membership baru. Coba lagi nanti.', 'danger');
				$this->go('membership/tambah');
			}else{
                $this->message('Membership berhasil ditambahkan', 'success');
                $this->go('membership');
			}
		}
	}

	public function sunting($id = NULL)
	{
		if (is_null($id) || empty($id)) {
			$this->message('Membership tidak ditemukan.', 'warning');
			$this->go('membership');
		}else{
			$data['membership'] = $this->membership_m->get($id);

			$this->generateCsrf();
			$this->render('admin/membership/edit', $data);
		}
	}

	public function ubah($id = NULL)
	{
		if (is_null($id) || empty($id)) {
			$this->message('Membership tidak ditemukan.', 'warning');
		}else{
			$update = $this->input->post();
			//cek keberadaan kode
			//ambil code data sebelumnya
			$prev_code = $this->membership_m->get($id)->name;
			$already_exist = $this->membership_m->get(array('name' => $update['name']));

			if (($update['name'] != $prev_code) && $already_exist) {
				$this->message('Membership sudah ada!', 'warning');
			}else{
				$update['discount'] = $update['discount'] / 100;
				//update ke promos
				$query = $this->membership_m
				->from_form(NULL, array(
					'discount' => $update['discount'],
					), array('id' => $id))
				->update();

				if ($query === FALSE) {
					$this->message('Terjadi kesalahan pada sistem saat mengubah membership. Coba lagi nanti.', 'danger');
				}else{
					$this->message('Sukses mengubah membership.', 'success');
				}
			}
		}
		$this->go('membership');
	}

	public function hapus($id = NULL)
	{
	    // TODO Diberikan pilihan akan di alihkan kemana anggota membership yg saat ini aktif
		if (is_null($id) || empty($id)) {
			$this->message('Membership tidak ditemukan.', 'warning');
		}else{
			$delete = $this->membership_m->delete($id);
			if ($delete === FALSE) {
				$this->message('Terjadi kesalahan pada sistem saat menghapus membership. Coba lagi nanti.', 'danger');
			}else{
				$this->message('Membership berhasil dihapus.', 'success');
			}
		}
		$this->go('membership');
	}

    public function users()
    {
        $data['members'] = $this->users_membership_m->get_member();
        $data['row'] = $this->users_membership_m->count_rows();
        $data['jumlah_data'] = $this->users_membership_m->count_rows();
        $this->render('admin/membership/members', $data);
	}

    public function add_member()
    {
        $data['users'] = $this->users_m->get_all();
        $data['membership'] = $this->membership_m->get_all();

        $this->generateCsrf();
        $this->render('admin/membership/add_member', $data);
    }

    public function store_member()
    {
        $input = $this->input->post();
        $email = str_replace(' ', '', substr($input['user'], 0, strpos($input['user'], '|')));
        $user = $this->users_m->where('email', $email)->get();
        // Cek Apakah Sudah Menjadi Member
        if($user === FALSE){
            $this->message('Maaf, user/email yang anda coba tambahkan tidak terdaftar dalam sistem.', 'danger');
            $this->go('membership/users');
        }
        if($this->users_membership_m->where('user_id', $user->id)->get()){
            $this->message('Maaf, user/email yang anda coba tambahkan sudah terdaftar sebagai member.', 'danger');
            $this->go('membership/users');
        }
        unset($input['user']);
        $input['user_id'] = $user->id;
        $input['start'] = date('Y-m-d', strtotime($input['start']));
        $input['end'] = date('Y-m-d', strtotime($input['end']));
        $input['created_by'] = $this->ion_auth->get_current_user_id();
        if($this->users_membership_m->insert($input)){
            $this->message('Member baru berhasil ditambahkan', 'success');
            $this->go('membership/users');
        }else{
            $this->message('Terjadi kesalahan sistem saat menambahkan member baru. Coba lagi nanti.', 'danger');
            $this->go('membership/add_member');
        }
    }

    public function edit_member($user_id)
    {
        $data['member'] = $this->users_membership_m->where('user_id', $user_id)->get();
        $data['membership'] = $this->membership_m->get_all();
        $this->generateCsrf();
        $this->render('admin/membership/edit_member', $data);
    }

    public function update_member()
    {
        $update_data = $this->input->post();
        if($this->users_membership_m->update($update_data, 'id')){
            $this->message('Data member berhasil di ubah', 'success');
        }else{
            $this->message('Terjadi kesalahan sistem saat mengubah data member. Coba lagi nanti.', 'danger');
        }
        $this->go('membership/users');
    }

    public function delete_member($id)
    {
        $member = $this->users_membership_m->where('user_id', $id)->get();
        if($this->users_membership_m->force_delete($member->id)){
            $this->message('Data member berhasil di hapus', 'success');
        }else{
            $this->message('Terjadi kesalahan sistem saat menghapus data member. Coba lagi nanti.', 'danger');
        }
        $this->go('membership/users');
    }
}