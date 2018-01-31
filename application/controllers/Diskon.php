<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Diskon extends MY_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->redirect_if_not_admin();
		$this->load->helper(array('dump'));
		$this->load->model(array('products_m'));
	}

	public function index()
	{
		$this->go('dashboard');
	}

	public function kategori()
	{
		$this->load->model('categories_m');

		$data['categories'] = $this->categories_m
		->fields('id, name')
		->get_all();

		$this->generateCsrf();
		$this->render('admin/discounts/kategori', $data);
	}

	public function produk()
	{
		$data['products'] = $this->products_m
		->fields('code, name')
		->get_all();

		$this->generateCsrf();
		$this->render('admin/discounts/produk', $data);
	}

	public function diskon_kategori()
	{
		$update_data = $this->input->post();

		if (!isset($update_data['category_id'])) {
			$this->message('Tidak ada diskon berdasarkan kategori yang dirubah.');
		}else{
			if (empty($update_data['discount']) || $update_data['discount'] == 0) {
				$update_data['discount'] = NULL;
			}

			$update = $this->products_m
			->where('category_id', $update_data['category_id'])
			->update(array(
				'discount' => $update_data['discount'] / 100
				));

			if ($update === FALSE) {
				$this->message('Terjadi kesalahan sitem saat mengubah diskon berdasarkan kategori! Coba lagi nanti.', 'warning');
			}else{
				$this->message('Sukses memberikan diskon berdasarkan kategori', 'success');
			}
		}
		$this->go('diskon/kategori');
	}

	public function diskon_produk()
	{
		$update_data = $this->input->post();

		if (!isset($update_data['id'])) {
			$this->message('Tidak ada diskon berdasarkan produk yang dirubah.');
		}else{
			if (empty($update_data['discount']) || $update_data['discount'] == 0) {
				$update_data['discount'] = NULL;
			}

			$update = $this->products_m
			->where('id', $update_data['id'])
			->update(array(
				'discount' => $update_data['discount'] / 100
				));

			if ($update === FALSE) {
				$this->message('Terjadi kesalahan sitem saat mengubah diskon berdasarkan produk! Coba lagi nanti.', 'warning');
			}else{
				$this->message('Sukses memberikan diskon berdasarkan produk', 'success');
			}
		}
		$this->go('diskon/produk');
	}
}