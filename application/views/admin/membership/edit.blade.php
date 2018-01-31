@layout('_layout/dashboard/index')
@section('title')Sunting Membership@endsection

@section('content')
<div class="row">
	<div class="col-xs-12">
		<a href="{{ site_url('membership') }}" class="btn btn-default break-bottom-10"><i class="fa fa-arrow-left"></i> Kembali</a>
		<div class="panel panel-theme">
			<div class="panel-heading">
				<h3 class="panel-title">Sunting Membership</h3>
			</div>
			<div class="panel-body">
				<form action="{{ site_url('membership/ubah/'.$membership->id) }}" method="POST">
					{{ $csrf }}
					<div class="form-group">
						<div class="row">
							<div class="col-xs-12 col-sm-6">
								<label for="">Nama</label>
								{{ form_error('name') }}
								<input type="text" class="form-control" name="name" placeholder="nama membership" maxlength="255" value="{{ $membership->name }}" required/>
							</div>
							<div class="col-xs-12 col-sm-6">
								<label for="price">Diskon Produk</label>
								<div class="input-group">
									<input class="form-control" type="number" step="0.01" name="discount" min="0" required placeholder="Diskon Produk" value="{{ $membership->discount * 100 }}">
									<span class="input-group-addon">%</span>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="">Deskripsi</label>
						{{ form_error('description') }}
						<textarea class="form-control content" name="description" placeholder="deskripsi membership">{{ $membership->description }}</textarea>
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