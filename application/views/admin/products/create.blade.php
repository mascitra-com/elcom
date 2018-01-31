@layout('_layout/dashboard/index')
@section('title')Tambah Produk@endsection

@section('content')
<div class="row">
	<div class="col-xs-12">
		<a href="{{ site_url('produk') }}" class="btn btn-default break-bottom-10"><i class="fa fa-arrow-left"></i> Kembali</a>
		<div class="panel panel-theme">
			<div class="panel-heading">
				<h3 class="panel-title">Tambah Produk Baru</h3>
			</div>
			<div class="panel-body">
				<form action="{{ site_url('produk/simpan') }}" method="POST" enctype="multipart/form-data">
					{{$csrf}}
					<div class="form-group">
						<label for="name">Nama Produk</label>
						<input class="form-control" type="text" name="name" placeholder="Nama Produk" required minlength="3" maxlength="100">
					</div>
					<div class="row">
						<div class="col-xs-12 col-sm-6">
							<div class="form-group">
								<label for="producer_id">Brand Produk</label>
								<input name="producer_id" list="produsen" class="form-control" placeholder="masukkan kode atau nama brand" autocomplete="off" required>
								<datalist id="produsen">
									@foreach($producers as $producer)
									<option value="{{ $producer->id. ' | '.$producer->name }}">
										@endforeach
									</datalist>
								</div>
							</div>
							<div class="col-xs-12 col-sm-6">
								<div class="form-group">
									<label for="category_id">Kategori Produk (Biarkan kosong jika bukan kategori manapun)</label>
									<input name="category_id" list="kategori" class="form-control" placeholder="masukkan kode atau nama kategori" autocomplete="off">
									<datalist id="kategori">
										@foreach($categories as $category)
										<option value="{{ $category->id. ' | '.$category->name }}">
											@endforeach
										</datalist>
									</div>	
								</div>
							</div>
							<div class="form-group">
								<label for="description">Overview Produk</label>
								<textarea class="form-control content" name="overview"></textarea>
							</div>
							<div class="form-group">
								<label for="description">Spesifikasi Produk</label>
								<textarea class="form-control content" name="description"></textarea>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-xs-12 col-sm-3">
										<label for="length">Panjang Produk</label>
										<div class="input-group">
											<input class="form-control" type="number" name="length" placeholder="Panjang Produk">
											<span class="input-group-addon">cm</span>
										</div>
									</div>
									<div class="col-xs-12 col-sm-3">
										<label for="width">Lebar Produk</label>
										<div class="input-group">
											<input class="form-control" type="number" name="width" placeholder="Lebar Produk">
											<span class="input-group-addon">cm</span>
										</div>
									</div>
									<div class="col-xs-12 col-sm-3">
										<label for="height">Tinggi Produk</label>
										<div class="input-group">
											<input class="form-control" type="number" name="height" placeholder="Tinggi Produk">
											<span class="input-group-addon">cm</span>
										</div>
									</div>
									<div class="col-xs-12 col-sm-3">
										<label for="weight">Berat Produk</label>
										<div class="input-group">
											<input class="form-control" type="number" name="weight" placeholder="Berat Produk">
											<span class="input-group-addon">kg</span>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-xs-12 col-sm-6">
										<label for="price">Ukuran Produk (Isi jika ada)</label>
										<div class="checkbox">
											<label class="checkbox-inline">
												<input type="checkbox" name="size[]" value="XS"> XS
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="size[]" value="S"> S
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="size[]" value="M"> M
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="size[]" value="L"> L
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="size[]" value="XL"> XL
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="size[]" value="XXL"> XXL
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" name="size[]" value="XXXL"> XXXL
											</label>
										</div>
									</div>
									<div class="col-xs-12 col-sm-6">
										<label for="stock">Stok Produk</label>
										<input class="form-control" type="number" name="stock" min="1" required placeholder="Stok Produk">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-xs-12 col-sm-4">
										<label for="price">Harga Produk</label>
										<input class="form-control" type="number" name="price" min="0" required placeholder="Harga Produk">
										{{--<div class="checkbox">--}}
											{{--<label>--}}
												{{--<input type="checkbox" name="tax" value="1"> Sudah Termasuk Pajak PPN 10%--}}
											{{--</label>--}}
										{{--</div>--}}
									</div>
									<div class="col-xs-12 col-sm-4">
										<label for="price">Diskon Produk (isi jika ada)</label>
										<div class="input-group">
											<input class="form-control" type="number" name="discount" min="0" placeholder="Harga Produk">
											<span class="input-group-addon">%</span>
										</div>
									</div>
									<div class="col-xs-12 col-sm-4">
										<label for="stock">Jumlah Minimal Pembelian</label>
										<input class="form-control" type="number" name="min_stock" min="1" required placeholder="Minimal Stok Produk">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-xs-6 col-sm-3">
										<label for="">Gambar 1</label>
										<input type="file" name="image_1" />
										<p class="help-block">Ukuran maksimal file 1 mb</p>
										<img src="{{base_url('assets/images/blank-avatar.png')}}" class="preview" id="preview_1" alt="preview">
									</div>
									<div class="col-xs-6 col-sm-3">
										<label for="">Gambar 2</label>
										<input type="file" name="image_2" />
										<p class="help-block">Ukuran maksimal file 1 mb</p>
										<img src="{{base_url('assets/images/blank-avatar.png')}}" class="preview" id="preview_2" alt="preview">
									</div>
									<div class="col-xs-6 col-sm-3">
										<label for="">Gambar 3</label>
										<input type="file" name="image_3" />
										<p class="help-block">Ukuran maksimal file 1 mb</p>
										<img src="{{base_url('assets/images/blank-avatar.png')}}" class="preview" id="preview_3" alt="preview">
									</div>
									<div class="col-xs-6 col-sm-3">
										<label for="">Gambar 4</label>
										<input type="file" name="image_4" />
										<p class="help-block">Ukuran maksimal file 1 mb</p>
										<img src="{{base_url('assets/images/blank-avatar.png')}}" class="preview" id="preview_4" alt="preview">
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
		<script src="{{base_url('assets/plugins/tinymce/tinymce.min.js')}}"></script>
		<script>
	// Initialize tinymce
	tinymce.init({selector:'textarea', menubar:false, height:300});
	
	// Initialize preview image
	$("[name='image_1']").change(function(){
		readURL(this, 'preview_1');
	});
	$("[name='image_2']").change(function(){
		readURL(this, 'preview_2');
	});
	$("[name='image_3']").change(function(){
		readURL(this, 'preview_3');
	});
	$("[name='image_4']").change(function(){
		readURL(this, 'preview_4');
	});

	// image preview function
	function readURL(input, preview_id_name) {

		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				$('#'+preview_id_name).attr('src', e.target.result);
			}

			reader.readAsDataURL(input.files[0]);
		}
	}
</script>
@endsection