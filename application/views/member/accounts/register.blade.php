@layout('_layout/homepage/index')
@section('title')Daftar@endsection

@section('content')
<div class="row">

	<div class="col-lg-9 col-md-9 col-sm-7">
		<h1 class="section-title-inner"><span><i class="fa fa-lock"></i> Masuk / Daftar</span></h1>

		<div class="row userInfo">

			<div class="col-xs-12">
				<h2 class="block-title-2"> Daftar </h2>

				<form role="form" class="regForm" action="{{ site_url('member/daftar/simpan') }}" method="POST">
				{{ $csrf }}
					<div class="row">
						<div class="col-xs-12 col-sm-6">
							<div class="form-group">
								<label>Nama Pertama</label>
								<input title="Masukkan Nama Pertama" type="text"
								class="form-control" placeholder="Masukkan nama pertama" name="first_name" required minlength="3" maxlength="50">
							</div>	
						</div>
						<div class="col-xs-12 col-sm-6">
							<div class="form-group">
								<label>Nama Terakhir</label>
								<input title="Masukkan Nama Terakhir" type="text"
								class="form-control" placeholder="Masukkan nama terakhir" name="last_name" required minlength="3" maxlength="50">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-sm-6">
							<div class="form-group">
								<label>Email</label>
								<input title="Masukkan email" type="email" class="form-control"
								placeholder="Masukkan email" name="email" required>
							</div>	
						</div>
						<div class="col-xs-12 col-sm-6">
							<div class="form-group">
								<label for="width">Nomor HP</label>
								<div class="input-group">
									<span class="input-group-addon">+62</span>
									<input title="Masukkan nomor handphone" class="form-control" type="tel" name="phone" placeholder="Masukkan nomor handphone">
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-sm-6">
							<div class="form-group">
								<label>Password</label>
								<input required minlength="5"
								title="Masukkan password" type="password"
								class="form-control" name="password" placeholder="Password">
							</div>	
						</div>
						<div class="col-xs-12 col-sm-6">
							<div class="form-group">
								<label>Konfirmasi Password</label>
								<input required minlength="5"
								title="Masukkan password" type="password"
								class="form-control" name="confirm_password" placeholder="Password">
							</div>
						</div>
					</div>
					<button type="submit" class="btn btn-primary"><i class="fa fa-user"></i> Daftar
					</button>
				</form>
				<br>
			</div>
		</div>
		<!--/row end-->
	</div>
</div>
<!--/row-->

<div style="clear:both"></div>
@endsection