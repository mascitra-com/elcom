@layout('_layout/homepage/index')
@section('title')Edit Alamat @endsection

@section('content')


<div class="row">
	<div class="breadcrumbDiv col-lg-12">
		<ul class="breadcrumb">
			<li><a href="{{ site_url('/') }}">Beranda</a></li>
			<li><a href="{{ site_url('member/akun') }}">Akun Saya</a></li>
			<li><a href="{{ site_url('member/alamat') }}">Alamat Saya</a></li>
			<li class="active">Edit Alamat</li>
		</ul>
	</div>
</div>
<!--/.row-->


<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-7">

		<h1 class="section-title-inner"><span><i class="fa fa-map-marker"></i> Edit Alamat </span></h1>

		<div class="row userInfo">


			<div class="col-lg-12 col-xs-12">
				<h2 class="block-title-2"> Lorem Ipsum </h2>

				<p class="required"><sup>*</sup> Wajib diisi</p>
			</div>

			<form action="{{site_url('member/alamat/update')}}" method="post">
			{{$csrf}}
			@foreach ($data as $data) 
			{{form_hidden('id', $data->id);}}

				<div class="col-xs-12 col-sm-6">
					<div class="form-group">
						<label for="address_name">Nama Alamat <sup>*</sup> </label>
						<input value="{{$data->address_name}}" name="address_name" type="text" class="form-control" id="address_name"
						placeholder="Nama Alamat (Contoh: Alamat Utama, Alamat Cadangan, dll)">
					</div>
					<div class="form-group required">
						<label for="owner_first_name">Nama Awal <sup>*</sup> </label>
						<input value="{{$data->owner_first_name}}" name="owner_first_name" required type="text" class="form-control"
						id="owner_first_name" placeholder="Nama Awal">
					</div>
					<div class="form-group required">
						<label for="owner_last_name">Nama Terakhir <sup>*</sup>
						</label>
						<input value="{{$data->owner_last_name}}" name="owner_last_name" required type="text" class="form-control"
						id="owner_last_name" placeholder="Nama Terakhir">
					</div>
					<div class="form-group required">
						<label for="full_address">Alamat Lengkap<sup>*</sup> </label>
						<textarea name="full_address" rows="4" cols="26" required type="text" class="form-control"
						id="full_address" placeholder="Alamat">{{$data->full_address}}</textarea>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6">
					<div class="form-group required">
						<label for="provinces">Provinsi <sup>*</sup> </label>

						<select name="province_id" class="form-control" required
						aria-required="true" id="provinces"
						name="InputProvinsi">
							<option value="">Pilih Provinsi</option>
							@foreach($provinces as $val)
								<option {{ ($data->province_id == $val['province_id']) ? 'selected' : '' }} value="{{$val['province_id']}}">{{$val['province']}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group required">
						<label for="regencies">Kota / Kabupaten <sup>*</sup></label>

						<select name="regency_id" class="form-control" required id="regencies"> 
							@foreach($regencies as $val)
								<option {{ ($data->regency_id == $val['city_id']) ? 'selected' : '' }} value="{{$val['city_id']}}">{{$val['city_name']}}</option>
							@endforeach 
						</select>
					</div>
					<div class="form-group required">
						<label for="districts">Kecamatan <sup>*</sup> </label>
						<input name="district" required type="text" class="form-control"
							   id="district" placeholder="Kecamatan" value="{{ $data->district }}">
					</div>
					<div class="form-group required">
						<label for="villages">Desa <sup>*</sup></label>
						<input name="village" required type="text" class="form-control"
							   id="village" placeholder="Desa / Kelurahan" value="{{ $data->village }}">
					</div>
					<div class="form-group required">
						<label for="postal_code">Kode Pos
							<sup>*</sup></label>
							<input value="{{$data->postal_code}}" required type="text" name="postal_code"
							class="form-control" id="postal_code">
					</div>
					<div class="form-group required">
						<label for="phone">Nomor Telepon
							<sup>*</sup></label>
							<input value="{{$data->phone}}" required type="tel" name="phone"
							class="form-control" id="phone">
					</div> 
				</div>
				<div class="col-xs-12 col-sm-12">
					<div class="form-group">
						<button class="btn btn-primary" type="submit"><i class="fa fa-send-o"></i> Simpan</button>
						<button class="btn btn-default" type="reset"><i class="fa fa-refresh"></i> bersihkan</button>
					</div>
				</div>  
			@endforeach 
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

@section('scripts')
<script>
	$(document).ready(function(){
		function disableAllOption($a){ 
	    	$("#provinces").attr("disabled", "disabled");
	    	$("#regencies").attr("disabled", "disabled");
	    	$("#districts").attr("disabled", "disabled");
	    	$("#villages").attr("disabled", "disabled");
		} 
		function showAllOption($a){  
			$('#provinces').removeAttr("disabled");
			$('#regencies').removeAttr("disabled");
			$('#districts').removeAttr("disabled");
			$('#villages').removeAttr("disabled");
		}  

	    $("#provinces").change(function (){ 
 			disableAllOption();

	        var url = "<?php echo site_url('member/alamat/add_regencies');?>/"+$(this).val();
	        $('#regencies').load(url); 

	        showAllOption();
 
	    	$("#districts").attr("disabled", "disabled");
	    	$("#villages").attr("disabled", "disabled");
	        return false;
	    })

		$("#regencies").change(function (){
 			disableAllOption();

	    	$("#districts").attr("disabled", "disabled");
	    	$("#villages").attr("disabled", "disabled");
	    	$("#regencies").attr("disabled", "disabled");
	        var url = "<?php echo site_url('member/alamat/add_districts');?>/"+$(this).val();
	        $('#districts').load(url);

	        showAllOption();   ;
	    	$("#villages").attr("disabled", "disabled");
	        return false;
		})

		$("#districts").change(function (){
 			disableAllOption();

	    	$("#districts").attr("disabled", "disabled");
	        var url = "<?php echo site_url('member/alamat/add_villagess');?>/"+$(this).val();
	        $('#villages').load(url);
            $('#villages').removeAttr("disabled");  

	        showAllOption();   
	        return false;
		}) 
	});
</script>
@endsection