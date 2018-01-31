@layout('_layout/dashboard/index')
@section('title')Tambah Kategori Produk@endsection

@section('content')
<div class="row">
	<div class="col-xs-12">
		<a href="{{ site_url('kategori') }}" class="btn btn-default break-bottom-10"><i class="fa fa-arrow-left"></i> Kembali</a>
		<div class="panel panel-theme">
			<div class="panel-heading">
				<h3 class="panel-title">Tambah Kategori Baru</h3>
			</div>
			<div class="panel-body">
				<form action="{{ site_url('kategori/simpan') }}" method="POST" enctype="multipart/form-data">
					{{ $csrf }}
					<div class="form-group">
						<label for="">Nama</label>
						{{ form_error('name') }}
						<input type="text" class="form-control" name="name" placeholder="nama kategori" maxlength="255" required/>
					</div>
					<div class="form-group">
						<label for="">Deskripsi</label>
						{{ form_error('description') }}
						<textarea class="form-control content" name="description" placeholder="deskripsi kategori"></textarea>
					</div>
					<div class="form-group">
						<label for="">Sub-Kategori dari (kosongi jika bukan sub kategori manapun)</label>
						<input name="parent_id" list="sub-kategori" class="form-control" placeholder="masukkan kode atau nama kategori" autocomplete="off">
						<datalist id="sub-kategori">
								@foreach($categories as $category)
									<option value="{{ $category->id. ' | '.$category->name }}">
								@endforeach
						</datalist>
					</div>
						<div class="form-group">
							<div class="row">
								<div class="col-xs-6 col-sm-3">
									<label for="">Banner Kategori</label>
									<input type="file" name="banner_image" />
									<p class="help-block">Ukuran maksimal file 1 mb</p>
									<img src="{{base_url('assets/images/blank-avatar.png')}}" class="preview" alt="preview" width="40%">
								</div>
							</div>
						</div>
						<div class="form-group">
							<button class="btn btn-primary"><i class="fa fa-send-o"></i> Simpan</button>
							<button class="btn btn-default" type="reset"><i class="fa fa-refresh"></i> bersihkan</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	@endsection

	@section('style')
	<style>
		.preview{
			width: 150px;
			height: 150px;
			object-fit: cover;
			object-position: center;
		}
	</style>
	@endsection

	@section('javascript')
	<script>
	// Initialize preview image
	$("[type='file']").change(function(){
		readURL(this);
	});

	// image preview function
	function readURL(input) {

		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				$('.preview').attr('src', e.target.result);
			}

			reader.readAsDataURL(input.files[0]);
		}
	}
</script>
@endsection