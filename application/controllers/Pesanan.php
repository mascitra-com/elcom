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
		$this->redirect_if_not_admin();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model(array('orders_m'));
	}

	public function index()
	{

		if (empty($row)) {
			$row = 20;
		} 

		$filter 	= $this->session->userdata('filter_orders');
		$order_by 	= $this->session->userdata('ob_orders');
		$order_type = $this->session->userdata('ot_orders');
        // dump($filter);

		$this->load->database(); 
		$jumlah_data = $this->orders_m
		->where($filter, 'like', '%')
		->order_by($order_by, $order_type)	
		->count_rows();

		$this->load->library('pagination'); 

		$config['total_rows'] = $jumlah_data;
		$config['per_page'] = $row; 
		$config['base_url'] = base_url().'/kategori/index/'.$row;  
		$config['uri_segment'] = 4;

		$config['full_tag_open'] = "<ul class='pagination pagination-sm' style='position:relative; top:-68px;'>";
		$config['full_tag_close'] ="</ul>";
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = "<li>";
		$config['next_tagl_close'] = "</li>";
		$config['prev_tag_open'] = "<li>";
		$config['prev_tagl_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tagl_close'] = "</li>"; 

		$from = $this->uri->segment(4); 
		$from = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

		if ($from == 0) {
			$from = "0";
		}  
		$this->pagination->initialize($config);

		$data['orders'] = $this->orders_m
		->with_member(array(
            'with' => array(
                'relation' => 'users_membership',
                'fields' => 'status',
                'with' => array(
                    'relation' => 'membership',
                    'fields' => 'name'
                )
            )
        ))
		->where('status !=', '1')
		->where($filter, 'like', '%')
		->order_by($order_by, $order_type)	
		->limit($config['per_page'],$offset=$from)  
		->get_all();

		$data['payments'] = $this->orders_m
		->with_member()
		->where('status', '1')
		->get_all();
		$data['count_payment'] = $this->orders_m
		->with_member()
		->where('status', '1')
        ->count_rows();

		$data['row'] 		 = $row;
		$data['jumlah_data'] = $jumlah_data;
		$data['paginasi']    = $this->pagination->create_links();
		$data['filter'] 	 = $filter;
		$data['order_by']	 = $order_by;
		$data['order_type']	 = $order_type;   

		$this->generateCsrf();
		$this->render('admin/orders/index', $data);
	}

    public function cetak()
    {
        $data['orders'] = $this->orders_m
            ->with_member(array(
                'with' => array(
                    'relation' => 'users_membership',
                    'fields' => 'status',
                    'with' => array(
                        'relation' => 'membership',
                        'fields' => 'name'
                    )
                )
            ))
            ->with_senyum_bank_account(array(
                'with' => array(
                    'relation' => 'bank',
                    'fields' => 'name'
                )
            ))
            ->where('status !=', '1')
            ->get_all();
        $this->render('admin/orders/cetak', $data);
    }

	public function search()
	{ 
		$filter_data 	= $this->input->post();
		$ob 			= $this->input->post('order_by');
		$ot 			= $this->input->post('order_type');

        // dump($filter_data);
		unset($filter_data['order_by']);
		unset($filter_data['order_type']); 

		$this->session->set_userdata('ob_orders', $ob);
		$this->session->set_userdata('ot_orders', $ot); 

		$this->session->unset_userdata('filter_orders');
		$this->session->set_userdata('filter_orders', $filter_data);
		$this->go('pesanan');
	}
	public function refresh()
	{
		$this->session->unset_userdata(array('filter_orders', 'ob_orders', 'ot_orders'));
		$this->go('pesanan');
	}

	public function konfirmasi()
	{
		$data = $this->input->post();
		$id = $this->input->post('id');  
		$status = $this->input->post('status');  
		$user = $this->ion_auth->user()->row();
        $order = $this->orders_m->fields('id, member_id, reseller_discount')->where('id', $id)->get();
        $discount = $order->reseller_discount;
        $this->load->model(array('order_details_m', 'reseller_m'));
        $order_products = $this->order_details_m->fields('current_price, current_discount')->where('order_id', $id)->get_all();
        foreach ($order_products as $product){
            if($product->current_discount){
                $discount += $product->current_discount & $product->current_price;
            }
        }
        $point_insert = array(
            'user_id' => $order->member_id,
            'point' => $discount
        );
        $this->reseller_m->update($point_insert, 'user_id');
		if ($status == 0) { 
			$input = array('id' => $id, 'keterangan' => $this->input->post('keterangan'));
			$update = $this->orders_m->update($input, 'id'); 
			$delete = $this->orders_m->delete(array('id'=>$id));

			if ($update === FALSE && $delete === FALSE) {
				$this->message('Aksi Gagal', 'warning');
			}else{
				$this->message('Pembayaran berhasil di Tolak', 'success'); 
			}
		} else { 
			$additional_data = array(
				'verified_at' => date('Y-m-d H:i:s'),
				'verified_by' => $user->id,
                'status' => '2'
				);
			$data = array_merge($data, $additional_data);

			$update = $this->orders_m->update($data, 'id');

			if ($update === FALSE) {
				$this->message('Pembayaran gagal di Konfirmasi', 'warning');
			}else{
				$this->message('Pembayaran berhasil di Konfirmasi', 'success');
			}
		}
		$this->go('pesanan');
	}

	public function konfirmasi_pengiriman()
	{  
		$data = $this->input->post(); 
		$update = $this->orders_m->update(array(
			'ship_receipt_number' => $data['ship_receipt_number'],
			'shipped_date' => date('Y-m-d h:i:s'),
			'status' => $data['status']
		), array('id' => $data['id']));

		if ($update === FALSE) {
			$this->message('Resi gagal dikirim', 'warning');
		}else{
			$this->message('Resi berhasi dikirim', 'success');
		}
		$this->go('pesanan');
	}

	public function detail($order_id = NULL)
	{
		if (is_null($order_id) || empty($order_id)) {
			$this->message('Pesanan tidak ditemukan.','warning');
			$this->go('pesanan');
		}else{
			$data['order'] = $this->orders_m
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
					'fields' => 'code, name, image_thumb_1'
					),
				'fields' => 'quantity, current_price, current_discount'
				))
			->get(array('id' => $order_id));

			$this->render('admin/orders/detail', $data);
		}
	}
}