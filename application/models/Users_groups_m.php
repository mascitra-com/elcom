<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Users_groups_m extends MY_Model
{
	public $table = 'users_groups';
	public $primary_key = 'id';
	public $protected = array('id');

	public function __construct()
	{
		// $this->has_one['organisasi'] = array('Organisasi_m', 'id', 'id_organisasi');
		parent::__construct();
	} 
}