<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{

    protected $_accessable;
    protected $_csrf;
    protected $_ajax_csrf;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('categories_m', 'products_m'));
        $this->load->helper('privileges_sidebar');
        $this->load->library('ion_auth');
    }

    public function _remap($method, $param = array())
    {
        if (method_exists($this, $method)) {
            if ($this->ion_auth->logged_in() || $this->_accessable) {
                return call_user_func_array(array($this, $method), $param);
            } else {
                $this->go('auth');
            }
        } else {
            show_404();
        }
    }

    protected function redirect_if_admin()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            // $this->message('Anda tidak berwenang mengakses halaman ini.', 'danger');
            $this->go('dashboard');
        }
    }

    protected function redirect_if_not_admin()
    {
        if ($this->ion_auth->logged_in() && !$this->ion_auth->is_admin()) {
            die('Anda tidak berwenang mengakses halaman ini.');
        }
    }

    protected function check_privileges($class, $method)
    {
        foreach ($this->_privileges as $privilege) {
            if (strtolower($class . '/' . $method) == strtolower($privilege)) {
                return TRUE;
            }
        }
        return FALSE;
    }

    /**
     * Berfungsi untuk melakukan redirect
     * @param $link = alamat tujuan
     */
    protected function go($link)
    {
        redirect(site_url($link));
    }

    /**
     * Berfungsi untuk mengeksekusi view
     */
    protected function render($view, $data = array())
    {
        //ambil data kategori
        if ($this->uri->segment(1) == "homepage" || $this->uri->segment(1) == "member" || $this->uri->segment(1) == "auth" || is_null($this->uri->segment(1))) {
            $results = $this
                ->categories_m
                ->get_all();
            $data['categories'] = $this->get_parent($results);
            $data['categories_navbar'] = $this->get_parentNavbar($results);
            $this->load->model(array('reseller_m', 'users_m'));
            $data['reseller'] = $this->reseller_m->where('user_id', $this->ion_auth->get_current_user_id())->get();
            $data['username'] = $this->users_m->get($this->session->userdata('user_id'));
        }
        //ambil data pengaturan website
        $this->load->model('settings_m');
        $data['setting'] = $this->settings_m->get();
        //data slider
        $data['sliders'] = explode('|', $data['setting']->sliders_images);

        //ambil data halaman
        $this->load->model('pages_m');
        $data['footer_0'] = $this->pages_m->where('section', '0')->get_all();
        $data['footer_1'] = $this->pages_m->where('section', '1')->get_all();
        $data['footer_2'] = $this->pages_m->where('section', '2')->get_all();

        $data['csrf'] = $this->_csrf;
        $data['ajax_csrf'] = $this->_ajax_csrf;
        $this->blade->render($view, $data);
    }

    /**
     * @param      $results
     * @param null $parent_id
     *
     * @return string
     */
    public function get_parent($results, $parent_id = NULL)
    {
        $menu = '';
        for ($i = 0; $i < sizeof($results); $i++) {
            if ($results[$i]->parent_id == $parent_id) {
                if ($this->parent_child($results, $results[$i]->id)) {
                    $sub_menu = $this->get_parent($results, $results[$i]->id);
                    $categories = $this->categories_m->where('parent_id', $results[$i]->id)->get_all();
                    $ids = array();
                    if($categories){
                        foreach ($categories as $cat) {
                            $ids[] .= $cat->id;
                        }
                    }
                    $count = 0;
                    if(count($ids)) {
                        $this->db->where_in('category_id', $ids);
                        $this->db->from('products');
                        $count += $this->db->count_all_results();
                    }
                    if($count){
                        $menu = $this->addParent($results, $i, $sub_menu, $menu);
                    }
                } else {
                    if ($this->products_m->where('category_id', $results[$i]->id)->count_rows()) {
                        $menu = $this->addChild($results, $i, $menu);
                    }
                }
            }
        }
        return $menu;
    }

    private function parent_child($results, $kode_induk)
    {
        for ($i = 0; $i < sizeof($results); $i++) {
            if ($results[$i]->parent_id == $kode_induk) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param $results
     * @param $i
     * @param $sub_menu
     * @param $menu
     *
     * @return string
     */
    private function addParent($results, $i, $sub_menu, $menu)
    {
        $menu .= '<button class="list-group-item" data-toggle="collapse" data-target="#sm' . $i . '"><a href="' . (site_url('homepage/kategori/') . strtolower($results[$i]->slug)) . '">
                                ' . ucwords(strtolower($results[$i]->name)) . '</a><span class="caret"></span><span class="badge"></span></button>' .
            '<div id="sm' . $i . '" class="sublinks collapse">' .
            $sub_menu .
            '</div>';
        return $menu;
    }

    /**
     * @param $results
     * @param $i
     * @param $menu
     *
     * @return string
     */
    private function addChild($results, $i, $menu)
    {
        $menu .= ' <a class="list-group-item" href="' . site_url('homepage/kategori/') . $results[$i]->slug . '">
            ' . ucwords(strtolower($results[$i]->name)) . '
        		<span class="badge">' . $this->products_m->where('category_id', $results[$i]->id)->count_rows() . '</span></a>';
        return $menu;
    }

    /**
     * @param      $results
     * @param null $parent_id
     *
     * @return string
     */
    public function get_parentNavbar($results, $parent_id = NULL)
    {
        $menu = '';
        for ($i = 0; $i < sizeof($results); $i++) {
            if ($results[$i]->parent_id == $parent_id) {
                if ($this->parent_childNavbar($results, $results[$i]->id)) {
                    $sub_menu = $this->get_parentNavbar($results, $results[$i]->id);
                    $categories = $this->categories_m->where('parent_id', $results[$i]->id)->get_all();
                    $ids = array();
                    if($categories){
                        foreach ($categories as $cat) {
                            $ids[] .= $cat->id;
                        }
                    }
                    $count = 0;
                    if(count($ids)) {
                        $this->db->where_in('category_id', $ids);
                        $this->db->from('products');
                        $count += $this->db->count_all_results();
                    }
                    if($count){
                        $menu = $this->addParentNavbar($results, $i, $sub_menu, $menu);
                    }
                } else {
                    if ($this->products_m->where('category_id', $results[$i]->id)->count_rows()) {
                        $menu = $this->addChildNavbar($results, $i, $menu);
                    }
                }
            }
        }
        return $menu;
    }

    private function parent_childNavbar($results, $kode_induk)
    {
        for ($i = 0; $i < sizeof($results); $i++) {
            if ($results[$i]->parent_id == $kode_induk) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param $results
     * @param $i
     * @param $sub_menu
     * @param $menu
     *
     * @return string
     */
    private function addParentNavbar($results, $i, $sub_menu, $menu)
    {
        $menu .= '<li><a href="#">' . ucwords(strtolower($results[$i]->name)) . ' <span class="caret"></span></a>
        <ul class="dropdown-menu">'.
            $sub_menu .
            '</ul></li>';
        return $menu;
    }

    /**
     * @param $results
     * @param $i
     * @param $menu
     *
     * @return string
     */
    private function addChildNavbar($results, $i, $menu)
    {
        $menu .= '<li><a href="' . site_url('homepage/kategori/') . $results[$i]->slug . '">' . ucwords(strtolower($results[$i]->name)) . '</a></li>';
        return $menu;
    }


    /**
     * Berfungsi untuk menampilkan membuat input csrf tipe hidden
     *
     * @return string
     */
    protected function generateCsrf()
    {
        return $this->_csrf = "<input type='hidden' name='" . $this->security->get_csrf_token_name() . "' value='" . $this->security->get_csrf_hash() . "'>";
    }

    /**
     * Berfungsi untuk membuat csrf token untuk ajax
     *
     * @return string
     */
    protected function generateAjaxCsrf()
    {
        $csrfName = "'" . $this->security->get_csrf_token_name() . "'";
        $csrfHash = "'" . $this->security->get_csrf_hash() . "'";

        return $this->_ajax_csrf = array($csrfName, $csrfHash);
    }

    /**
     * Berfungsi untuk menampilkan pesan
     *
     * @param string $msg = isi pesan
     * @param string $typ = tipe pesan (default, primary, success, warning, danger)
     */
    protected function message($msg = 'pesan', $typ = 'info')
    {
        $this->session->set_flashdata('message', array($msg, $typ));
    }

    /**
     * @param $table - Table Name
     * @param $title - Field as reference for slug
     */
    protected function slug_config($table, $title)
    {
        $config = array(
            'table' => $table,
            'id' => 'id',
            'field' => 'slug',
            'title' => $title,
            'replacement' => 'dash' // Either dash or underscore
        );
        $this->slug->set_config($config);
    }

    protected function do_upload($filetype, $prefix, $input_name, $additional_file_name, $file_path)
    {
        $set_name = fileName($filetype, $prefix, $additional_file_name, 3);
        $path = $_FILES[$input_name]['name'];
        if (empty($path)) {
            return 'default.png';
        } else {
            $extension = "." . pathinfo($path, PATHINFO_EXTENSION);
            // $config['upload_path']          = './assets/images/producers/';
            $config['upload_path'] = './assets/' . $file_path;
            $config['allowed_types'] = '*';
            $config['max_size'] = 3024;
            $config['file_name'] = $set_name . $extension;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            // proses upload
            $upload = $this->upload->do_upload($input_name);

            if ($upload == FALSE) {
                return $this->message($this->upload->display_errors(), 'danger');
            }

            $upload = $this->upload->data();

            return $upload['file_name'];
        }
    }

    protected function delete_files($filename, $file_path)
    {
        $this->load->helper('file');
        // $path = $_SERVER['DOCUMENT_ROOT'].'assets/images/berita/';
        $path = $_SERVER['DOCUMENT_ROOT'] . '/senyum/assets/' . $file_path;
        $get_file = $path . $filename;
        if (file_exists($get_file)) {
            unlink($get_file);
            return TRUE;
        }
        return FALSE;
    }

    protected function ongkir($query, $post = FALSE, $data = NULL)
    {
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));

        if ( ! $response = $this->cache->get(md5($query)))
        {
            $curl = curl_init();
            if ($post) {
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => $data,
                    CURLOPT_HTTPHEADER => array(
                        "content-type: application/x-www-form-urlencoded",
                        "key: 33f1f5b2207faf50dfb077d3a5203317"
                    ),
                ));
            } else {
                curl_setopt_array($curl, array(
                    CURLOPT_URL => $query,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => array(
                        "key: 33f1f5b2207faf50dfb077d3a5203317"
                    ),
                ));
            }
            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                return false;
            } else {
                $this->cache->save(md5($query), $response, 300);
                $response = json_decode($response, true);
                return $response['rajaongkir']['results'];
            }
        } else {
            $response = json_decode($response, true);
            return $response['rajaongkir']['results'];
        }
    }

    private function navbar()
    {
        $navbar = '';

        return $navbar;
    }
}