<?php

class Reseller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('reseller_m', 'deposit_m', 'users_m'));
    }

    public function index()
    {
        $data['reseller'] = $this->reseller_m->where('user_id', $this->ion_auth->get_current_user_id())->get();
        $this->render('member/reseller/index', $data);
    }

    public function deposit()
    {
        $this->load->model(array('bank_accounts_m'));
        $data['user'] = $this->users_m->get($this->ion_auth->get_current_user_id());
        $data['banks'] = $this->bank_accounts_m->where('user_id', $this->ion_auth->get_current_user_id())->get_all();
        $data['reseller'] = $this->reseller_m->where('user_id', $this->ion_auth->get_current_user_id())->get();
        $this->generateCsrf();
        $this->render('member/reseller/deposit', $data);
    }

    public function simpan()
    {
        $reseller_data = array('user_id' => $this->ion_auth->get_current_user_id());
        if($this->reseller_m->insert($reseller_data)){
            $reseller = $this->reseller_m->where('user_id', $this->ion_auth->get_current_user_id())->get();
            $deposit_data = $this->input->post();
            $deposit_data['reseller_id'] = $reseller->id;
            if($this->deposit_m->insert($deposit_data)){
                $this->load->model('users_m');
                $update_user = array('reseller' => 1, 'id' => $this->ion_auth->get_current_user_id());
                $this->users_m->update($update_user, 'id');
                $this->message('Pendaftaran Sukses, silahkan tunggu konfirmasi dari kami melalui email. Terima Kasih', 'success');
            } else {
                $this->message('Pendaftaran Gagal. Coba Lagi Nanti.', 'warning');
            }
        } else {
            $this->message('Pendaftaran Gagal. Coba Lagi Nanti.', 'warning');
        }
        $this->go('homepage');
    }

    public function simpan_deposit()
    {
        $reseller = $this->reseller_m->where('user_id', $this->ion_auth->get_current_user_id())->get();
        $deposit_data = $this->input->post();
        $deposit_data['reseller_id'] = $reseller->id;
        if($this->deposit_m->insert($deposit_data)){
            $this->message('Deposit Anda sedang di Proses, Mohon Menunggu. Terima Kasih', 'success');
        } else {
            $this->message('Deposit Gagal. Coba Lagi Nanti.', 'warning');
        }
        $this->go('member/reseller');
    }
}