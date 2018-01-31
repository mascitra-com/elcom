<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Bank_accounts_m extends MY_Model
{
	public $table = 'users_banks';
	public $primary_key = 'id';
	public $protected = array('id');
  
	public function __construct()
	{
		$this->has_one['bank'] = array('Banks_m', 'id', 'bank_id');
		parent::__construct();
	} 
}