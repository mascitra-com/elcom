<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Berita_m extends MY_Model
{
	public $table = 'newsletters';
	public $primary_key = 'id';

    public $rules = array(
        'insert' => array(
            'title' => array(
                'field' => 'title',
                'label' => 'Judul Berita',
                'rules' => 'min_length[5]|max_length[255]|trim|required'),
            'body' => array(
                'field' => 'body',
                'label' => 'Isi Berita',
                'rules' => 'trim|required'),
        ),
        'update' => array(
            'title' => array(
                'field' => 'title',
                'label' => 'Judul Berita',
                'rules' => 'min_length[5]|max_length[255]|trim|required'),
            'body' => array(
                'field' => 'body',
                'label' => 'Isi Berita',
                'rules' => 'trim|required'),
        )
    );

	public function __construct()
	{
		parent::__construct();
	} 
}