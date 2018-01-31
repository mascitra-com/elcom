<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Senyum_accounts_m extends MY_Model
{
	public $table = 'senyum_bank_accounts';
	public $primary_key = 'id';
	public $protected = array('id');
  
	public function __construct()
	{
		$this->has_one['bank'] = array('Banks_m', 'id', 'bank_id');
		parent::__construct();
	} 
}