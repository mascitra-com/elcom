<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Deposit_m extends MY_Model
{
	public $table = 'deposit';
	public $primary_key = 'id';
	public $protected = array('id');
  
	public function __construct()
	{
        $this->soft_deletes = TRUE;
		parent::__construct();
	} 
}