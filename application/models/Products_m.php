<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Products_m extends MY_Model
{
	public $table = 'products';
	public $primary_key = 'id';
	public $protected = array('id');

	public $rules = array(
		'insert' => array(
			'name' => array(
				'field' => 'name',
				'label' => 'Nama Produk',
				'rules' => 'trim|required|max_length[100]'),
			'overview' => array(
				'field' => 'overview',
				'label' => 'Overview Produk',
				'rules' => 'trim'),
			'description' => array(
				'field' => 'description',
				'label' => 'Deskripsi Produk',
				'rules' => 'trim'),
			'length' => array(
				'field' => 'length',
				'label' => 'Panjang Produk',
				'rules' => 'numeric'),
			'width' => array(
				'field' => 'width',
				'label' => 'Lebar Produk',
				'rules' => 'numeric'),
			'height' => array(
				'field' => 'height',
				'label' => 'Tinggi Produk',
				'rules' => 'numeric'),
			'weight' => array(
				'field' => 'weight',
				'label' => 'Berat Produk',
				'rules' => 'numeric'),
			'stock' => array(
				'field' => 'stock',
				'label' => 'Stok Produk',
				'rules' => 'numeric|required'),
			'min_stock' => array(
				'field' => 'min_stock',
				'label' => 'Jumlah Pembelian Minimal Produk',
				'rules' => 'numeric|required'),
			'price' => array(
				'field' => 'price',
				'label' => 'Harga Produk',
				'rules' => 'numeric|required'),
			),
		'update' => array(
			'name' => array(
				'field' => 'name',
				'label' => 'Nama Produk',
				'rules' => 'trim|required|max_length[100]'),
            'overview' => array(
                'field' => 'overview',
                'label' => 'Overview Produk',
                'rules' => 'trim'),
			'description' => array(
				'field' => 'description',
				'label' => 'Deskripsi Produk',
				'rules' => 'trim'),
			'length' => array(
				'field' => 'length',
				'label' => 'Panjang Produk',
				'rules' => 'numeric'),
			'width' => array(
				'field' => 'width',
				'label' => 'Lebar Produk',
				'rules' => 'numeric'),
			'height' => array(
				'field' => 'height',
				'label' => 'Tinggi Produk',
				'rules' => 'numeric'),
			'weight' => array(
				'field' => 'weight',
				'label' => 'Berat Produk',
				'rules' => 'numeric'),
			'stock' => array(
				'field' => 'stock',
				'label' => 'Stok Produk',
				'rules' => 'numeric|required'),
			'price' => array(
				'field' => 'price',
				'label' => 'Harga Produk',
				'rules' => 'numeric|required'),
			)
		);

	public function __construct()
	{
		$this->has_one['category'] = array('Categories_m', 'id', 'category_id');
		$this->has_one['producer'] = array('Producers_m', 'id', 'producer_id');
		// $this->has_many['cart_details'] = array('Cart_details_m', 'product_id', 'id');
        $this->soft_deletes = TRUE;
		parent::__construct();
	}

	/*
    * 
    * get_next_id($prefix)
    * Get last ID from Table
    */
    public function get_last_id($prefix="", $len=5)
    {
        $this->db->select($this->primary_key);
        $this->db->order_by($this->primary_key,'DESC');
        $this->db->limit(1);
        $result = $this->db->get($this->table);
        if ($result->num_rows() > 0) {
            $result = $result->result_array()[0][$this->primary_key];
            $result = str_replace($prefix, "", $result);
        }else{
            $result = 0; 
        }
        $len -= strlen($prefix);
        $result++;
        return $prefix.(str_pad($result,$len,'0',STR_PAD_LEFT));
    }

    //ambil product id berdasarkan product code
	public function getProductIdByCode($code)
	 {
	 	$id = $this->fields('id')->get(array('code' => $code))->id;
	 	
	 	return $id;
	 } 
}