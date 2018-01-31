@layout('_layout/dashboard/index')
@section('title')Pengaturan@endsection

@section('content')
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-theme">
			<div class="panel-heading">
				<h3 class="panel-title pull-left">Pengaturan Website</h3>
				<div class="btn-group pull-right">
					<a href="{{ site_url('halaman/tambah') }}" class="btn btn-default btn-sm" title="Tambah halaman"><i class="fa fa-plus"></i> tambah halaman</a>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs">
					<li role="presentation" class="active"><a href="#tab1" data-toggle="tab">Senyum Media</a></li>
					<li role="presentation"><a href="#tab2" data-toggle="tab">Layanan</a></li>
					<li role="presentation"><a href="#tab3" data-toggle="tab">Lainnya</a></li>
				</ul>
				<div class="tab-content break-top-30">
					<div role="tabpanel" class="tab-pane active" id="tab1">
						<h4>Daftar Halaman</h4>
						<br>
						<div class="row">
							<div class="col-xs-12">
								<table class="table table-hover table-striped table-bordered">
									<thead>
										<tr>
											<th class="text-center">No</th>
											<th>Nama Halaman</th>
											<th class="text-center" width="20%">Aksi</th>
										</tr>
									</thead>
									<tbody>						

										@if(is_null($pages_0) || empty($pages_0))
										<td colspan="5" class="text-center">Belum ada data halaman</td>
										@else
										<?php $i=0 ?>
										@foreach($pages_0 as $page)
										<tr>
											<td class="text-center">{{++$i}}</td>
											<td>{{ $page->name }}</td>
											<td class="text-center">
												<a href="{{ site_url('halaman/detail/'. $page->slug) }}" class="btn btn-xs btn-default" title="detail"><i class="fa fa-info"></i></a>
												<a href="{{ site_url('halaman/sunting/'. $page->id) }}" class="btn btn-xs btn-default" title="sunting"><i class="fa fa-pencil"></i></a>
												<a href="{{ site_url('halaman/hapus/'.$page->id) }}" class="btn btn-xs btn-default" title="hapus" onclick="return confirm('Apakah Anda yakin?')"><i class="fa fa-trash"></i></a>
											</td>
										</tr>
										@endforeach
										@endif
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane" id="tab2">
						<h4>Daftar Halaman</h4>
						<br>
						<div class="row">
							<div class="col-xs-12">
								<table class="table table-hover table-striped table-bordered">
									<thead>
										<tr>
											<th class="text-center">No</th>
											<th>Nama Halaman</th>
											<th class="text-center" width="20%">Aksi</th>
										</tr>
									</thead>
									<tbody>						

										@if(is_null($pages_1) || empty($pages_1))
										<td colspan="5" class="text-center">Belum ada data halaman</td>
										@else
										<?php $i=0 ?>
										@foreach($pages_1 as $page)
										<tr>
											<td class="text-center">{{++$i}}</td>
											<td>{{ $page->name }}</td>
											<td class="text-center">
												<a href="{{ site_url('halaman/detail/'. $page->slug) }}" class="btn btn-xs btn-default" title="detail"><i class="fa fa-info"></i></a>
												<a href="{{ site_url('halaman/sunting/'. $page->id) }}" class="btn btn-xs btn-default" title="sunting"><i class="fa fa-pencil"></i></a>
												<a href="{{ site_url('halaman/hapus/'.$page->id) }}" class="btn btn-xs btn-default" title="hapus" onclick="return confirm('Apakah Anda yakin?')"><i class="fa fa-trash"></i></a>
											</td>
										</tr>
										@endforeach
										@endif
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane" id="tab3">
						<h4>Daftar Halaman</h4>
						<br>
						<div class="row">
							<div class="col-xs-12">
								<table class="table table-hover table-striped table-bordered">
									<thead>
										<tr>
											<th class="text-center">No</th>
											<th>Nama Halaman</th>
											<th class="text-center" width="20%">Aksi</th>
										</tr>
									</thead>
									<tbody>						

										@if(is_null($pages_2) || empty($pages_2))
										<td colspan="5" class="text-center">Belum ada data halaman</td>
										@else
										<?php $i=0 ?>
										@foreach($pages_2 as $page)
										<tr>
											<td class="text-center">{{++$i}}</td>
											<td>{{ $page->name }}</td>
											<td class="text-center">
												<a href="{{ site_url('halaman/detail/'. $page->slug) }}" class="btn btn-xs btn-default" title="detail"><i class="fa fa-info"></i></a>
												<a href="{{ site_url('halaman/sunting/'. $page->id) }}" class="btn btn-xs btn-default" title="sunting"><i class="fa fa-pencil"></i></a>
												<a href="{{ site_url('halaman/hapus/'.$page->id) }}" class="btn btn-xs btn-default" title="hapus" onclick="return confirm('Apakah Anda yakin?')"><i class="fa fa-trash"></i></a>
											</td>
										</tr>
										@endforeach
										@endif
									</tbody>
								</table>
							</div>
						</div>
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
				<h4 class="modal-title">Unggah Gambar</h4>
			</div>
			<div class="modal-body">
				<form action="#" id="form-upload" enctype="multipart/form-data" method="POST">
					{{$csrf}}
					<div class="form-group">
						<label for="">Pilih file</label>
						<input type="file"/ name="image" required>
						<p class="help-block">max ukuran 1MB</p>
					</div>
					<div class="form-group">
						<img src="{{base_url('assets/images/blank-avatar.png')}}" class="img-preview" height="200px" alt="">
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