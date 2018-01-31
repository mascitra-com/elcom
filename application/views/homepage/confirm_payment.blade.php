@layout('_layout/homepage/index')
@section('title')Konfirmasi Pembayaran @endsection

@section('content')
<div class="row">
	<div class="breadcrumbDiv col-lg-12">
		<ul class="breadcrumb">
			<li><a href="{{ site_url('/') }}">Beranda</a></li>
			<li><a href="{{ site_url('member/pesanan') }}">Pesanan</a></li>
			<li class="active">Konfirmasi Pembayaran</li>
		</ul>
	</div>
</div>
<!--/.row-->


<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-7">

		<h1 class="section-title-inner"><span><i class="fa fa-map-marker"></i> Konfirmasi Pembayaran Pesanan </span></h1>

		<div class="row userInfo">


			<div class="col-lg-12 col-xs-12">
				<h2 class="block-title-2"> Lorem Ipsum </h2>

				<p class="required"><sup>*</sup> Wajib diisi</p>
			</div>

			<form action="{{site_url('member/pesanan/konfirmasi_pembayaran')}}" method="post">
				{{$csrf}}
				<div class="col-xs-12 col-sm-6">
					<div class="form-group">
						<label for="address_name">ID Pesanan <sup>*</sup> </label>
						<input name="id" type="text" class="form-control"
						placeholder="Masukkan ID Pesanan">
					</div>
					<div class="form-group">
						<label for="transfer_person_fullname">Nama Pentransfer</label>
						<input name="transfer_person_fullname" type="text" class="form-control"
						id="transfer_person_fullname" placeholder="Nama Lengkap Pentransfer">
					</div>
					<div class="form-group required">
						<label for="transfer_amount">Nilai Transfer
							<sup>*</sup></label>
							<input required type="number" min="0" name="transfer_amount"
							class="form-control" id="transfer_amount" placeholder="Masukkan jumlah nilai pembayaran">
						</div>

					</div>
					<div class="col-xs-12 col-sm-6">
						<div class="form-group required">
							<label for="transfer_note">Catatan </label>
							<textarea name="transfer_note" rows="4" cols="26" type="text" class="form-control"
							id="transfer_note" placeholder="Catatan Transfer"></textarea>
						</div>
						<div class="form-group">
							<label>Tanggal Transfer</label>
						</div>
						<div class="form-group inline-select">
							<select name="transfer_day" class="form-control">
								@for($i=1; $i<=31; $i++)
								<option value="{{ $i }}" {{ ($i == date('d')) ? 'selected' : '' }}>{{ $i }}</option>
								@endfor
							</select>
						</div>
						<div class="form-group inline-select">
							<select name="transfer_month" class="form-control">
								@for($i=1; $i<=12; $i++)
								<option value="{{ $i }}" {{ ($i == date('m')) ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $i + 1, 0, 0)) }}</option>
								@endfor
							</select>
						</div>
						<div class="form-group inline-select">
							<select name="transfer_year" class="form-control">
								<option value="{{ date('Y') }}" selected>{{ date('Y') }}</option>
								<option value="{{ date('Y') - 1 }}">{{ date('Y') - 1 }}</option>
							</select>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12">
						<div class="form-group">
							<button class="btn btn-primary" type="submit"><i class="fa fa-send-o"></i> Simpan</button>
							<button class="btn btn-default" type="reset"><i class="fa fa-refresh"></i> bersihkan</button>
						</div>
					</div>
				</form>


				<div class="col-lg-12 col-xs-12  clearfix ">

					<ul class="pager">
						<li class="previous pull-right"><a href="{{ site_url('/') }}"> <i class="fa fa-home"></i> Ke Beranda </a>
						</li>
						<li class="next pull-left"><a href="{{ site_url('member/akun') }}">&larr; Kembali Ke Akun Saya</a></li>
					</ul>
				</div>


			</div>
			<!--/row end-->


		</div>
		<div class="col-lg-3 col-md-3 col-sm-5">
		</div>


	</div>
	<!--/row-->


	<div style="clear:both"></div>

	@endsection