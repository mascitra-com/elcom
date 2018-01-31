<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Regencies_m extends MY_Model
{
	public $table = 'regencies';
	public $primary_key = 'id';
	public $protected = array('id');

	public $rules = array(
		'insert' => array(
			'first_name' => array(
				'field' => 'first_name',
				'label' => 'Nama Pertama',
				'rules' => 'trim|required|min_length[3]|max_length[50]'),
			'last_name' => array(
				'field' => 'last_name',
				'label' => 'Nama Terakhir',
				'rules' => 'trim|required|min_length[3]|max_length[50]')
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
		// $this->has_one['province'] = array('Provinces_m', 'id', 'province_id');
		
		parent::__construct();
	} 
}