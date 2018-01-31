<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Halaman extends MY_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->redirect_if_not_admin();
		$this->load->helper(array('potong_teks', 'cek_file'));
		$this->load->model(array('pages_m'));

		$this->slug_config($this->pages_m->table, 'name');
	}

	public function index()
	{
		$data['pages_0'] = $this->pages_m->where('section', '0')->get_all();
		$data['pages_1'] = $this->pages_m->where('section', '1')->get_all();
		$data['pages_2'] = $this->pages_m->where('section', '2')->get_all();

		$this->render('admin/pages/index', $data);
	}

	public function detail($slug = NULL)
	{
		if (is_null($slug) || empty($slug)) {
			$this->message('Halaman tidak ditemukan');
			$this->go('halaman');
		}else{
			$data['page'] = $this->pages_m->get(array('slug' => $slug));
			$this->render('admin/pages/detail', $data);
		}
	}

	public function tambah()
	{
		$this->generateCsrf();
		$this->render('admin/pages/create');
	}

	public function simpan()
	{
		$input = $this->input->post();
		$input['slug'] = $this->slug->create_uri($input);

		$insert = $this->pages_m
		->from_form(NULL, array(
			'slug' => $input['slug']
			))->insert();

		if ($insert === FALSE) {
			$this->message('Terjadi kesalahan sistem saat menambah halaman baru! Coba lagi nanti.', 'danger');
		}else{
			$this->message('Sukses menambah halaman baru.', 'success');
		}

		$this->go('halaman');
	}

	public function sunting($id = NULL)
	{
		if (is_null($id) || empty($id)) {
			$this->message('Halaman tidak ditemukan');
			$this->go('halaman');
		}else{
			$data['page'] = $this->pages_m->get($id);

			$this->generateCsrf();
			$this->render('admin/pages/sunting', $data);
		}
	}

	public function ubah($id = NULL)
	{
		if (is_null($id) || empty($id)) {
			$this->message('Halaman tidak ditemukan');
			$this->go('halaman');
		}else{
			$input = $this->input->post();
			$input['slug'] = $this->slug->create_uri($input);

			$update = $this->pages_m
			->from_form(NULL, array(
				'slug' => $input['slug']
				), array('id' => $id))->update();

			if ($update === FALSE) {
				$this->message('Terjadi kesalahan sistem saat mengubah halaman baru! Coba lagi nanti.', 'danger');
			}else{
				$this->message('Sukses mengubah halaman baru.', 'success');
			}

			$this->go('halaman');
		}
	}

	public function hapus($id = NULL)
	{
		if (is_null($id) || empty($id)) {
			$this->message('Halaman tidak ditemukan');
			$this->go('halaman');
		}else{
			$delete = $this->pages_m->delete($id);

			if ($delete === FALSE) {
				$this->message('Terjadi kesalahan sistem saat menghapus halaman baru! Coba lagi nanti.', 'danger');
			}else{
				$this->message('Sukses menghapus halaman baru.', 'success');
			}

			$this->go('halaman');
		}
	}
}