<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Order_details_m extends MY_Model
{
	public $table = 'order_details';
	public $primary_key = 'id';
	public $protected = array('id');

	// public $rules = array(
	// 	'insert' => array(
	// 		'bank_account_id' => array(
	// 			'field' => 'bank_account_id',
	// 			'label' => 'Metode Pembayaran',
	// 			'rules' => 'trim|required'),
	// 		'ship_agent_id' => array(
	// 			'field' => 'ship_agent_id',
	// 			'label' => 'Jasa Pengiiman',
	// 			'rules' => 'trim|required'),
	// 		'ship_price' => array(
	// 			'field' => 'ship_price',
	// 			'label' => 'Ongkos Kirim',
	// 			'rules' => 'trim|required|numeric'),
	// 		'total_products_price_without_tax' => array(
	// 			'field' => 'total_products_price_without_tax',
	// 			'label' => 'Total harga semua produk',
	// 			'rules' => 'trim|required|numeric'),
	// 		'total_tax' => array(
	// 			'field' => 'total_tax',
	// 			'label' => 'Total pajak',
	// 			'rules' => 'trim|required|numeric'),
	// 		'total_all' => array(
	// 			'field' => 'total_all',
	// 			'label' => 'Total',
	// 			'rules' => 'trim|required|numeric'),
	// 		),
	// 	'update' => array(
	// 		'name' => array(
	// 			'field' => 'name',
	// 			'label' => 'Nama Produk',
	// 			'rules' => 'trim|required|min_length[3]|max_length[50]'),
	// 		'description' => array(
	// 			'field' => 'description',
	// 			'label' => 'Deskripsi Produk',
	// 			'rules' => 'trim')
	// 		)
	// 	);

	public function __construct()
	{
		$this->has_one['product'] = array('Products_m', 'id', 'product_id');
		// $this->has_many['senyum_accounts'] = array('Senyum_accounts_m', 'bank_id', 'id');
		parent::__construct();
	} 
}