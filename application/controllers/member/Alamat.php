<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Alamat extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->redirect_if_admin();
        $this->_accessable = FALSE;
        $this->load->helper(array('potong_teks', 'cek_file'));
        $this->load->model(array('addresses_m', 'provinces_m', 'regencies_m', 'districts_m', 'villages_m'));
    }

    public function index()
    {
        $this->render('member/address/addresses');
    }

    public function tambah()
    {
        $data['user'] = $this->ion_auth->user()->row();
        // Get Provinces From RajaOngkir
        $provinces = $this->ongkir("https://api.rajaongkir.com/starter/province");
        $data['provinces'] = $provinces;

        $this->generateCsrf();
        $this->render('member/address/create_address', $data);
    }

    public function save()
    {
        $input['data'] = $this->input->post();
        $insert = $this->addresses_m->insert($input);

        if ($insert === FALSE) {
            $this->message('Rekening gagal ditambahkan.', 'warning');
            $this->go('member/profil');
        } else {
            $this->message('Rekening berhasil ditambahkan.', 'success');
            $this->go('member/profil');
        }
    }

    public function sunting($id = NULL)
    {
        if (is_null($id) || empty($id)) {
            $this->message('Terjadi kesalahan saat mengunjungi halaman', 'danger');
            $this->go('member/profil');
        } else {
            $data['data'] = $this->addresses_m
                ->where('id', $id)->get();
            $data = array(
                'provinces' => $this->ongkir("https://api.rajaongkir.com/starter/province"),
                'data' => $data,
                'regencies' => $this->ongkir("https://api.rajaongkir.com/starter/city?province=" . $data['data']->province_id),
            );
            $this->generateCsrf();
            $this->render('member/address/edit_address', $data);
        }
    }

    public function update()
    {
        $id = $this->input->post('id');
        $input['data'] = $this->input->post();

        $update = $this->addresses_m->update($input['data'], $id);
        if ($update === FALSE) {
            $this->message('Data Gagal di Ubah', 'warning');
            $this->go("member/profil");
        } else {
            $this->message('Data Berhasil di Ubah', 'success');
            $this->go("member/profil");
        }
    }

    public function hapus($id)
    {
        $this->addresses_m->delete($id);
        $this->go("member/profil");
    }

    // DROPDOWN AJAX
    function add_regencies($id_provinces)
    {
        $regencies = $this->ongkir("https://api.rajaongkir.com/starter/city?province=" . $id_provinces);
        $data = "<option value=''>- Select Kabupaten -</option>";
        foreach ($regencies as $value) {
            $data .= "<option value='" . $value['city_id'] . "'>" . $value['city_name'] . "</option>";
        }
        echo $data;
    }
    // END DROPDOWN

    // DROPDOWN AJAX
    function add_districts($id_regencies)
    {
        $query = $this->db->get_where('districts', array('regency_id' => $id_regencies));
        $data = "<option value=''>- Pilih Kecamatan -</option>";
        foreach ($query->result() as $value) {
            $data .= "<option value='" . $value->id . "'>" . $value->name . "</option>";
        }
        echo $data;
    }
    // END DROPDOWN

    // DROPDOWN AJAX
//    function add_villagess($id_districts)
//    {
//        $query = $this->db->get_where('villages', array('district_id' => $id_districts));
//        $data = "<option>- Pilih Desa -</option>";
//        foreach ($query->result() as $value) {
//            $data .= "<option value='" . $value->id . "'>" . $value->name . "</option>";
//        }
//        echo $data;
//    }
    // END DROPDOWN
}