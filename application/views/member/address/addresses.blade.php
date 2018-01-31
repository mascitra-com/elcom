@layout('_layout/homepage/index')
@section('title') Alamat Saya @endsection

@section('content')

<div class="row">
	<div class="breadcrumbDiv col-lg-12">
		<ul class="breadcrumb">
			<li><a href="{{ site_url('/') }}">Beranda</a></li>
			<li><a href="{{ site_url('member/profil') }}">Akun Saya</a></li>
			<li class="active"> Alamat</li>
		</ul>
	</div>
</div>
<!--/.row-->


<div class="row">

	<div class="col-lg-12 col-md-12 col-sm-7">
		<h1 class="section-title-inner"><span><i class="fa fa-map-marker"></i> Alamat Saya </span></h1>
			<div class="row userInfo">

				<div class="col-lg-12">
					<h2 class="block-title-2"> Daftar alamat saya</h2>

					<p> Lorem Ipsum</p>
				</div>

				<div class="w100 clearfix">
				@for($i=0; $i<5; $i++)
					<div class="col-xs-12 col-sm-6 col-md-4">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title"><strong>Alamatku {{ $i+1 }}</strong></h3>
							</div>
							<div class="panel-body">
								<ul>
									<li><span class="address-name"> <strong>John Doe</strong></span></li>
									<li><span class="address-line1"> Jalan Belimbing 52, Jember. </span></li>
									<li><span> <strong>Provinsi</strong> : Jawa Timur </span></li>
									<li><span> <strong>Kota</strong> : Jember </span></li>
									<li><span> <strong>Kecamatan</strong> : Patrang </span></li>
									<li><span> <strong>No. HP</strong> : +6285808596142 </span></li>
								</ul>
							</div>
							<div class="panel-footer panel-footer-address"><a href="{{ site_url('member/alamat/tambah') }}"
								class="btn btn-sm btn-success"> <i
								class="fa fa-edit"> </i> Sunting </a> <a class="btn btn-sm btn-danger"> <i
								class="fa fa-minus-circle"></i> Hapus </a></div>
							</div>
						</div>
						@endfor
					</div>
					<!--/.w100-->

					<div class="col-lg-12 clearfix">
						<a class="btn   btn-primary" href="{{ site_url('member/alamat/tambah') }}"><i class="fa fa-plus-circle"></i> Tambah Alamat Baru
						</a>
					</div>

					<div class="col-lg-12 clearfix">
						<ul class="pager">
							<li class="previous pull-right"><a href="{{ site_url('/') }}"> <i class="fa fa-home"></i> Ke Beranda </a>
							</li>
							<li class="next pull-left"><a href="{{ site_url('member/akun') }}">&larr; Kembali Ke Akun Saya</a></li>
						</ul>
					</div>

				</div>
				<!--/row end-->
			</div>
		</div>
		<!--/row-->

		<div style="clear:both"></div>
@endsection