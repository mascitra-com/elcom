<?php

class Berita extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->_accessable = TRUE;
        $this->load->model('pelanggan_berita_m', 'subscriber');
        $this->load->model('berita_m', 'berita');
    }

    public function index($row = NULL)
    {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        if (empty($row)) {
            $row = 20;
        }

        $filter = $this->session->userdata('filter_members');
        $order_by = $this->session->userdata('ob_members');
        $order_type = $this->session->userdata('ot_members');

        $this->load->database();
        $jumlah_data = $this->berita
            ->count_rows();

        $this->load->library('pagination');

        $config['total_rows'] = $jumlah_data;
        $config['per_page'] = $row;
        $config['base_url'] = base_url() . '/berita/index/' . $row . '/';
        $config['uri_segment'] = 4;

        $config['full_tag_open'] = "<ul class='pagination pagination-sm' style='position:relative; top:-68px;'>";
        $config['full_tag_close'] = "</ul>";
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

        $from = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

        if ($from == 0) {
            $from = "0";
        }
        $this->pagination->initialize($config);

        $data['newsletters'] = $this->berita
            ->limit($config['per_page'], $offset = $from)
            ->get_all();

        $data['row'] = $row;
        $data['jumlah_data'] = $jumlah_data;
        $data['paginasi'] = $this->pagination->create_links();
        $data['filter'] = $filter;
        $data['order_by'] = $order_by;
        $data['order_type'] = $order_type;

        $this->generateCsrf();
        $this->render('admin/newsletter/index', $data);
    }

    public function form()
    {
        $this->generateCsrf();
        $this->render('admin/newsletter/create');
    }

    public function simpan()
    {
        $data = $this->input->post();
        if ($berita_id = $this->berita->from_form(NULL, $data)->insert()) {
            $this->message('Berita Berhasil Disimpan', 'success');
            $this->go('berita/edit/' . $berita_id);
        } else {
            $this->message('Berita Gagal Disimpan', 'warning');
            $this->go('berita/form');
        }
    }

    public function edit($id)
    {
        $data['berita'] = $this->berita->get($id);
        $this->generateCsrf();
        $this->render('admin/newsletter/edit', $data);
    }

    public function pelanggan($row = NULL)
    {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }

        if (empty($row)) {
            $row = 20;
        }

        $filter = $this->session->userdata('filter_members');
        $order_by = $this->session->userdata('ob_members');
        $order_type = $this->session->userdata('ot_members');

        $this->load->database();
        $jumlah_data = $this->subscriber
            ->count_rows();

        $this->load->library('pagination');

        $config['total_rows'] = $jumlah_data;
        $config['per_page'] = $row;
        $config['base_url'] = base_url() . '/subscriber/index/' . $row . '/';
        $config['uri_segment'] = 4;

        $config['full_tag_open'] = "<ul class='pagination pagination-sm' style='position:relative; top:-68px;'>";
        $config['full_tag_close'] = "</ul>";
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

        $from = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

        if ($from == 0) {
            $from = "0";
        }
        $this->pagination->initialize($config);

        $data['subscribers'] = $this->subscriber
            ->limit($config['per_page'], $offset = $from)
            ->get_all();

        $data['row'] = $row;
        $data['jumlah_data'] = $jumlah_data;
        $data['paginasi'] = $this->pagination->create_links();
        $data['filter'] = $filter;
        $data['order_by'] = $order_by;
        $data['order_type'] = $order_type;

        $this->generateCsrf();
        $this->render('admin/subscriber/index', $data);
    }

    public function langganan()
    {
        $data = $this->input->post();
        $data['created_by'] = 1;
        if ($this->subscriber->from_form(NULL, $data)->insert()) {
            $this->message('Anda Berhasil Berlanggan Berita');
        } else {
            $this->message('Terjadi Kesalahan. Mungkin Nama Anda Telah Terdaftar atau Silahkan Coba Lagi.');
        }
        $this->go('/');
    }

    function export_subcribers()
    {
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline = "\r\n";
        $filename = "subscribers.csv";
        $query = "SELECT 'email' FROM subscribers WHERE 'status' = '1'";
        $result = $this->db->query($query);
        $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
        force_download($filename, $data);
    }

    public function kirim($id)
    {
        $berita = $this->berita->get($id);
        $subscribers = $this->subscriber->get_all();

        foreach ($subscribers as $subs) {
            $this->email->from('order@senyummedia.com', 'Senyummedia');
            $this->email->to($subs->email);
            $this->email->cc('info@senyummedia.co.id');
            $this->email->subject($berita->title);
            $this->email->message($berita->body);
            $this->email->send();
        }

        $this->message('Berita Terkirim');

        $this->go('berita/edit/' . $id);
    }

    public function unsubscribe($id_subscriber)
    {
        if($this->subscriber->delete($id_subscriber)){
        $this->message('Berita Berhasil Disimpan', 'success');
            $this->go('berita');
        } else {
            $this->message('Berita Gagal Disimpan', 'warning');
            $this->go('berita');
        }
    }

    public function hapus($id)
    {
        if($this->berita->delete($id)){
            $this->message('Berita Berhasil Disimpan', 'success');
            $this->go('berita');
        } else {
            $this->message('Berita Gagal Disimpan', 'warning');
            $this->go('berita');
        }
    }
}