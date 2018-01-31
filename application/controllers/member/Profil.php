<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Profil extends MY_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->redirect_if_admin();
		$this->_accessable = FALSE;
		$this->load->model(array('users_m', 'bank_accounts_m', 'addresses_m'));
	}

	public function index()
	{
		$user_id = $this->ion_auth->get_current_user_id();

		$data['user'] = $this->users_m
		->fields('first_name, last_name, email, phone')
		->get($user_id);

		$data['bank_accounts'] = $this->bank_accounts_m
		->fields('id, account_name, account_number, account_behalf')
		->with_bank('fields:name')
		->get_all(array('user_id' => $user_id));

		$addresses = $this->addresses_m
            ->fields('id, province_id, regency_id, village, district, address_name, owner_first_name, owner_last_name, full_address, phone')
            ->get_all(array('user_id' => $user_id));
		foreach ($addresses as $key => $value){
		    $province = (Object) $this->ongkir("https://api.rajaongkir.com/starter/province?id=" .  $value->province_id);
            $addresses[$key]->province = $province->province;
            $regency = (Object) $this->ongkir("https://api.rajaongkir.com/starter/city?id=" .  $value->regency_id);
            $addresses[$key]->regency = $regency->city_name;
        }
		$data['addresses'] = $addresses;

		$this->generateCsrf();
		$this->render('member/accounts/profile', $data);
	}        

	public function tambah()
	{
		$this->render('member/address/create_address');
	}
}