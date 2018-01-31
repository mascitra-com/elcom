@layout('_layout/dashboard/index')
@section('title')Sunting Brand@endsection

@section('content')
<div class="row">
	<div class="col-xs-12">
	<a href="{{ site_url('Produsen') }}" class="btn btn-default break-bottom-10"><i class="fa fa-arrow-left"></i> Kembali</a>
		<div class="panel panel-theme">
			<div class="panel-heading">
				<h3 class="panel-title">Sunting Brand Baru</h3>
			</div>
			<div class="panel-body">
				<form action="{{ site_url('produsen/ubah') }}" method="POST" enctype="multipart/form-data">
				{{$csrf}}
				<?php echo form_hidden('id', $producer->id); ?>

					<div class="form-group">
						<label for="name">Nama Brand</label>
						<input class="form-control" type="text" name="name" placeholder="Nama Brand" required minlength="3" maxlength="100" value="{{ $producer->name }}">
					</div>
					<div class="row">
						<div class="col-xs-12 col-sm-12"> 
							<div class="form-group">
								<label for="description">Deskripsi Brand</label>
								<textarea class="form-control" name="description">{{ $producer->description }}</textarea>
							</div>
							  
							<div class="form-group">
								<label for="">Gambar Thumbnail (Gambar Brand yang dimunculkan pertama kali)</label>
								<input type="file" name="foto" />
								<p class="help-block">Ukuran maksimal file 1 mb</p>
								<img  src="{{ base_url('assets/images/producers/'.$producer->image )}}" class="preview" alt="preview gambar">
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
	
	// Initialize preview image
	$("[type='file']").change(function(){
		readURL(this);
	});

	// image preview function
	function readURL(input) {

		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				$('.preview').attr('src', e.target.result);
			}

			reader.readAsDataURL(input.files[0]);
		}
	}
</script>
@endsection