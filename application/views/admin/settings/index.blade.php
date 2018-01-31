@layout('_layout/dashboard/index')
@section('title')Pengaturan@endsection

@section('content')
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-theme">
			<div class="panel-heading">
				<h3 class="panel-title">Pengaturan Website</h3>
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs">
					<li role="presentation" class="active"><a href="#tab1" data-toggle="tab">Halaman Depan</a></li>
					<li role="presentation"><a href="#tab2" data-toggle="tab">Banner</a></li>
					<li role="presentation"><a href="#tab3" data-toggle="tab">Kontak</a></li>
				</ul>
				<div class="tab-content break-top-30">
					<div role="tabpanel" class="tab-pane active" id="tab1">
						<h4>Modal Pop-Up <small>({{ $setting->modal_active == 'Aktif' ? 'Aktif' : 'Tidak Aktif' }})</small></h4>
						<br>
						<div class="row">
							<div class="col-xs-12 col-md-4">
								<div class="form-group">
									<label for="">Gambar</label><br>
									<img src="{{ base_url('assets/images/modal/'.cek_file($setting->modal_image,'./assets/images/modal/','default.png')) }}" width="40%" alt="{{ $setting->modal_image }}">
								</div>
								<div class="form-group">
									<button class="btn btn-primary" data-form="{{ site_url('pengaturan/update_modal_image') }}"><i class="fa fa-refresh"></i> Ubah</button>
									<a href="{{ site_url('pengaturan/hapus_modal_image') }}" class="btn btn-danger" onclick="return confirm('Apakah anda yakin?');"><i class="fa fa-times"></i> Hapus</a>
									@if($setting->modal_active == 'Aktif')
									    <a href="{{ site_url('pengaturan/nonaktifkan_modal') }}" class="btn btn-warning"><i class="fa fa-power-off"></i> Nonaktifkan</a>
                                    @else
                                        <a href="{{ site_url('pengaturan/aktifkan_modal') }}" class="btn btn-success"><i class="fa fa-toggle-on"></i> Aktifkan</a>
                                    @endif
								</div>
							</div>
							<form action="{{ site_url('pengaturan/update_modal_info') }}" method="POST">
								{{ $csrf }}
								<div class="col-xs-12 col-md-4">
									<div class="form-group">
										<label for="">Header text modal</label>
										<input type="text" class="form-control" name="modal_header_text" placeholder="Header text modal" maxlength="50" value="{{ $setting->modal_header_text }}" required/>
									</div>
									<div class="form-group">
										<label for="">Sub-Header text modal</label>
										<input type="text" class="form-control" name="modal_sub_header_text" placeholder="Sub-header text modal" maxlength="50" value="{{ $setting->modal_sub_header_text }}" required/>
									</div>
								</div>
								<div class="col-xs-12 col-md-4">
									<div class="form-group">
										<label for="">Keterangan</label>
										<textarea class="form-control content" name="modal_additional_info" placeholder="Keterangan" style="height: 110px;">{{ $setting->modal_additional_info }}</textarea>
									</div>
								</div>
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-primary btn-block">Simpan</button>
							</div>
						</form>
						<h4>Slider</h4>
						<br>
						<div class="form-group">
							<button class="btn btn-default" data-form="{{ site_url('pengaturan/tambah_slider') }}"><i class="fa fa-plus"></i> Tambah slider</button>
						</div>
						<div class="row">
							<?php $i=0;?>
							@foreach($sliders as $slider)
							<div class="col-xs-12 col-md-3">
								<div class="form-group">
									<label for="">Gambar</label><br>
									<img src="{{ base_url('assets/images/sliders/'.cek_file($slider,'./assets/images/sliders/','default.png')) }}" width="100%" alt="{{ $slider }}">
								</div>
								<div class="form-group">
									<button class="btn btn-primary" data-form="{{ site_url('pengaturan/update_slider/'.++$i) }}"><i class="fa fa-refresh"></i> Ubah</button>
									<a href="{{ site_url('pengaturan/hapus_slider/'.$i) }}" class="btn btn-danger"><i class="fa fa-times" onclick="return confirm('Apakah anda yakin?');"></i> Hapus</a>
								</div>
							</div>
							@endforeach
						</div>
						<h4>Banner tengah</h4>
						<br>
						<div class="row">
							<div class="col-xs-12">
								<div class="form-group">
									<label for="">Gambar</label><br>
									<img src="{{ base_url('assets/images/banner/center/'.cek_file($setting->banner_center,'./assets/images/banner/center/','default.jpg')) }}" width="40%" alt="{{ $setting->banner_center }}">
								</div>
								<div class="form-group">
									<button class="btn btn-primary"  data-link="{{ $setting->banner_center_link }}" data-form="{{ site_url('pengaturan/update_banner_tengah') }}"><i class="fa fa-refresh"></i> Ubah</button>
									<a href="{{ site_url('pengaturan/hapus_banner_tengah') }}" class="btn btn-danger"><i class="fa fa-times" onclick="return confirm('Apakah anda yakin?');"></i> Hapus</a>
								</div>
							</div>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane" id="tab2">
						<div class="row">
							<div class="col-xs-12 col-md-3">
								<div class="form-group">
									<label for="">Banner Atas 1</label><br>
									<img src="{{ base_url('assets/images/banner/header/'.cek_file($setting->banner_header_1,'./assets/images/banner/header/','default.jpg')) }}" width="40%" alt="{{ $setting->banner_header_1 }}">
								</div>
								<div class="form-group">
									<button class="btn btn-primary"  data-link="{{ $setting->banner_header_1_link }}"data-form="{{ site_url('pengaturan/update_banner_atas/1') }}"><i class="fa fa-refresh"></i> Ubah</button>
									<a href="{{ site_url('pengaturan/hapus_banner_atas/1') }}" class="btn btn-danger" onclick="return confirm('Apakah anda yakin?');"><i class="fa fa-times"></i> Hapus</a>
								</div>
							</div>
							<div class="col-xs-12 col-md-3">
								<div class="form-group">
									<label for="">Banner Atas 2</label><br>
									<img src="{{ base_url('assets/images/banner/header/'.cek_file($setting->banner_header_2,'./assets/images/banner/header/','default.jpg')) }}" width="40%" alt="{{ $setting->banner_header_2 }}">
								</div>
								<div class="form-group">
									<button class="btn btn-primary"  data-link="{{ $setting->banner_header_2_link }}"data-form="{{ site_url('pengaturan/update_banner_atas/2') }}"><i class="fa fa-refresh"></i> Ubah</button>
									<a href="{{ site_url('pengaturan/hapus_banner_atas/2') }}" class="btn btn-danger" onclick="return confirm('Apakah anda yakin?');"><i class="fa fa-times"></i> Hapus</a>
								</div>
							</div>
							<div class="col-xs-12 col-md-3">
								<div class="form-group">
									<label for="">Banner Atas 3</label><br>
									<img src="{{ base_url('assets/images/banner/header/'.cek_file($setting->banner_header_3,'./assets/images/banner/header/','default.jpg')) }}" width="40%" alt="{{ $setting->banner_header_3 }}">
								</div>
								<div class="form-group">
									<button class="btn btn-primary"  data-link="{{ $setting->banner_header_3_link }}"data-form="{{ site_url('pengaturan/update_banner_atas/3') }}"><i class="fa fa-refresh"></i> Ubah</button>
									<a href="{{ site_url('pengaturan/hapus_banner_atas/3') }}" class="btn btn-danger" onclick="return confirm('Apakah anda yakin?');"><i class="fa fa-times"></i> Hapus</a>
								</div>
							</div>
							<div class="col-xs-12 col-md-3">
								<div class="form-group">
									<label for="">Banner Atas 4</label><br>
									<img src="{{ base_url('assets/images/banner/header/'.cek_file($setting->banner_header_4,'./assets/images/banner/header/','default.jpg')) }}" width="40%" alt="{{ $setting->banner_header_4 }}">
								</div>
								<div class="form-group">
									<button class="btn btn-primary" data-link="{{ $setting->banner_header_4_link }}" data-form="{{ site_url('pengaturan/update_banner_atas/4') }}"><i class="fa fa-refresh"></i> Ubah</button>
									<a href="{{ site_url('pengaturan/hapus_banner_atas/4') }}" class="btn btn-danger" onclick="return confirm('Apakah anda yakin?');"><i class="fa fa-times"></i> Hapus</a>
								</div>
							</div>
						</div>
						<br><br>
						<div class="row">
							<div class="col-xs-12 col-md-6">
								<div class="form-group">
									<label for="">Banner Samping</label><br>
									<img src="{{ base_url('assets/images/banner/side/'.cek_file($setting->banner_side,'./assets/images/banner/side/','default.png')) }}" width="40%" alt="{{ $setting->banner_side }}">
								</div>
								<div class="form-group">
									<button class="btn btn-primary" data-link="{{ $setting->banner_side_link }}" data-form="{{ site_url('pengaturan/update_banner_samping') }}"><i class="fa fa-refresh"></i> Ubah</button>
									<a href="{{ site_url('pengaturan/hapus_banner_samping') }}" class="btn btn-danger" onclick="return confirm('Apakah anda yakin?');"><i class="fa fa-times"></i> Hapus</a>
								</div>
							</div>
							<div class="col-xs-12 col-md-6">
								<div class="form-group">
									<label for="">Banner Bawah</label><br>
									<img src="{{ base_url('assets/images/banner/footer/'.cek_file($setting->banner_footer,'./assets/images/banner/footer/','default.png')) }}" width="40%" alt="{{ $setting->banner_footer }}">
								</div>
								<div class="form-group">
									<button class="btn btn-primary" data-link="{{ $setting->banner_footer_link }}" data-form="{{ site_url('pengaturan/update_banner_bawah') }}"><i class="fa fa-refresh"></i> Ubah</button>
									<a href="{{ site_url('pengaturan/hapus_banner_bawah') }}" class="btn btn-danger" onclick="return confirm('Apakah anda yakin?');"><i class="fa fa-times"></i> Hapus</a>
								</div>
							</div>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane" id="tab3">
						<form action="{{ site_url('pengaturan/update_kontak') }}" method="POST">
							{{$csrf}}
							<div class="row">
								<div class="col-xs-12 col-md-6">
									<div class="form-group">
										<label for="">Email</label>
										<input type="text" class="form-control" name="website_email" placeholder="Email" value="{{ $setting->website_email }}">
									</div>
								</div>
								<div class="col-xs-12 col-md-6">
									<div class="form-group">
										<label for="">Nomor Telepon</label>
										<input type="text" class="form-control" name="website_phone" placeholder="Nomor telepon" value="{{ $setting->website_phone }}">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="">Facebook</label>
								<div class="input-group">
									<span class="input-group-addon">https://facebook.com/</span>
									<input type="text" class="form-control" name="website_facebook" placeholder="facebook" value="{{ $setting->website_facebook }}">
								</div>
							</div>
							<div class="form-group">
								<label for="">Twitter</label>
								<div class="input-group">
									<span class="input-group-addon">https://twitter.com/</span>
									<input type="text" class="form-control" name="website_twitter" placeholder="twitter" value="{{ $setting->website_twitter }}">
								</div>
							</div>
							<div class="form-group">
								<label for="">Instagram</label>
								<div class="input-group">
									<span class="input-group-addon">https://instagram.com/</span>
									<input type="text" class="form-control" name="website_instagram" placeholder="instagram" value="{{ $setting->website_instagram}}">
								</div>
							</div>
							<div class="form-group">
								<button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Simpan</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('modal')
<div class="modal fade" tabindex="-1" role="dialog" id="modal-upload">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Update Gambar</h4>
			</div>
			<div class="modal-body">
				<form action="#" id="form-upload" enctype="multipart/form-data" method="POST">
					{{$csrf}}
					<h5>Pilih Salah satu antara menggunakan Link atau Upload Gambar</h5><br>
					<div class="form-group">
						<label for="">Pilih file</label>
						<input type="file" name="image">
						<p class="help-block">max ukuran 1MB</p>
					</div>
					<div class="form-group" id="link-group">
						<label for="">Link</label>
						<input type="text" id="banner_link" name="link" class="form-control">
					</div>
					<div class="form-group">
						<img src="{{base_url('assets/images/blank-avatar.png')}}" class="img-preview img img-responsive" id="img-thumbnail" height="200px" alt="">
					</div>
					<div class="form-group">
						<button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> simpan</button>
						<button class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> batal</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection

@section('javascript')
<script>
	$("[data-form]").click(function(){
		$("#form-upload").prop('action', $(this).data('form'));
		$("#banner_link").val($(this).data('link'));
		$('#img-thumbnail').attr('src', $(this).closest('div.col-xs-12').find('img').attr('src'));
		var attr = $(this).attr('data-link');
		if(typeof attr !== typeof undefined && attr !== false){
            console.log('show');
            $('#link-group').show();
        } else {
            console.log('hide');
            $('#link-group').hide();
        }
		$("#modal-upload").modal('show');
	});

	$("#form-upload input").change(function(){
		readURL(this);
	});
	
	function readURL(input) {

		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				$('.img-preview').attr('src', e.target.result);
			}

			reader.readAsDataURL(input.files[0]);
		}
	}
</script>
@endsection