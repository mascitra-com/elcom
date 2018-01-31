<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Pelanggan_berita_m extends MY_Model
{
	public $table = 'subscribers';
	public $primary_key = 'id';

    public $rules = array(
        'insert' => array(
            'email' => array(
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'trim|valid_email|required'),
        ),
        'update' => array(
            'email' => array(
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'trim|valid_email|required'),
        )
    );


	public function __construct()
	{
        parent::__construct();
        $this->timestamps = FALSE;
	}
}