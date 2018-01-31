<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Carts_m extends MY_Model
{
	public $table = 'carts';
	public $primary_key = 'id';

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
		// $this->has_one['organisasi'] = array('Organisasi_m', 'id', 'id_organisasi');
		// $this->soft_deletes = TRUE;
		parent::__construct();
	}

	//ambil cart id berdasarkan member id yg sedang login
	public function getCartId($member_id)
	 {
	 	$cart_id = $this->fields('id')->get(array('member_id' => $member_id))->id;
	 	
	 	return $cart_id;
	 }
}