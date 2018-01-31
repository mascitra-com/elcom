@layout('_layout/homepage/index')
@section('title')Daftar@endsection

@section('content')
<div class="row">

	<div class="col-lg-9 col-md-9 col-sm-7">
		<h1 class="section-title-inner"><span><i class="fa fa-lock"></i> Daftar Menjadi Reseller</span></h1>

		<div class="row userInfo">

			<div class="col-xs-12">
				<h2 class="block-title-2"> Daftar </h2>
				<p><b>Fitur ini masih belum berfungsi. Mohon tidak melakukan transaksi apapun terlebih dahulu </b></p>
				<p>Untuk menjadi Reseller silahkan melakukan deposit dengan cara transfer melalui rekening bank berikut :</p>
                <div class="row">
                    <div class="col-sm-2">
                        <img src="{{ base_url('assets/images/bank/bca.png') }}" alt="Bank BCA" class="img img-responsive">
                    </div>
                    <div class="col-sm-4">
                        No. Rek: 2000.46.4000<br/>
                        a/n : KHOLID ASHARI
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <img src="{{ base_url('assets/images/bank/bni.png') }}" alt="Bank BNI" class="img img-responsive">
                    </div>
                    <div class="col-sm-4">
                        No. Rek: 2000.46.4004<br/>
                        a/n : KHOLID ASHARI
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <img src="{{ base_url('assets/images/bank/mandiri.png') }}" alt="Bank Mandiri" class="img img-responsive">
                    </div>
                    <div class="col-sm-4">
                        No. Rek: 143.000.900.0009<br/>
                        a/n : KHOLID ASHARI
                    </div>
                </div>
                <br>
				<form role="form" class="regForm" action="{{ site_url('/') }}" method="POST">
				{{ $csrf }}
					<div class="row">
						<div class="col-xs-12 col-sm-6">
							<div class="form-group">
								<label>Atas Nama Rekening</label>
								<input title="Masukkan Atas Nama Rekening" type="text" value="{{ $user->first_name .' '. $user->last_name}}"
								class="form-control" placeholder="Masukkan Atas Nama Rekening" name="account_name" required minlength="3" maxlength="50">
							</div>	
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-sm-6">
							<div class="form-group">
								<label>Nomor Rekening</label>
								<input title="Masukkan Nomor Rekening" type="text" list="bank_accounts"
								class="form-control" placeholder="Masukkan Nomor Rekening" name="account_number" required minlength="3" maxlength="50">
                                <datalist id="bank_accounts">
                                    @foreach($banks as $bank)
                                        <option value="{{ $bank->account_number }}">
                                    @endforeach
                                </datalist>
							</div>
						</div>
						<div class="col-xs-12 col-sm-6">
							<div class="form-group" id="depositInput">
								<label>Bank Pengirim</label>
								<input title="Masukkan Nama Bank Pengirim" type="text"
								class="form-control" placeholder="Masukkan Nama Bank Pengirim" name="bank_name" required minlength="3" maxlength="50">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-sm-6">
							<div class="form-group" id="depositInput">
								<label>Jumlah Deposit</label>
								<input title="Masukkan Jumlah Deposit" type="number"
								class="form-control" placeholder="Masukkan Jumlah Deposit" name="nominal" required minlength="3" maxlength="50">
							</div>
						</div>
					</div>
					<button type="submit" class="btn btn-primary"><i class="fa fa-user"></i> Deposit
					</button>
				</form>
				<br>
			</div>
		</div>
		<!--/row end-->
	</div>
</div>
<!--/row-->
<script>
    $(function() {
        $('#depositInput').on('keydown', '#child', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
    })
</script>
<div style="clear:both"></div>
@endsection