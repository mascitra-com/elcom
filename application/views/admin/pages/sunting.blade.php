@layout('_layout/dashboard/index')
@section('title')Sunting Halaman@endsection

@section('content')
<div class="row">
	<div class="col-xs-12">
		<a href="{{ site_url('halaman') }}" class="btn btn-default break-bottom-10"><i class="fa fa-arrow-left"></i> Kembali</a>
		<div class="panel panel-theme">
			<div class="panel-heading">
				<h3 class="panel-title">Sunting Halaman Baru</h3>
			</div>
			<div class="panel-body">
				<form action="{{ site_url('halaman/ubah/'.$page->id) }}" method="POST">
					{{$csrf}}
					<div class="row">
						<div class="col-xs-12 col-md-6">
							<div class="form-group">
								<label for="name">Nama Halaman</label>
								<input class="form-control" type="text" name="name" placeholder="Nama Halaman" required minlength="3" maxlength="100" value="{{ $page->name }}">
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="form-group">
								<label for="name">Section Halaman</label>
								<select class="form-control" name="section" required>
									<option value="0" {{ ($page->section === '0') ? 'selected' : '' }}>Senyum Media</option>
									<option value="1" {{ ($page->section === '1') ? 'selected' : '' }}>Layanan</option>
									<option value="2" {{ ($page->section === '2') ? 'selected' : '' }}>Lainnya</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-sm-12"> 
							<div class="form-group">
								<label for="content">Konten Halaman</label>
								<textarea class="form-control" name="content">{{ $page->content }}</textarea>
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

	// Initialize tinymce
	tinymce.init({selector:'textarea', menubar:false, height:300});
</script>
@endsection