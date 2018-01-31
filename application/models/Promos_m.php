<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Promos_m extends MY_Model
{
	public $table = 'promos';
	public $primary_key = 'id';
 
	public $rules = array(
		'insert' => array(
			'code' => array(
				'field' => 'code',
				'label' => 'Kode Promo/Voucher',
				'rules' => 'trim|required'),
			'name' => array(
				'field' => 'name',
				'label' => 'Nama Promo',
				'rules' => 'trim|required'),
			'description' => array(
				'field' => 'description',
				'label' => 'Deskripsi Promo',
				'rules' => 'trim'),
			),
		'update' => array(
			'code' => array(
				'field' => 'code',
				'label' => 'Kode Promo/Voucher',
				'rules' => 'trim|required'),
			'name' => array(
				'field' => 'name',
				'label' => 'Nama Promo',
				'rules' => 'trim|required'),
			'description' => array(
				'field' => 'description',
				'label' => 'Deskripsi Promo',
				'rules' => 'trim'),
			)
		);

	public function __construct()
	{
		// $this->has_one['senyum_bank_account'] = array('Senyum_accounts_m', 'id', 'bank_account_id');
		// $this->has_many['order_details'] = array('Order_details_m', 'order_id', 'id');
		// $this->has_one['member'] = array('users_m', 'id', 'member_id');

		parent::__construct();
	} 
}