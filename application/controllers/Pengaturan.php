<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Pengaturan extends MY_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->redirect_if_not_admin();
		$this->load->helper(array('potong_teks', 'cek_file'));
		$this->load->model(array('settings_m'));
	}

	public function index()
	{
		$data['setting'] = $this->settings_m->get();

		$data['sliders'] = explode('|', $data['setting']->sliders_images);

		$this->generateCsrf();
		$this->render('admin/settings/index', $data);
	}

	public function update_modal_info()
	{
		$update = $this->input->post();

		$query = $this->settings_m->update($update, 1);

		if ($query === FALSE) {
			$this->message('Terjadi kesalahan sistem saat mengubah informasi modal pop-up halaman depan. Coba lagi nanti.', 'danger');
		}else{
			$this->message('Sukses mengubah informasi modal pop-up halaman depan', 'success');
		}
		$this->go('pengaturan');
	}

	public function update_modal_image()
	{
		//hapus gambar sebelumnya
		$prev_modal_image_name = $this->settings_m->get()->modal_image;
		//tidak hapus jika nama gambar 'default'
		if ($prev_modal_image_name !== 'default.png') {
			$this->delete_files($prev_modal_image_name, 'images/modal/');
		}

		//upload gambar
		$image_name = $this->do_upload(3, 'MDL', 'image', '', 'images/modal');

		//update modal_image
		$query = $this->settings_m->update(array('modal_image' => $image_name), 1);

		if ($query === FALSE) {
			$this->message('Terjadi kesalahan sistem saat mengunggah gambar modal/pop-up pada halaman depan. Coba lagi nanti.', 'danger');
		}else{
			$this->message('Berhasil mengunggah gambar modal/pop-up pada halaman depan.', 'success');
		}
		$this->go('pengaturan');
	}

	public function hapus_modal_image()
	{
		//hapus gambar sebelumnya
		$prev_modal_image_name = $this->settings_m->get()->modal_image;
		//tidak hapus jika nama gambar 'default'
		if ($prev_modal_image_name !== 'default.png') {
			$this->delete_files($prev_modal_image_name, 'images/modal/');
		}

		//update modal_image
		$query = $this->settings_m->update(array('modal_image' => 'default.png'), 1);

		if ($query === FALSE) {
			$this->message('Terjadi kesalahan sistem saat menghapus gambar modal/pop-up pada halaman depan. Coba lagi nanti.', 'danger');
		}else{
			$this->message('Berhasil menghapus gambar modal/pop-up pada halaman depan.', 'success');
		}
		$this->go('pengaturan');
	}

    public function aktifkan_modal()
    {
        $this->settings_m->update(array('modal_active' => 'Aktif'), 1);
        $this->go('pengaturan');
    }

    public function nonaktifkan_modal()
    {
        $this->settings_m->update(array('modal_active' => 'Tidak Aktif'), 1);
        $this->go('pengaturan');
    }
	public function update_banner_tengah()
	{
        $link = $this->input->post('link');
        if(!empty($_FILES['image']['name'])) {
            $prev_banner_center_name = $this->settings_m->get()->banner_center;
            if ($prev_banner_center_name !== 'default.jpg') {
                $this->delete_files($prev_banner_center_name, 'images/banner/center/');
            }
            $image_name = $this->do_upload(3, 'BCT', 'image', '', 'images/banner/center');
            $query = $this->settings_m->update(array('banner_center' => $image_name, 'banner_center_link' => $link), 1);
        } else {
            $query = $this->settings_m->update(array('banner_center_link' => $link), 1);
        }
		if ($query === FALSE) {
			$this->message('Terjadi kesalahan sistem saat mengunggah gambar banner tengah pada halaman depan. Coba lagi nanti.', 'danger');
		}else{
			$this->message('Berhasil mengunggah gambar banner tengah pada halaman depan.', 'success');
		}
		$this->go('pengaturan');
	}

	public function hapus_banner_tengah()
	{
		//hapus gambar sebelumnya
		$prev_banner_center_name = $this->settings_m->get()->banner_center;
		//tidak hapus jika nama gambar 'default'
		if ($prev_banner_center_name !== 'default.png') {
			$this->delete_files($prev_banner_center_name, 'images/banner/center/');
		}

		//update banner_center
		$query = $this->settings_m->update(array('banner_center' => 'default.png', 'banner_center_link' => ''), 1);

		if ($query === FALSE) {
			$this->message('Terjadi kesalahan sistem saat menghapus gambar banner tengah pada halaman depan. Coba lagi nanti.', 'danger');
		}else{
			$this->message('Berhasil menghapus gambar banner tengah pada halaman depan.', 'success');
		}
		$this->go('pengaturan');
	}

	public function update_banner_atas($index = NULL)
	{
		if (is_null($index) || empty($index)) {
			$this->message('Banner tidak ditemukan.','warning');
		}else{
			//hapus gambar sebelumnya
            $col_name = 'banner_header_' . $index;
            $link = $this->input->post('link');
            if(!empty($_FILES['image']['name'])) {
                $prev_banner_header_name = $this->settings_m->get()->$col_name;
                //tidak hapus jika nama gambar 'default'
                if ($prev_banner_header_name !== 'default.jpg') {
                    $this->delete_files($prev_banner_header_name, 'images/banner/header/');
                }
                //upload gambar
                $image_name = $this->do_upload(3, 'BHD', 'image', '', 'images/banner/header');
                $query = $this->settings_m->update(array($col_name => $image_name, $col_name . '_link' => $link), 1);
            } else {
                $query = $this->settings_m->update(array($col_name . '_link' => $link), 1);
            }
			if ($query === FALSE) {
				$this->message('Terjadi kesalahan sistem saat mengunggah gambar banner atas'. $index .'.Coba lagi nanti.', 'danger');
			}else{
				$this->message('Berhasil mengunggah gambar banner atas'. $index . '.' ,'success');
			}
		}
		$this->go('pengaturan');
	}

	public function hapus_banner_atas($index = NULL)
	{
		if (is_null($index) || empty($index)) {
			$this->message('Banner tidak ditemukan.','warning');
		}else{
			//hapus gambar sebelumnya
			$col_name = 'banner_header_'.$index;
			$prev_banner_header_name = $this->settings_m->get()->$col_name;
			//tidak hapus jika nama gambar 'default'
			if ($prev_banner_header_name !== 'default.jpg') {
				$this->delete_files($prev_banner_header_name, 'images/banner/header/');
			}

			//update banner_header
			$query = $this->settings_m->update(array($col_name => 'default.jpg', $col_name . '_link' => ''), 1);

			if ($query === FALSE) {
				$this->message('Terjadi kesalahan sistem saat menghapus gambar banner atas'. $index .'.Coba lagi nanti.', 'danger');
			}else{
				$this->message('Berhasil menghapus gambar banner atas'. $index . '.' ,'success');
			}
		}
		$this->go('pengaturan');
	}

	public function update_banner_samping()
	{
        $link = $this->input->post('link');
        if(!empty($_FILES['image']['name'])) {
            //hapus gambar sebelumnya
            $prev_banner_side_name = $this->settings_m->get()->banner_side;
            //tidak hapus jika nama gambar 'default'
            if ($prev_banner_side_name !== 'default.png') {
                $this->delete_files($prev_banner_side_name, 'images/banner/side/');
            }

            //upload gambar
            $image_name = $this->do_upload(3, 'BSD', 'image', '', 'images/banner/side');
            //update banner_side
            $query = $this->settings_m->update(array('banner_side' => $image_name, 'banner_side_link' => $link), 1);
        } else {
            $query = $this->settings_m->update(array('banner_side_link' => $link), 1);
        }
		if ($query === FALSE) {
			$this->message('Terjadi kesalahan sistem saat mengunggah gambar banner samping. Coba lagi nanti.', 'danger');
		}else{
			$this->message('Berhasil mengunggah gambar banner samping.', 'success');
		}
		$this->go('pengaturan');
	}

	public function hapus_banner_samping()
	{
		//hapus gambar sebelumnya
		$prev_banner_side_name = $this->settings_m->get()->banner_side;
		//tidak hapus jika nama gambar 'default'
		if ($prev_banner_side_name !== 'default.png') {
			$this->delete_files($prev_banner_side_name, 'images/banner/side/');
		}
		
		//update banner_side
		$query = $this->settings_m->update(array('banner_side' => 'default.png', 'banner_side_link'), 1);

		if ($query === FALSE) {
			$this->message('Terjadi kesalahan sistem saat menghapus gambar banner samping. Coba lagi nanti.', 'danger');
		}else{
			$this->message('Berhasil menghapus gambar banner samping.', 'success');
		}
		$this->go('pengaturan');
	}

	public function update_banner_bawah()
	{
        $link = $this->input->post('link');
        if(!empty($_FILES['image']['name'])) {
            //hapus gambar sebelumnya
            $prev_banner_footer_name = $this->settings_m->get()->banner_footer;
            //tidak hapus jika nama gambar 'default'
            if ($prev_banner_footer_name !== 'default.png') {
                $this->delete_files($prev_banner_footer_name, 'images/banner/footer/');
            }

            //upload gambar
            $image_name = $this->do_upload(3, 'BFT', 'image', '', 'images/banner/footer');
            $query = $this->settings_m->update(array('banner_footer' => $image_name, 'banner_footer_link' => $link), 1);
        } else {
            //update banner_footer
            $query = $this->settings_m->update(array('banner_footer_link' => $link), 1);
        }

		if ($query === FALSE) {
			$this->message('Terjadi kesalahan sistem saat mengunggah gambar banner bawah. Coba lagi nanti.', 'danger');
		}else{
			$this->message('Berhasil mengunggah gambar banner bawah.', 'success');
		}
		$this->go('pengaturan');
	}

	public function hapus_banner_bawah()
	{
		//hapus gambar sebelumnya
		$prev_banner_footer_name = $this->settings_m->get()->banner_footer;
		//tidak hapus jika nama gambar 'default'
		if ($prev_banner_footer_name !== 'default.png') {
			$this->delete_files($prev_banner_footer_name, 'images/banner/footer/');
		}
		
		//update banner_footer
		$query = $this->settings_m->update(array('banner_footer' => 'default.png', 'banner_footer_link' => ''), 1);

		if ($query === FALSE) {
			$this->message('Terjadi kesalahan sistem saat menghapus gambar banner bawah. Coba lagi nanti.', 'danger');
		}else{
			$this->message('Berhasil menghapus gambar banner bawah.', 'success');
		}
		$this->go('pengaturan');
	}

	public function tambah_slider()
	{
		//ambil data nama gambar slider di db
		$sliders_names = $this->settings_m->get()->sliders_images;

		//upload slider baru
		$image_name = $this->do_upload(3, 'SLD', 'image', '', 'images/sliders');

		//update dengan menambahkan nama baru ke slider
		$update = $this->settings_m->update(array(
			'sliders_images' => $sliders_names.'|'.$image_name
		), 1);
		if ($update === FALSE) {
			$this->message('Terjadi kesalahan sistem saat menambahkan gambar slider baru. Coba lagi nanti.', 'danger');
		}else{
			$this->message('Berhasil menambahkan gambar slider baru.', 'success');
		}
		$this->go('pengaturan');
	}

	public function update_slider($index = NULL)
	{
		if (is_null($index) || empty($index)) {
			$this->message('Slider tidak ditemukan.', 'warning');
		}else{
			//ambil data nama gambar slider di db
			$sliders = explode('|', $this->settings_m->get()->sliders_images);

			//ambil nama gambar slider yg akan diupdate
			$prev_slider_image_name = $sliders[$index - 1];

			//hapus file gambar slider sebelumnya
			//tidak hapus jika nama gambar 'default'
			if ($prev_slider_image_name !== 'default.png') {
				$this->delete_files($prev_slider_image_name, 'images/sliders/');
			}

			//upload slider baru
			$image_name = $this->do_upload(3, 'SLD', 'image', '', 'images/sliders');

			//update nama slider di db sesuai urutan index
			//ubah array ke index - 1 dg nama slider baru
			$sliders[$index - 1] = $image_name;
			//gabungkan array menjadi string dg pemisah '|'
			$sliders_images_names = implode('|', $sliders);
			//update
			$query = $this->settings_m->update(array('sliders_images' => $sliders_images_names), 1);
			if ($query === FALSE) {
				$this->message('Terjadi kesalahan sistem saat mengunggah gambar slider. Coba lagi nanti.', 'danger');
			}else{
				$this->message('Berhasil mengunggah gambar slider.', 'success');
			}
		}
		$this->go('pengaturan');
	}

	public function hapus_slider($index = NULL)
	{
		if (is_null($index) || empty($index)) {
			$this->message('Slider tidak ditemukan.', 'warning');
		}else{
			//ambil data nama gambar slider di db
			$sliders = explode('|', $this->settings_m->get()->sliders_images);

			//ambil nama gambar slider yg akan diupdate
			$prev_slider_image_name = $sliders[$index - 1];

			//hapus file gambar slider sebelumnya
			//tidak hapus jika nama gambar 'default'
			if ($prev_slider_image_name !== 'default.png') {
				$this->delete_files($prev_slider_image_name, 'images/sliders/');
			}

			//update nama slider di db sesuai urutan index
			//ubah array ke index - 1 dg nama slider baru
			$sliders[$index - 1] = 'default.png';
			//gabungkan array menjadi string dg pemisah '|'
			$sliders_images_names = implode('|', $sliders);
			//update
			$query = $this->settings_m->update(array('sliders_images' => $sliders_images_names), 1);
			if ($query === FALSE) {
				$this->message('Terjadi kesalahan sistem saat menghapus gambar slider. Coba lagi nanti.', 'danger');
			}else{
				$this->message('Berhasil menghapus gambar slider.', 'success');
			}
		}
		$this->go('pengaturan');
	}

	public function update_kontak()
	{
		$update = $this->input->post();

		$query = $this->settings_m->from_form(NULL, NULL, array('id' => 1))->update();

		if ($query === FALSE) {
			$this->message('Terjadi kesalahan sistem saat mengubah informasi kontak website. Coba lagi nanti.', 'danger');
		}else{
			$this->message('Sukses mengubah informasi kontak website', 'success');
		}
		$this->go('pengaturan');
	}
}