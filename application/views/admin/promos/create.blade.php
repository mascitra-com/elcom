@layout('_layout/dashboard/index')
@section('title')Tambah Kategori Produk@endsection

@section('content')
<div class="row">
	<div class="col-xs-12">
		<a href="{{ site_url('promo') }}" class="btn btn-default break-bottom-10"><i class="fa fa-arrow-left"></i> Kembali</a>
		<div class="panel panel-theme">
			<div class="panel-heading">
				<h3 class="panel-title">Tambah Promo Baru</h3>
			</div>
			<div class="panel-body">
				<form action="{{ site_url('promo/simpan') }}" method="POST">
					{{ $csrf }}
					<div class="form-group">
						<div class="row">
							<div class="col-xs-12 col-sm-6">
								<label for="">Nama</label>
								{{ form_error('name') }}
								<input type="text" class="form-control" name="name" placeholder="nama promo" maxlength="255" required/>
							</div>
							<div class="col-xs-12 col-sm-6">
								<label for="">Kode (Panjang kode maks. 8)</label>
								<div class="input-group">
									<input type="text" class="form-control" name="code" maxlength="8" placeholder="Kode Promo">
									<span class="input-group-btn">
										<button class="btn btn-default" type="button" onclick="generateCode()">Generate</button>
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="">Deskripsi</label>
						{{ form_error('description') }}
						<textarea class="form-control content" name="description" placeholder="deskripsi promo"></textarea>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-xs-12 col-sm-4">
								<label for="price">Diskon Produk</label>
								<div class="input-group">
									<input class="form-control" type="number" name="discount" min="0" required placeholder="Diskon Produk">
									<span class="input-group-addon">%</span>
								</div>
							</div>
							<div class="col-xs-12 col-sm-4">
								<label for="stock">Maksimal Penggunaan</label>
								<input class="form-control" type="number" name="max_use" placeholder="Maksimal penggunaan promo/voucher per user">
								<span class="text-warning">* kosongi jika tidak terbatas</span>
							</div>
							<div class="col-xs-12 col-sm-4">
								<label for="stock">Tanggal Berakhir</label>
								<input class="form-control" type="date" name="end_date" placeholder="Tanggal berakhirnya promo">
								<span class="text-warning">* kosongi jika tidak terbatas</span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<button class="btn btn-primary" type="submit"><i class="fa fa-send-o"></i> Simpan</button>
						<button class="btn btn-default" type="reset"><i class="fa fa-refresh"></i> bersihkan</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection

@section('javascript')
<script type="text/javascript">
	function generateCode() {
		var input_code =  $("input[name='code']");
		//update quantity produk yg bersangkutan sesuai yang diinputkan di cart_details
		$.get("{{ site_url('promo/generateCode') }}", function(data, status) {
			if (status) {
				input_code.empty();
				input_code.val(data);
			}else{
				alert("Terjadi kesalahan sistem saat generate kode promo/voucher! Coba lagi nanti.");
			}
        }, "json");
	}
</script>
@endsection