<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Membership_m extends MY_Model
{
	public $table = 'membership';
	public $primary_key = 'id';
 
	public $rules = array(
		'insert' => array(
			'name' => array(
				'field' => 'name',
				'label' => 'Nama Membership',
				'rules' => 'trim|required'),
			'description' => array(
				'field' => 'description',
				'label' => 'Deskripsi Membership',
				'rules' => 'trim'),
			'discount' => array(
				'field' => 'discount',
				'label' => 'Diskon Membership',
				'rules' => 'trim|required'),
			),
		'update' => array(
            'name' => array(
                'field' => 'name',
                'label' => 'Nama Membership',
                'rules' => 'trim|required'),
            'description' => array(
                'field' => 'description',
                'label' => 'Deskripsi Membership',
                'rules' => 'trim'),
            'discount' => array(
                'field' => 'discount',
                'label' => 'Diskon Membership',
                'rules' => 'trim|required'),
			)
		);

	public function __construct()
	{
		parent::__construct();
         $this->soft_deletes = TRUE;
    }
}