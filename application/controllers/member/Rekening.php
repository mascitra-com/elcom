<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Rekening extends MY_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->redirect_if_admin();
		$this->_accessable = FALSE;
		$this->load->helper(array('potong_teks', 'cek_file'));
		$this->load->model(array('bank_accounts_m','banks_m'));
	}

	public function index()
	{
		$this->render('member/banks/addresses');
	}

	public function tambah()
	{
		$data['banks'] = $this->banks_m->get_all();
		$data['user']  = $this->ion_auth->user()->row(); 

 		$this->generateCsrf();
		$this->render('member/banks/create_banks', $data);
	} 
	public function save()
	{
		$input['data'] = $this->input->post();  
		$insert = $this->bank_accounts_m->insert($input); 

		if ($insert === FALSE) {
			$this->message('Rekening gagal ditambahkan.', 'warning');
			$this->go('member/profil');
		}else{
			$this->message('Rekening berhasil ditambahkan.', 'success');
			$this->go('member/profil');
		}
	} 

	public function sunting($id = NULL)
	{
		if (is_null($id) || empty($id)) {
			$this->message('Terjadi kesalahan saat mengunjungi halaman', 'danger');
			$this->go('member/profil');
		}else{   
			$data['banks'] = $this->banks_m->get_all();
			$data['data']  = $this->bank_accounts_m->fields('id,bank_id,account_number,account_name,account_behalf')->where('id',$id)->get();

			$this->generateCsrf();
			$this->render('member/banks/edit_banks', $data);
		}
	}
    public function update()
    {  
        $id            = $this->input->post('id');
        $input['data'] = $this->input->post();

        $update = $this->bank_accounts_m->update($input['data'], $id);  
        if ($update === FALSE) {  
            $this->message('Data Gagal di Ubah', 'warning');
            $this->go("member/profil"); 
        } else {
            $this->message('Data Berhasil di Ubah', 'success');
            $this->go("member/profil");
        }    
    }

	public function hapus($id)
	{  
		$this->bank_accounts_m->delete($id);  
 		$this->go("member/profil"); 
	}
}