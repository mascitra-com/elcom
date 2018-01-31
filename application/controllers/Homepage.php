<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Homepage extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->redirect_if_admin();
        $this->_accessable = TRUE;
        $this->load->helper(array('potong_teks', 'cek_file'));
        $this->load->model(array('categories_m', 'products_m', 'producers_m'));
        $this->generateCsrf();
    }

    public function index()
    {
        if ($this->ion_auth->logged_in() && $this->session->userdata('product')) {
            $this->session->unset_userdata('product');
            $this->go('member/keranjang');
        }
        $data['most_popular_products'] = $this
            ->products_m
            ->fields('category_id, code, slug, name, overview, description, price, discount, image_1, created_at')
            ->order_by('boughted', 'desc')
            ->limit(9)
            ->with_category('fields:name')
            ->get_all();

        $data['newest_products'] = $this
            ->products_m
            ->fields('category_id, code, slug, name, overview, description, price, discount, image_1, created_at')
            ->order_by('created_at', 'desc')
            ->limit(9)
            ->with_category('fields:name')
            ->get_all();

        $data['discount_20'] = $this
            ->products_m
            ->fields('category_id, code, slug, name, overview, description, price, discount, image_1, created_at')
            ->where('discount', '0.2')
            ->order_by('created_at', 'desc')
            ->limit(6)
            ->with_category('fields:name')
            ->get_all();

        $data['discount_10'] = $this
            ->products_m
            ->fields('category_id, code, slug, name, overview, description, price, discount, image_1, created_at')
            ->where('discount', '0.1')
            ->order_by('created_at', 'desc')
            ->limit(6)
            ->with_category('fields:name')
            ->get_all();

        $data['producers'] = $this
            ->producers_m
            ->fields('slug, image')
            ->get_all();

        $category = $this->categories_m->get(1);
        $categories = $this->get_categories(array(), $category->id);
        $data['product_category1'] = $this
            ->products_m
            ->fields('category_id, code, slug, name, overview, description, price, discount, image_1, created_at')
            ->where('category_id', $categories)
            ->order_by('discount', 'desc')
            ->limit(15)
            ->get_all();
        $category = $this->categories_m->get(2);
        $categories = $this->get_categories(array(), $category->id);
        $data['product_category2'] = $this
            ->products_m
            ->fields('category_id, code, slug, name, overview, description, price, discount, image_1, created_at')
            ->where('category_id', $categories)
            ->order_by('discount', 'desc')
            ->limit(15)
            ->get_all();
        $category = $this->categories_m->get(3);
        $categories = $this->get_categories(array(), $category->id);
        $data['product_category3'] = $this
            ->products_m
            ->fields('category_id, code, slug, name, overview, description, price, discount, image_1, created_at')
            ->where('category_id', $categories)
            ->order_by('discount', 'desc')
            ->limit(15)
            ->get_all();
        $this->generateCsrf();
        $this->render('homepage/index', $data);
    }

    public function produk($slug = NULL)
    {
        if (is_null($slug) || empty($slug)) {
            $this->message('Produk tidak ditemukan.');
            $this->go('/');
        } else {
            $data['product'] = $this->products_m
                ->get(array('slug' => $slug));
            if (!$data['product']) {
                $this->message('Produk tidak ditemukan.');
                $this->go('/');
            }
            $breadcumb = $this->breadcumb($data['product']->category_id);
            $data['breadcumb'] = array_reverse($breadcumb);
            // Nama Termirip & Kategori Sama
            $similiar_products = $this->db
                ->from('products')
                ->limit(5)
                ->where('slug <>', $slug)
                ->group_start()
                ->where('name', 'LIKE', substr($data['product']->name, 0, 6))
                ->where('category_id', $data['product']->category_id)
                ->group_end()
                ->order_by('created_at', 'DESC')
                ->get()
                ->result();

            // Kategori Sama
            if (count($similiar_products) < 5) {
                $temp = $this->db
                    ->from('products')
                    ->limit(5 - count($similiar_products))
                    ->where('slug <>', $slug)
                    ->where('category_id', $data['product']->category_id)
                    ->order_by('created_at', 'DESC')
                    ->get()
                    ->result();
                $similiar_products = array_merge($similiar_products, $temp);
            }

            // Produsen Sama
            if (count($similiar_products) < 5) {
                $temp = $this->db
                    ->from('products')
                    ->limit(5 - count($similiar_products))
                    ->where('slug <>', $slug)
                    ->where('producer_id', $data['product']->producer_id)
                    ->order_by('created_at', 'DESC')
                    ->get()
                    ->result();
                $similiar_products = array_merge($similiar_products, $temp);
            }

            // Terbaru
            if (count($similiar_products) < 5) {
                $temp = $this->db
                    ->from('products')
                    ->limit(5 - count($similiar_products))
                    ->where('slug <>', $slug)
                    ->order_by('created_at', 'DESC')
                    ->get()
                    ->result();
                $similiar_products = array_merge($similiar_products, $temp);
            }
            $data['similar_products'] = (object)$similiar_products;
            $this->generateCsrf();
            $this->render('homepage/product-detail', $data);
        }
    }

    private function breadcumb($categori_id, $breadcumb = array())
    {
        $category = $this->categories_m->get(array('id' => $categori_id));
        array_push($breadcumb, array($category->slug, $category->name));
        if (!is_null($category->parent_id)) {
            $breadcumb = $this->breadcumb($category->parent_id, $breadcumb);
        }
        return $breadcumb;
    }

    public function search($search = NULL, $orderBy = 'terbaru', $perpage = 12)
    {
        if (!$this->session->userdata('search_product') && !$search)
            $search = $this->input->post('search_product');

        if ($this->session->userdata('search_product') && $this->session->userdata('search') == $search) {
            $search = $this->session->userdata('search_product');
        } else {
            $this->session->set_userdata('orderBySearch', $search);
        }
        if ($this->session->userdata('orderBySearch') && $this->session->userdata('orderBySearch') == $orderBy) {
            $orderBy = $this->session->userdata('orderBySearch');
        } else {
            $this->session->set_userdata('orderBySearch', $orderBy);
        }
        $this->load->library('pagination');
        $search = str_replace('%20', ' ', $search);
        $jumlah_data = $this
            ->products_m
            ->where('name', 'like', $search)
            ->order_by('created_at', 'desc')
            ->with_category('fields:name')
            ->count_rows();
        $data['total'] = $jumlah_data;
        $data['perpage'] = $perpage;
        $data['search'] = $search;
        $config['total_rows'] = $jumlah_data;
        $config['per_page'] = $perpage;
        $config['base_url'] = base_url() . '/homepage/search/' . $search . '/' . $orderBy. '/' . $perpage;
        $config['uri_segment'] = 6;
        $config['use_page_numbers'] = TRUE;

        $config['full_tag_open'] = "<ul class='pagination no-margin-top'>";
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
        $this->pagination->initialize($config);
        $data['paginasi'] = $this->pagination->create_links();
        $from = ($this->uri->segment(6)) ? (($this->uri->segment(6) != 12) ? $this->uri->segment(6) : 0) - 1 : 0;

        $products = $this
            ->products_m
            ->where('name', 'like', $search)
            ->limit($config['per_page'], $from * $config['per_page'])
            ->with_category('fields:name, slug')
            ->with_producer('fields:name, slug');
        if ($orderBy == 'a-z')
            $products = $products->order_by('name', 'asc')->get_all();
        else if ($orderBy == 'z-a') {
            $products = $products->order_by('name', 'desc')->get_all();
        } else if ($orderBy == 'termurah') {
            $products = $products->order_by('price', 'asc')->get_all();
        } else if ($orderBy == 'termahal') {
            $products = $products->order_by('price', 'desc')->get_all();
        } else if ($orderBy == 'terpopuler') {
            $products = $products->order_by('boughted', 'desc')->get_all();
        } else {
            $products = $products->order_by('created_at', 'desc')->get_all();
        }

        $data['products'] = $products;

        $data['producers'] = $this
            ->producers_m
            ->fields('slug, image')
            ->get_all();

        $this->generateCsrf();
        $type = $this->input->get('type');
        if($type === "text" || ($this->session->userdata('search_type') === "text" && $type !== "image")){
            $this->session->set_userdata('search_type', 'text');
            $this->render('homepage/product-search-list', $data);
        } else {
            if($type === "image")
                $this->session->unset_userdata('search_type');
            $this->render('homepage/product-search', $data);
        }
    }

    public function kategori($slug = NULL, $orderBy = 'terbaru', $perPageKategori = 12)
    {
        if ($this->session->userdata('orderByKategori') && $this->session->userdata('orderByKategori') === $orderBy) {
            $orderBy = $this->session->userdata('orderByKategori');
        } else {
            if($perPageKategori == 12)
                $this->session->unset_userdata('category_type');
            $this->session->set_userdata('orderByKategori', $orderBy);
        }
        if (is_null($slug) || empty($slug)) {
            $this->message('Kategori tidak ditemukan.');
            $this->go('/');
        } else {
            //ambil data kategori berdasarkan slug
            $category = $this->categories_m->get(array('slug' => $slug));
            $categories = $this->get_categories(array(), $category->id);
            $this->load->library('pagination');

            $jumlah_data = $this
                ->products_m
                ->where('category_id', $categories)
                ->count_rows();
            $data['total'] = $jumlah_data;
            $data['perpage'] = $perPageKategori;
            $config['total_rows'] = $jumlah_data;
            $config['per_page'] = $perPageKategori;
            $config['base_url'] = base_url() . '/homepage/kategori/' . $slug . '/' . $orderBy . '/' . $perPageKategori;
            $config['uri_segment'] = 6;
            $config['use_page_numbers'] = TRUE;
            $config['full_tag_open'] = "<ul class='pagination no-margin-top'>";
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
            $this->pagination->initialize($config);
            $data['paginasi'] = $this->pagination->create_links();
            $from = ($this->uri->segment(6)) ? (($this->uri->segment(6) != 12) ? $this->uri->segment(6) : 0) - 1 : 0;
            $products = $this
                ->products_m
                ->where('category_id', $categories)
                ->limit($config['per_page'], $from * $config['per_page'])
                ->with_category('fields:name, slug')
                ->with_producer('fields:name, slug');
            if ($orderBy == 'a-z')
                $products = $products->order_by('name', 'asc')->get_all();
            else if ($orderBy == 'z-a') {
                $products = $products->order_by('name', 'desc')->get_all();
            } else if ($orderBy == 'termurah') {
                $products = $products->order_by('price', 'asc')->get_all();
            } else if ($orderBy == 'termahal') {
                $products = $products->order_by('price', 'desc')->get_all();
            } else if ($orderBy == 'terpopuler') {
                $products = $products->order_by('boughted', 'desc')->get_all();
            } else {
                $products = $products->order_by('created_at', 'desc')->get_all();
            }
            $data['products'] = $products;

            $data['producers'] = $this
                ->producers_m
                ->fields('slug, image')
                ->get_all();

            $data['category'] = $category;

            $this->generateCsrf();
            $type = $this->input->get('type');
            if($type === "text" || ($this->session->userdata('category_type') === "text" && $type !== "image")){
                $this->session->set_userdata('category_type', 'text');
                $this->render('homepage/category_list', $data);
            } else {
                if($type === "image")
                    $this->session->unset_userdata('category_type');
                $this->render('homepage/category', $data);
            }
        }
    }

    public function produsen($slug = NULL, $orderBy = 'terbaru', $perPageKategori = 12)
    {
        if ($this->session->userdata('orderByProdusen') && $this->session->userdata('orderByProdusen') == $orderBy) {
            $orderBy = $this->session->userdata('orderByProdusen');
        } else {
            if($perPageKategori == 12)
                $this->session->unset_userdata('producer_type');
            $this->session->set_userdata('orderByProdusen', $orderBy);
        }
        if (is_null($slug) || empty($slug)) {
            $this->message('Produsen tidak ditemukan.');
            $this->go('/');
        } else {
            //ambil data produsen berdasarkan slug
            $producer = $this->producers_m->fields('id, name')->get(array('slug' => $slug));
            $this->load->library('pagination');

            $jumlah_data = $this
                ->products_m
                ->where('producer_id', $producer->id)
                ->count_rows();
            $data['perpage'] = $perPageKategori;
            $data['total'] = $jumlah_data;
            $config['total_rows'] = $jumlah_data;
            $config['per_page'] = $perPageKategori;
            $config['base_url'] = base_url() . '/homepage/produsen/' . $slug . '/' . $orderBy . '/' . $perPageKategori;
            $config['uri_segment'] = 6;
            $config['use_page_numbers'] = TRUE;
            $config['full_tag_open'] = "<ul class='pagination no-margin-top'>";
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
            $this->pagination->initialize($config);
            $data['paginasi'] = $this->pagination->create_links();
            $from = ($this->uri->segment(6)) ? (($this->uri->segment(6) != 12) ? $this->uri->segment(6) : 0) - 1 : 0;
            $products = $this
                ->products_m
                ->where('producer_id', $producer->id)
                ->limit($config['per_page'], $from * $config['per_page'])
                ->with_category('fields:name, slug')
                ->with_producer('fields:name, slug');

            if ($orderBy == 'a-z')
                $products = $products->order_by('name', 'asc')->get_all();
            else if ($orderBy == 'z-a') {
                $products = $products->order_by('name', 'desc')->get_all();
            } else if ($orderBy == 'termurah') {
                $products = $products->order_by('price', 'asc')->get_all();
            } else if ($orderBy == 'termahal') {
                $products = $products->order_by('price', 'desc')->get_all();
            } else if ($orderBy == 'terpopuler') {
                $products = $products->order_by('boughted', 'desc')->get_all();
            } else {
                $products = $products->order_by('created_at', 'desc')->get_all();
            }
            $data['products'] = $products;
            $data['producers'] = $this
                ->producers_m
                ->fields('slug, image')
                ->get_all();

            $data['producer'] = $producer;
            $this->generateCsrf();
            $type = $this->input->get('type');
            if($type === "text" || ($this->session->userdata('producer_type') === "text" && $type !== "image")){
                $this->session->set_userdata('producer_type', 'text');
                $this->render('homepage/producer_list', $data);
            } else {
                if($type === "image")
                    $this->session->unset_userdata('producer_type');
                $this->render('homepage/producer', $data);
            }
        }
    }

    public function halaman($slug = NULL)
    {
        if (is_null($slug) || empty($slug)) {
            # todo message
            $this->message('Halaman tidak ditemukan.');
            $this->go('/');
        } else {
            $this->load->model('pages_m');
            $data['page'] = $this->pages_m->get(array('slug' => $slug));

            $this->render('homepage/halaman', $data);
        }
    }

    private function get_categories($categories = array(), $parent_id)
    {
        $categories[] += $parent_id;
        if ($cats = $this->categories_m->where('parent_id', $parent_id)->get_all()) {
            foreach ($cats as $cat) {
                $categories = $this->get_categories($categories, $cat->id);
            }
        }
        return $categories;
    }
}
