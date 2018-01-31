@layout('_layout/dashboard/index')
@section('title')Tambah Membership@endsection

@section('content')
<div class="row">
	<div class="col-xs-12">
		<a href="{{ site_url('membership') }}" class="btn btn-default break-bottom-10"><i class="fa fa-arrow-left"></i> Kembali</a>
		<div class="panel panel-theme">
			<div class="panel-heading">
				<h3 class="panel-title">Tambah Membership Baru</h3>
			</div>
			<div class="panel-body">
				<form action="{{ site_url('membership/simpan') }}" method="POST">
					{{ $csrf }}
					<div class="form-group">
						<div class="row">
							<div class="col-xs-12 col-sm-6">
								<label for="">Nama</label>
								{{ form_error('name') }}
								<input type="text" class="form-control" name="name" placeholder="Nama Membership" maxlength="255" required/>
							</div>
							<div class="col-xs-12 col-sm-6">
								<label for="price">Diskon Produk</label>
								<div class="input-group">
									<input class="form-control" type="number" name="discount" min="0" required placeholder="Diskon Produk">
									<span class="input-group-addon">%</span>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="">Deskripsi</label>
						{{ form_error('description') }}
						<textarea class="form-control content" name="description" placeholder="Deskripsi Membership"></textarea>
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