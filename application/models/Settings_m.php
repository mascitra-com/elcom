<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Settings_m extends MY_Model
{
	public $table = 'settings';
	public $primary_key = 'id';

	public $rules = array(
		'update' => array(
			'website_email' => array(
				'field' => 'website_email',
				'label' => 'Email',
				'rules' => 'trim|max_length[255]'),
			'website_phone' => array(
				'field' => 'website_phone',
				'label' => 'Nomor telepon',
				'rules' => 'trim|max_length[30]'),
			'website_facebook' => array(
				'field' => 'website_facebook',
				'label' => 'Facebook',
				'rules' => 'trim|max_length[255]'),
			'website_twitter' => array(
				'field' => 'website_twitter',
				'label' => 'Twitter',
				'rules' => 'trim|max_length[255]'),
			'website_instagram' => array(
				'field' => 'website_instagram',
				'label' => 'Instagram',
				'rules' => 'trim|max_length[255]'),
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