<?php

/**
 * Created by PhpStorm.
 * User: Rizki Herdatullah
 * Date: 11/1/2017
 * Time: 1:35
 */
class Reseller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('reseller_m');
        $this->load->model('deposit_m');
    }

    public function index()
    {
        $data['resellers'] = $this->reseller_m->get_reseller();
        $data['jumlah_data'] = $this->reseller_m->count_rows();
        $data['row'] = $this->reseller_m->count_rows();
        $this->render('admin/reseller/index', $data);
    }

    public function aktifkan($reseller_id)
    {
        $this->load->model('users_m');
        if($this->reseller_m->update(array('active' => '1'), $reseller_id)){
            $user_id = $this->reseller_m->get($reseller_id)->user_id;
            $this->users_m->update(array('reseller' => '1'), $user_id);
            $this->message('Reseller berhasil di Aktifkan.', 'success');
        }else{
            $this->message('Reseller gagal di Aktifkan.', 'warning');
        }
        $this->go('reseller');
    }

    public function nonaktifkan($reseller_id)
    {
        $this->load->model('users_m');
        if($this->reseller_m->update(array('active' => '0'), $reseller_id)){
            $user_id = $this->reseller_m->get($reseller_id)->user_id;
            $this->users_m->update(array('reseller' => '0'), $user_id);
            $this->message('Reseller berhasil di Nonaktifkan.', 'success');
        }else{
            $this->message('Reseller gagal di Nonaktifkan.', 'warning');
        }
        $this->go('reseller');
    }

    public function pengajuan()
    {
        $data['resellers'] = $this->reseller_m->get_deposit();
        $this->render('admin/reseller/pengajuan', $data);
    }

    public function terima_deposit($id)
    {
        $deposit = $this->deposit_m->get($id);
        $reseller = $this->reseller_m->get(array('id' => $deposit->reseller_id));
        $reseller_update['deposit'] = (double) $reseller->deposit + (double) $deposit->nominal;
        if($this->reseller_m->update($reseller_update, $reseller->id)){
            $this->deposit_m->update(array('status'=> '1'), $deposit->id);
            $this->message('Deposit berhasil di Tambahkan.', 'success');
        }else{
            $this->message('Terjadi Kesalahan. Coba lagi beberapa saat', 'warning');
        }
        $this->go('reseller/pengajuan');
    }

    public function tolak_deposit($id)
    {
        if($this->deposit_m->update(array('status'=> '2'), $id)){
            $this->message('Deposit berhasil di Tolak.', 'success');
        }else{
            $this->message('Terjadi Kesalahan. Coba lagi beberapa saat.', 'warning');
        }
        $this->go('reseller/pengajuan');
    }
}