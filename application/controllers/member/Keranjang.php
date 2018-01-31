<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Keranjang extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->redirect_if_admin();
		$this->_accessable = TRUE;
		$this->load->helper(array('potong_teks', 'cek_file'));
		$this->load->model(array('carts_m', 'cart_details_m', 'products_m', 'membership_m'));
	}

	public function index()
	{
	    $this->load->model('reseller_m');
		$data = array();
		if (!$this->ion_auth->logged_in() && $this->session->userdata('product')) {
			$this->load->model('products_m');
			$products = $this->products_m
			->with('category')
			->fields('slug,code,name,price,min_stock,discount,tax,image_1')
			->where('code', $this->session->userdata('product'))
			->get_all();

			$cart_products = array();
            $quantity = $this->session->userdata('product_quantity');
			foreach ($products as $key => $values) {
                // if the object has not already created in previous loop
                // then create it. Note, that you overwrote the object with a
                // new one each loop. Therefore it only contained 'anotherfield'
				if (!isset($cart_products[$key])) {
					$cart_products[$key] = new StdClass();
				}
				$cart_products[$key]->id = $this->session->userdata('cart_id');
				$cart_products[$key]->quantity =  $quantity[$values->code];
				$cart_products[$key]->product = $values;
			}
			$data['cart_products'] = $cart_products;
		}

		if($this->ion_auth->logged_in()){
			$data['cart_products'] = $this->cart_details_m
			->fields('id, quantity')
			->with_product(array(
				'fields' => 'id, code,slug,name,price,min_stock,discount,tax,image_1',
				'with' => array(
					'relation' => 'category',
					'fields' => 'name'
					),
				))
			->get_all(array('cart_id' => $this->getCartId()));
		}
		if($membership_id = $this->session->userdata('membership')) {
            $data['membership'] = $this->membership_m->get($membership_id);
        }
        $data['reseller'] = $this->reseller_m->get(array('user_id' => $this->ion_auth->get_current_user_id()));
        $this->generateCsrf();
		$this->generateAjaxCsrf();
		$this->render('homepage/cart', $data);
	}

	public function tambah()
	{
		$input = $this->input->post();
		if(!$this->ion_auth->logged_in()){
			if(!$this->session->userdata('cart_id')) {
				$this->session->set_userdata('cart_id', $this->db->query('SELECT uuid() as id')->row()->id);
			}
            $product_code = $input['product_code'];
            if($this->session->userdata('product')){
				$product = $this->session->userdata('product');
				$quantity = $this->session->userdata('product_quantity');
				$product[] .= $input['product_code'];
                $quantity = array_merge($quantity, array($product_code => 1));
			} else {
				$product = array();
				$product[] .= $input['product_code'];
				$quantity = array();
                $quantity = array_merge($quantity, array($product_code => 1));
            }
            $this->session->set_userdata('product_quantity', $quantity);
            $this->session->set_userdata('product', $product);
			$this->go('member/keranjang');
		}
		//cek stok produk
		//ambil data stok produk
		$current_product_stock = $this->products_m->get(array('code' => $input['product_code']))->stock;
		if ($current_product_stock === 0 || is_null($current_product_stock) || empty($current_product_stock)) {
			$this->message('stok barang ini habis');
			$this->go('/');
		}

		//cek apakah member sudah mempunyai data cart
		$query = $this->carts_m->get(array('member_id' => $this->ion_auth->get_current_user_id()));
		if (!$query || is_null($query) || empty($query)) {
			//insert cart baru untuk member yang sedang login
			$insert = $this->carts_m->insert(array(
				'id' => $this->carts_m->get_last_id('CRT', 7),
				'member_id' => $this->ion_auth->get_current_user_id()
				));

			if ($insert === FALSE) {
				//TODO MESSAGE
				$this->message('Terjadi kesalahan saat membeli barang. Coba lagi nanti!');
				$this->go('/');
			}
		}

		$cart_id = $this->getCartId();
		$product_id = $this->products_m->getProductIdByCode($input['product_code']);

        //ambil data harga dan diskon produk
		$product = $this->products_m->fields('price, discount')->get($product_id);

        //cek produk apakah sudah ada di cart_detail
		$product_already_exist = $this->cart_details_m
		->where('product_id', $product_id)
		->get(array('cart_id' => $cart_id));

		if ($product_already_exist) {
			$this->go('member/keranjang');
		}

        //insert produk di carts_detail
		$insert = $this->cart_details_m
		->insert(array(
			'cart_id' => $cart_id,
			'product_id' => $product_id,
			'current_price' => $product->price,
			'current_discount' => $product->discount
			));

		if ($insert === FALSE) {
            //TODO MESSAGE
			$this->message('Terjadi kesalahan saat membeli barang. Coba lagi nanti.');
			$this->go('/');
		}else{
			$this->go('member/keranjang');
		}

	}

	public function update_cart()
	{
		if(!$this->ion_auth->logged_in()) {
			$this->go('auth');
		}
		$update = $this->input->post();

		//update semua total harga pada cart
		$query = $this->carts_m
		->update(array(
			'total_without_tax' => $update['total_without_tax'],
			), array('id' => $this->getCartId()));
		if ($query === FALSE) {
			//todo message
			$this->message('Terjadi kesalahan siste. Coba lagi nanti.');
			$this->go('/');
		}else{
			//ambil id produk pada cart yg bersangkutan
			$products = $this->cart_details_m->fields('product_id')->where('cart_id', $this->getCartId())->get_all();
			$product_ids = array(); //array untuk menampung id produk
			foreach ($products as $product) {
				array_push($product_ids, $product->product_id);
			}
			//update harga dan diskon produk dengan harga terbaru
			for ($i=0; $i <sizeof($product_ids); $i++) {
				//ambil harga dan diskon produk terbaru berdasarkan id yg bersangkutan
				$products = $this->products_m->fields('id, price, discount')->get($product_ids[$i]);
				$update = $this->cart_details_m
				->update(array(
					'current_price' => $products->price,
					'current_discount' => $products->discount
					), array(
					'cart_id' => $this->getCartId(),
					'product_id' => $product_ids[$i]
					));

				if ($update === FALSE) {
					//todo message
					$this->message('Terjadi kesalahan siste. Coba lagi nanti.');
					$this->go('/');
				}	
			}
			$this->go('member/pembayaran');
		}
	}

	//hapus produk dari detail keranjang belanja
	public function hapus_produk($cart_detail_id)
	{
		//cek hak akses member untuk menghapus berdasarkan cart_id dan member_id yg bersangkutan
		$cart_id = $this->getCartId();
		$cart_id_in_cart_detail = $this->cart_details_m
		->fields('cart_id')->get($cart_detail_id)->cart_id;
		
		if ($cart_id === $cart_id_in_cart_detail) {
			//hapus produk dari detail cart
			$query = $this->cart_details_m->delete($cart_detail_id);
		}else{
			//todo message
			dump('anda tidak memilika hak akses untuk menghapus produk ini dari dalam keranjang');
		}
		$this->go('member/keranjang');
	}

	public function hapus_product_guest($product_id)
	{
		$products = $this->session->userdata('product');
		if(($key = array_search($product_id, $products)) !== false) {
			unset($products[$key]);
		}
		$this->session->set_userdata('product', $products);
		$this->go('member/keranjang');
	}

	public function hapus_all_product_guest()
	{
		$this->session->unset_userdata('product');
		$this->session->unset_userdata('product_quantity');
		$this->go('member/keranjang');
	}

	//hapus semua produk dari detail keranjang belanja berdasarkan cart_id member yang sedang login
	public function hapus_semua()
	{
		$query = $this->cart_details_m->delete(array('cart_id' => $this->getCartId()));
		if ($query) {
			//todo message
			$this->go('member/keranjang');
		}else{
			//todo message
			dump('ada kesalahan saat mengapus semua produk dari keranjang');
		}
	}


	//AJAX REQUESTS
	//update quantity produk di tabel cart_details
	public function updateQuantity()
	{
		$input= $this->input->post();
        if($this->ion_auth->logged_in()){
            $query = $this->cart_details_m
                ->update(array(
                    'quantity' => $input['quantity']
                ), $input['cart_detail_id']);
        } else {
            $quantity = $this->session->userdata('product_quantity');
            $product_c = $input['product_code'];
            $quantity[$product_c] = $input['quantity'];
            $this->session->set_userdata('product_quantity', $quantity);
            $query = TRUE;
        }
		if ($query === FALSE) {
			echo json_encode(array("status" => FALSE));
		}else{
			echo json_encode(array("status" => TRUE));
		}
	}

    public function checkUserAttribute()
    {
        $this->load->model('reseller_m');
        $reseller = NULL;
        $membership = NULL;
        $reseller = $this->reseller_m->get(array('user_id' => $this->ion_auth->get_current_user_id()));
        $membership_id = $this->session->userdata('membership');
        if($reseller || $membership_id){
            $membership = $this->membership_m->get($membership_id);
            echo json_encode(array("status" => TRUE, "membership" => $membership, "reseller" => $reseller, 'user' => $this->ion_auth->get_current_user_id()));
        } else {
            echo json_encode(array("status" => FALSE));
        }
	}

	// PRIVATE FUNCTIONS
	// ambil cart id berdasarkan member id yg sedang login
	private function getCartId()
	{
		$cart_id = $this->carts_m->getCartId($this->ion_auth->get_current_user_id());

		return $cart_id;
	}

    public function cekSession()
    {
        $quantity = $this->session->userdata('product_quantity');
        var_dump($quantity);
	}
}