<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Categories_m extends MY_Model
{
	public $table = 'categories';
	public $primary_key = 'id';
	public $protected = array('id');

	public $rules = array(
		'insert' => array(
			'name' => array(
				'field' => 'name',
				'label' => 'Nama Produk',
				'rules' => 'trim|required|max_length[255]|alpha_numeric_spaces'),
			'description' => array(
				'field' => 'description',
				'label' => 'Deskripsi Produk',
				'rules' => 'trim')
			),
		'update' => array(
			'name' => array(
				'field' => 'name',
				'label' => 'Nama Produk',
				'rules' => 'trim|required|max_length[255]'),
			'description' => array(
				'field' => 'description',
				'label' => 'Deskripsi Produk',
				'rules' => 'trim')
			)
		);

	public function __construct()
	{
		// $this->has_one['organisasi'] = array('Organisasi_m', 'id', 'id_organisasi');
		parent::__construct();
	}

	//for update only
	public function defineParentIdByCategoryId($category_id)
	{
		if (is_null($category_id) || empty($category_id)) {
			return null;
		}
	}

	//transaction_type -> 0=insert, 1=update
	public function defineLevelCategoryByParentId($category_id, $transaction_type, $prev_category_id = NULL)
	{
		if ($transaction_type === 0) {
			//insert
			if (is_null($category_id) || empty($category_id)) {
				return '0';
			}else{
				$sub_category_level= $this->fields('level')->get($category_id)->level;
				return $sub_category_level+1;
			}
		}else{
			//update
			// jika inputan kosong
			if (is_null($category_id) || empty($category_id)) {
				// untuk sub-kategorinya yang parent_id nya = category_id sebelumnya jadi null dan levelnya jadi 0
				$this->where('parent_id', $prev_category_id)->update(array('parent_id'=> NULL ,'level'=>'0'));

				// kategori sekarang levelnya jadi 0 parent_id jadi null
				return '0';
			}
			// jika inputan berbeda dimana kategori tsb merupakan kategori induk bagi yang lainnya
			elseif ($category_id !== $prev_category_id) {
				// kategori induk mendapatkan/merubah parent_id dan level ditambah 1 mengikuti parent_id yg berubah
				$sub_category_level= ($this->fields('level')->get($category_id)->level) +1;

				// sub-sub kategori yang bersangkutan ikut berubah selain parent_idnya levelnya ditambah 1 dari level ikut kategori induk	
				$this->where('parent_id', $prev_category_id)->update(array('level'=>$sub_category_level+1));
				
				//kembalikan nilai sub kategori level
				return $sub_category_level;
			}
			else{
				return $this->fields('level')->get($category_id)->level;	
			}
		}
	}
}