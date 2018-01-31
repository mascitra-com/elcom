<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Orders_m extends MY_Model
{
	public $table = 'orders';
	public $primary_key = 'id';
 
	public $rules = array(
		'insert' => array(
			'bank_account_id' => array(
				'field' => 'bank_account_id',
				'label' => 'Metode Pembayaran',
				'rules' => 'trim|required'),
			'ship_agent' => array(
				'field' => 'ship_agent',
				'label' => 'Jasa Pengiiman',
				'rules' => 'trim|required'),
			'ship_price' => array(
				'field' => 'ship_price',
				'label' => 'Ongkos Kirim',
				'rules' => 'trim|required|numeric'),
			'total_products_price_without_tax' => array(
				'field' => 'total_products_price_without_tax',
				'label' => 'Total harga semua produk',
				'rules' => 'trim|required|numeric'),
			'total_tax' => array(
				'field' => 'total_tax',
				'label' => 'Total pajak',
				'rules' => 'trim|required|numeric'),
			'total_all' => array(
				'field' => 'total_all',
				'label' => 'Total',
				'rules' => 'trim|required|numeric'),
			),
		'update' => array(
			'name' => array(
				'field' => 'name',
				'label' => 'Nama Produk',
				'rules' => 'trim|required|min_length[3]|max_length[50]'),
			'description' => array(
				'field' => 'description',
				'label' => 'Deskripsi Produk',
				'rules' => 'trim')
			)
		);

	public function __construct()
	{
		$this->has_one['senyum_bank_account'] = array('Senyum_accounts_m', 'id', 'bank_account_id');
		$this->has_many['order_details'] = array('Order_details_m', 'order_id', 'id');
		$this->has_one['member'] = array('users_m', 'id', 'member_id');

		$this->soft_deletes = TRUE;
		parent::__construct();
	} 
}