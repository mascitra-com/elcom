<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Daftar extends MY_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->redirect_if_admin();
		$this->_accessable = TRUE;
		$this->load->helper(array('potong_teks', 'cek_file'));
		$this->load->model(array('users_m', 'users_groups_m','carts_m'));
	}

	public function index()
	{
		$this->generateCsrf();
		$this->render('member/accounts/register');
	}

	public function simpan()
	{
		$this->load->model('carts_m');
		$this->load->library('bcrypt');
		$input =  $this->input->post();

		//insert ke tabel users
		$query = $this->users_m
		->from_form(NULL, array(
			'email' => $input['email'],
			'phone' => '+62'.$input['phone'],
			'password' => $this->bcrypt->hash(($input['password'])),
			'active' => '1',
			'created_by' => '0'
		))
		->insert();

		//insert ke users_groups
		$query_groups = $this->users_groups_m->insert(array(
			'user_id' => $query,
			'group_id' => 2
		));

		// tambah cart
		$cart = array(
			'id' => $this->users_m->get_last_id("CRT",10),
			'member_id' => $query,
			);
		$insert_cart = $this->carts_m->insert($cart);

		if ($query === FALSE && $insert_cart === FALSE) {
			$this->message('Terjadi kesalahan sistem saat melakukan pendaftaran. Coba lagi nanti.');
			$this->go('member/daftar');
		}else{
			$this->message('Pendaftaran berhasil! Silahkan Login.');
			$this->go('member/daftar');
		}
	}         

	public function update() {  
		$input =  $this->input->post();

 		$update = $this->users_m->from_form()
			->update();     

        if ($update === FALSE) {  
            $this->message('Data Gagal di Ubah', 'warning');
            $this->go("member/profil"); 
        } else {
            $this->message('Data Berhasil di Ubah', 'success');
            $this->go("member/profil");
        }    
	}

    public function reseller()
    {
        $this->load->model(array('users_m', 'bank_accounts_m'));
        $data['user'] = $this->users_m->get($this->ion_auth->get_current_user_id());
        $data['banks'] = $this->bank_accounts_m->where('user_id', $this->ion_auth->get_current_user_id())->get_all();

        $this->generateCsrf();
        $this->render('member/accounts/reseller_form', $data);
	}
}