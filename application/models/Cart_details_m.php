<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Cart_details_m extends MY_Model
{
	public $table = 'cart_details';
	public $primary_key = 'id';
	public $protected = array('id');

	// public $rules = array(
	// 	'insert' => array(
	// 		'name' => array(
	// 			'field' => 'name',
	// 			'label' => 'Nama Produk',
	// 			'rules' => 'trim|required|max_length[255]'),
	// 		'description' => array(
	// 			'field' => 'description',
	// 			'label' => 'Deskripsi Produk',
	// 			'rules' => 'trim')
	// 		),
	// 	'update' => array(
	// 		'name' => array(
	// 			'field' => 'name',
	// 			'label' => 'Nama Produk',
	// 			'rules' => 'trim|required|max_length[255]'),
	// 		'description' => array(
	// 			'field' => 'description',
	// 			'label' => 'Deskripsi Produk',
	// 			'rules' => 'trim')
	// 		)
	// 	);

	public function __construct()
	{
		$this->has_one['product'] = array('Products_m', 'id', 'product_id');
		// $this->soft_deletes = TRUE;
		parent::__construct();
	}
}