<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Banks_m extends MY_Model
{
	public $table = 'banks';
	public $primary_key = 'id';
	public $protected = array('id');

	// public $rules = array(
	// 	'insert' => array(
	// 		'first_name' => array(
	// 			'field' => 'first_name',
	// 			'label' => 'Nama Pertama',
	// 			'rules' => 'trim|required|min_length[3]|max_length[50]'),
	// 		'last_name' => array(
	// 			'field' => 'last_name',
	// 			'label' => 'Nama Terakhir',
	// 			'rules' => 'trim|required|min_length[3]|max_length[50]')
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
		// $this->has_one['organisasi'] = array('Organisasi_m', 'id', 'id_organisasi');
		$this->has_many['senyum_accounts'] = array('Senyum_accounts_m', 'bank_id', 'id');
		parent::__construct();
	} 
}