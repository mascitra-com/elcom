<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Users_m extends MY_Model
{
	public $table = 'users';
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
			'first_name' => array(
				'field' => 'first_name',
				'label' => 'Nama Pertama',
				'rules' => 'trim|required|min_length[3]|max_length[50]'),
			'last_name' => array(
				'field' => 'last_name',
				'label' => 'Nama Terakhir',
				'rules' => 'trim|required|min_length[3]|max_length[50]')
			),
		'updated_by' => array(
			'field' => 'updated_by',
			'label' => 'Nama Terakhir',
			'rules' => 'trim|required|min_length[3]|max_length[50]')
		,
		);

	public function __construct()
	{
		 $this->has_many_pivot['membership'] =  array(
             'foreign_model'=>'Membership_m',
             'pivot_table'=>'users_membership',
             'local_key'=>'id',
             'pivot_local_key'=>'user_id', /* this is the related key in the pivot table to the local key
		        this is an optional key, but if your column name inside the pivot table
		        doesn't respect the format of "singularlocaltable_primarykey", then you must set it. In the next title
		        you will see how a pivot table should be set, if you want to  skip these keys */
             'pivot_foreign_key'=>'membership_id', /* this is also optional, the same as above, but for foreign table's keys */
             'foreign_key'=>'id',
             'get_relate'=>TRUE /* another optional setting, which is explained below */
         );
		 $this->has_one['reseller'] = array('Reseller_m', 'user_id', 'id');
		 $this->has_many['users_membership'] = array('Users_membership_m', 'user_id', 'id');
		$this->soft_deletes = TRUE;
		parent::__construct();
	} 
}