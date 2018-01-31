<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Pages_m extends MY_Model
{
	public $table = 'pages';
	public $primary_key = 'id';
	public $protected = array('id');

	public $rules = array(
		'insert' => array(
			'name' => array(
				'field' => 'name',
				'label' => 'Nama Halaman',
				'rules' => 'trim|required|max_length[100]'),
			'content' => array(
				'field' => 'content',
				'label' => 'Konten Halaman',
				'rules' => 'trim'),
			'section' => array(
				'field' => 'section',
				'label' => 'Section Halaman',
				'rules' => 'trim|required'),
			),
		'update' => array(
			'name' => array(
				'field' => 'name',
				'label' => 'Nama Halaman',
				'rules' => 'trim|required|max_length[100]'),
			'content' => array(
				'field' => 'content',
				'label' => 'Konten Halaman',
				'rules' => 'trim'),
			'section' => array(
				'field' => 'section',
				'label' => 'Section Halaman',
				'rules' => 'trim|required'),
			)
		);

	public function __construct()
	{
		// $this->has_one['organisasi'] = array('Organisasi_m', 'id', 'id_organisasi');
		// $this->soft_deletes = TRUE;
		parent::__construct();
	} 
}