<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Reseller_m extends MY_Model
{
	public $table = 'reseller';
	public $primary_key = 'id';
	public $protected = array('id');
  
	public function __construct()
	{
        $this->soft_deletes = TRUE;
		parent::__construct();
	}

    public function get_reseller()
    {
        $this->db->select('reseller.id, users.first_name as user_first_name, users.last_name as user_last_name, 
                                users.email, reseller.active, reseller.created_at,
                                reseller.deposit');
        $this->db->from('reseller');
        $this->db->join('users', 'users.id = reseller.user_id', 'left');
        return $this->db->get()->result();
    }

    public function get_deposit()
    {
        $this->db->select('deposit.id, users.first_name as user_first_name, users.last_name as user_last_name, 
                                users.email, deposit.account_name, deposit.account_number, deposit.bank_name, deposit.created_at,
                                deposit.nominal, deposit.status');
        $this->db->from('reseller');
        $this->db->join('users', 'users.id = reseller.user_id', 'left');
        $this->db->join('deposit', 'reseller.id = deposit.reseller_id', 'left');
        return $this->db->get()->result();
    }
}