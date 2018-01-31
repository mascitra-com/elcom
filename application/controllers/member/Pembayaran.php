<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Pembayaran extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->redirect_if_admin();
		$this->_accessable = TRUE;
		$this->load->model(array('carts_m','addresses_m', 'senyum_accounts_m', 'provinces_m', 'membership_m', 'reseller_m'));
	}

	public function index()
	{
		$user_id = $this->ion_auth->get_current_user_id();

		$data['user']  	   = $this->ion_auth->user()->row(); 

		$cart_id = $this->carts_m->getCartId($user_id);
		
		$data['cart'] = $this->carts_m
		->fields('total_without_tax')
		->get(array('id' => $cart_id));

		$user_addresses = $this->addresses_m
            ->fields('id, province_id, regency_id, address_name')
            ->get_all(array('user_id' => $user_id));
		$data['user_addresses'] = $user_addresses;

		$data['provinces'] = $this->ongkir("https://api.rajaongkir.com/starter/province");
		$this->load->model(array('cart_details_m', 'products_m'));

        $order_weight = $this->cart_details_m->where('cart_id', $cart_id)->get_all();
        $weight = 0;
        foreach ($order_weight as $list){
            $product = $this->products_m->where('id', $list->product_id)->get();
            $weight += $list->quantity * $product->weight;
        }
        if($weight > 30)
            $weight = 30;
        $weight = $weight * 1000;
        if($weight < 1000)
            $weight = 1000;
        $data['weight'] = $weight;
        //todo shipment agent data
        $ongkirJne = $this->ongkir(NULL, TRUE, "origin=160&destination={$user_addresses[0]->regency_id}&weight={$weight}&courier=jne");
        $ongkirTiki = $this->ongkir(NULL, TRUE, "origin=160&destination={$user_addresses[0]->regency_id}&weight={$weight}&courier=tiki");
        $data['ongkirJne'] = $ongkirJne[0];
        $data['ongkirTiki'] = $ongkirTiki[0];

		$data['senyum_bank_accounts'] = $this->senyum_accounts_m
		->fields('id, account, behalf')
		->with_bank('fields:name,icon')
		->get_all();
        $data['bank_icon'] = array('bca', 'bni', 'mandiri');
        if($membership_id = $this->session->userdata('membership')) {
            $data['membership'] = $this->membership_m->get($membership_id);
        }
        if($reseller_id = $this->session->userdata('membership')){
            $data['reseller'] = $this->reseller_m->get($reseller_id);
        }
		$this->generateCsrf();
		$this->render('homepage/payment', $data);
	}

	public function konfirmasi()
	{
		$this->generateCsrf();
		$this->render('homepage/confirm_payment');
	}

	public function address_save()
	{
		$input['data'] = $this->input->post();    
		$insert = $this->addresses_m->insert($input); 

		if ($insert === FALSE) {
			$this->message('Alamat gagal ditambahkan.', 'warning');
		}else{
			$this->message('Alamat berhasil ditambahkan.', 'success');
        }
        $this->go('member/keranjang');
    }

    public function getShipmentTable($user_address_id, $weight)
    {
        $user_address = $this->addresses_m->get($user_address_id);
        $regency_id = $user_address->regency_id;
        $html = "";
        $ongkirJne = $this->ongkir(NULL, TRUE, "origin=160&destination={$regency_id}&weight={$weight}&courier=jne");
        $ongkirJne = $ongkirJne[0]["costs"];
        foreach ($ongkirJne as $data){
            $html .= "<tr>
                        <td>
                            <label class=\"radio\">
                            <input type=\"radio\" name=\"ship_agent\"
                            id=\"" . $data['service'] . "\" value=\"" . $data['service'] . "\">
                            <img height=\"30\" src=\"" . base_url('assets/homepage/images/site/delivery/jne.png') . "\" alt=\"jne\"></label>
                        </td>
                        <td>" . $data["service"] . "</td>
                        <td class=\"cost\">" . $data["cost"][0]["value"] . "</td>
                        <td>" . $data["cost"][0]["etd"] . " Hari</td>
                    </tr>";
        }
        $ongkirTiki = $this->ongkir(NULL, TRUE, "origin=160&destination={$regency_id}&weight={$weight}&courier=tiki");
        $ongkirTiki = $ongkirTiki[0]["costs"];
        foreach ($ongkirTiki as $data){
            $html .= "<tr>
                        <td>
                            <label class=\"radio\">
                            <input type=\"radio\" name=\"ship_agent\"
                            id=\"" . $data['service'] . "\" value=\"" . $data['service'] . "\">
                            <img height=\"30\" src=\"" . base_url('assets/homepage/images/site/delivery/tiki.png') . "\" alt=\"jne\"></label>
                        </td>
                        <td>" . $data["service"] . "</td>
                        <td class=\"cost\">" . $data["cost"][0]["value"] . "</td>
                        <td>" . $data["cost"][0]["etd"] . " Hari</td>
                    </tr>";
        }
        echo $html;
	}
} 
