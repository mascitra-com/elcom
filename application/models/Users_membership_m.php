<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Users_membership_m extends MY_Model
{
	public $table = 'users_membership';
	public $primary_key = 'id';
 
	public $rules = array(
		'insert' => array(
			'user' => array(
				'field' => 'user',
				'label' => 'E-mail / Nama Member',
				'rules' => 'trim|required'),
			'membership' => array(
				'field' => 'membership_id',
				'label' => 'Deskripsi Membership',
				'rules' => 'required')
			),
		'update' => array(
            'user' => array(
                'field' => 'user',
                'label' => 'E-mail / Nama Member',
                'rules' => 'trim|required'),
            'membership' => array(
                'field' => 'membership_id',
                'label' => 'Deskripsi Membership',
                'rules' => 'required')
			)
		);

	public function __construct()
	{
		parent::__construct();
         $this->soft_deletes = TRUE;
         $this->has_many['users'] = array('Users_m', 'id', 'user_id');
         $this->has_many['membership'] = array('Membership_m', 'id', 'membership_id');
    }

    public function get_member()
    {
        $this->db->from('users_membership');
        $this->db->join('users', 'users.id = users_membership.user_id', 'left');
        $this->db->join('membership', 'membership.id = users_membership.membership_id', 'left');
        return $this->db->get()->result();
    }
}