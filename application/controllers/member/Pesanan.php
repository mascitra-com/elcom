<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Pesanan extends MY_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->redirect_if_admin();
		$this->_accessable = FALSE;
		$this->load->helper('tanggal_indonesia');
		$this->load->model(array('orders_m', 'order_details_m', 'carts_m', 'cart_details_m', 'addresses_m', 'users_m'));
	}

	public function index()
	{
		$data['orders'] = $this->orders_m
		->fields('id, total_all, order_date, status')
		->order_by('order_date', 'ASC')
		->with_order_details('fields:*count*')
		->get_all(array('member_id' => $this->ion_auth->get_current_user_id()));

		$this->render('member/orders/index', $data);
	}

	public function detail($order_id)
	{
		if (is_null($order_id) || empty($order_id)) {
			//todo message
			$this->message('Pesanan tidak ditemukan.');
			$this->go('/');
		}else{
			$data['order'] = $this->orders_m
			->fields('id, order_date,ship_first_name,ship_agent, ship_last_name,ship_district,ship_village,ship_address,ship_price, ship_receipt_number,
			total_products_price_without_tax,membership_discount, reseller_discount, total_tax,total_all,status')
			->with_senyum_bank_account(array(
				'with' => array(
					'relation' => 'bank',
					'fields' => 'name'
					), 
				'fields' => 'account, behalf'
				))
			->with_order_details(array(
				'with' => array(
					'relation' => 'product',
					'fields' => 'slug, name, image_1',
					'with' => array(
						'relation' => 'category',
						'fields' => 'name'
						)
					),
				'fields' => 'quantity, current_price, current_discount'
				))
			->get(array(
				'id' => $order_id,
				'member_id' => $this->ion_auth->get_current_user_id()
				));
		}
//		die(var_dump($data['order']));
		$this->render('member/orders/detail', $data);
	}

	public function tambah()
	{
		$input = $this->input->post();
		$user_id = $this->ion_auth->get_current_user_id();
        if(!$input['ship_price']){
            $this->message('Mohon Pilih Jasa Pengiriman.');
            $this->go('member/pembayaran');
        }
		//ambil data alamat member berdasarkan id alamat pengiriman yg diinputkan

		$order_id = $this->orders_m->get_last_id("ORD", 8);
        $insert = $this->orders_m->from_form(NULL, array(
			'id' => $order_id,
			'member_id' => $user_id,
			'order_date' => date("Y-m-d H:i:s", time()),
			'membership_discount' => $input['membership_discount'],
			'reseller_discount' => $input['reseller_discount'],
			'ship_agent' => $input['ship_agent'],
			'status' => '0',
			))->insert();
		if ($insert === FALSE) {
			$this->message('Terjadi kesalahan sistem. Coba lagi nanti.');
			$this->go('/');
		}else{
			$cart_id = $this->carts_m->getCartId($user_id);
            $user_address = $this->addresses_m->get($input['shipment_address_id']);
            //ambil data produk-produk yang dipesan di detail keranjang belanja
            $update = $this->orders_m->update(array(
                'ship_first_name' => $user_address->owner_first_name,
                'ship_last_name' => $user_address->owner_last_name,
                'ship_province' => $user_address->province_id,
                'ship_regency' => $user_address->regency_id,
                'ship_district' => $user_address->district,
                'ship_village' => $user_address->village,
                'ship_address' => $user_address->full_address,
                'ship_postal_code' => $user_address->postal_code,
                'ship_mobile' => $user_address->phone,
            ), array('id' => $order_id));
			$ordered_products = $this->cart_details_m
			->fields('product_id, quantity, current_price, current_discount')
			->get_all(array('cart_id' => $cart_id));

			$insert_batch = array(); //simpan data dari produk yg dipesan
			foreach ($ordered_products as $ordered_product) {
				array_push($insert_batch, array(
					'order_id' => $order_id,
					'product_id' => $ordered_product->product_id,
					'quantity' => $ordered_product->quantity,
					'current_price' => $ordered_product->current_price,
					'current_discount' => $ordered_product->current_discount
					));
			}
			//insert data produk-produk yang dipesan dari detail keranjang belanja ke detail pesanan
			$insert = $this->order_details_m->insert($insert_batch);
			if ($insert === FALSE) {
				//todo message
				$this->message('Terjadi kesalahan sistem. Coba lagi nanti.');
				$this->go('/');
			} else {
                $cart_details = $this->cart_details_m->where('cart_id', $cart_id)->get_all();
                foreach ($cart_details as $cart_detail) {
                    $this->cart_details_m->delete($cart_detail->id);
                }
                $this->db->delete('carts', array('id'=>$cart_id));
            }
		}
		$this->go('member/pesanan/sendmail/'.$order_id);
	}

	public function konfirmasi_pembayaran()
	{
		$input = $this->input->post();

		$input['payment_date'] = $input['transfer_year'].'-'.$input['transfer_month'].'-'.$input['transfer_day'].' '.date('h').':'.date('i').':'.date('s');
		$input['payment_date'] = date('Y-m-d h:i:s', strtotime($input['payment_date']));

		//cek keberadaan order id
		$order = $this->orders_m->get(array(
			'id' => $input['id'],
			'status' => '0'	
			));


		if (!$order) {
			//todo message 
			$this->message("Pesanan tidak ditemukan atau sudah kadaluarsa");
			$this->go('member/pesanan/konfirmasi_pembayaran');
		}else{
			//cek nilai transfer sama dengan jumlah yang seharusnya dibayar
			if ($input['transfer_amount'] >= $order->total_all) {
				//update status pesanan menjadi terbayar
				$update = $this->orders_m->update(array(
					'status' => '1',
					'payment_date' => $input['payment_date'],
					'transfer_amount' => $input['transfer_amount'],
					'transfer_person_fullname' => $input['transfer_person_fullname'],
					'transfer_note' => $input['transfer_note']
					), array('id' => $input['id']));

				//update jumlah pembelian produk-produk yang bersangkutan
				//ambil detail pesanan berdasarkan order_id
				$order_details = $this->order_details_m->fields('product_id')->where('order_id', $input['id'])->get_all();
				$this->load->model('products_m');
				//update
				foreach ($order_details as $order_detail) {
					//ambil data jumlah pembelian produk sebelumnya
					$prev_boughted_amount = $this->products_m->get($order_detail->product_id);
					$update = $this->products_m
					->update(array(
						'boughted' => $prev_boughted_amount->boughted + 1
						), $order_detail->product_id);
				}
			}else{
				//todo message
				$this->message("Nilai Transfer tidak sesuai dengan jumlah yang seharusnya dibayar");
				$this->go('member/pesanan/konfirmasi');
			}
		}

		$this->go('member/pesanan/detail/'.$input['id']);
	}

    public function sendmail($order_id)
    {
        $user_id = $this->ion_auth->get_current_user_id();

        $user = $this->users_m
            ->fields('first_name, last_name, email, phone')
            ->get($user_id);
        $data['user'] = $user;

        $this->load->library('email');
        $data['order'] = $this->orders_m
            ->fields('id, order_date,ship_first_name,ship_last_name,ship_address,ship_price, ship_receipt_number,
			total_products_price_without_tax,membership_discount, reseller_discount, total_tax,total_all,status')
            ->with_senyum_bank_account(array(
                'with' => array(
                    'relation' => 'bank',
                    'fields' => 'name'
                ),
                'fields' => 'account, behalf'
            ))
            ->with_order_details(array(
                'with' => array(
                    'relation' => 'product',
                    'fields' => 'slug, name, image_1',
                    'with' => array(
                        'relation' => 'category',
                        'fields' => 'name'
                    )
                ),
                'fields' => 'quantity, current_price, current_discount'
            ))
            ->get(array(
                'id' => $order_id,
                'member_id' => $this->ion_auth->get_current_user_id()
            ));
        $message = $this->load->view('email/orders', $data, TRUE);
        $this->load->view('email/orders', $data);

        $this->email->from('order@senyummedia.com', 'Senyummedia');
        $this->email->to($user->email);
        $this->email->cc('info@senyummedia.co.id');
        $this->email->subject('Senyummedia - Pesanan '.$order_id);
        $this->email->message($message);

        $this->email->send();

        $this->go('member/pesanan/detail/'.$order_id);
    }

}