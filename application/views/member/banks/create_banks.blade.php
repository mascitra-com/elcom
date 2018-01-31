@layout('_layout/homepage/index')
@section('title')Tambah Rekening @endsection

@section('content')


<div class="row">
	<div class="breadcrumbDiv col-lg-12">
		<ul class="breadcrumb">
			<li><a href="{{ site_url('/') }}">Beranda</a></li>
			<li><a href="{{ site_url('member/profil') }}">Akun Saya</a></li>
			<li class="active">Tambah Rekening</li>
		</ul>
	</div>
</div>
<!--/.row-->


<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-7">

		<h1 class="section-title-inner"><span><i class="fa fa-map-marker"></i> Tambah Rekening Baru </span></h1>

		<div class="row userInfo">


			<div class="col-lg-12 col-xs-12">
				<h2 class="block-title-2"> Lorem Ipsum </h2>

				<p class="required"><sup>*</sup> Wajib diisi</p>
			</div>

			<form action="{{ site_url('member/rekening/save') }}" method="post">
			{{ $csrf }}
			{{ form_hidden('user_id', $user->id); }}
				<div class="col-xs-12 col-sm-6">
					<div class="form-group">
						<label for="bank_id">Nama Bank <sup>*</sup> </label>

						<select class="form-control" required
						aria-required="true" id="bank_id"
						name="bank_id">
							<option value="">Pilih Bank</option>
							@foreach($banks as $data)
								<option value="{{ $data->id }}">{{ $data->name }}</option> 
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label for="account_name">Nama Rekening <sup>*</sup> </label>
						<input name="account_name" type="text" class="form-control" id="account_name"
						placeholder="Nama Rekening" required="">
					</div>
					<div class="form-group">
						<label for="account_behalf">Atas Nama <sup>*</sup> </label>
						<input name="account_behalf" type="text" class="form-control" id="account_behalf"
						placeholder="Nama Rekening" required="">
					</div>
					<div class="form-group required">
						<label for="account_number">Nomor Rekening <sup>*</sup> </label>
						<input name="account_number" required type="text" class="form-control"
						id="account_number" placeholder="Nama Awal">
					</div> 
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
					<li class="next pull-left"><a href="{{ site_url('member/profil') }}">&larr; Kembali Ke Akun Saya</a></li>
				</ul>
			</div>
 
		</div>
		<!--/row end-->  
	</div> 
</div>
<!--/row-->


<div style="clear:both"></div>
@endsection