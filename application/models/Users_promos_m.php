<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Users_promos_m extends MY_Model
{
	public $table = 'users_promos';
	public $primary_key = 'id';

	public function __construct()
	{
		// $this->has_one['senyum_bank_account'] = array('Senyum_accounts_m', 'id', 'bank_account_id');
		// $this->has_many['order_details'] = array('Order_details_m', 'order_id', 'id');
		// $this->has_one['member'] = array('users_m', 'id', 'member_id');

		parent::__construct();
	} 
}