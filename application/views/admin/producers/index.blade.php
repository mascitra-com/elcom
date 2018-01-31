@layout('_layout/dashboard/index')
@section('title')Daftar Brand@endsection

@section('content')
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-theme">
			<div class="panel-heading">
				<h3 class="panel-title pull-left">Daftar Brand</h3>
				<div class="btn-group pull-right">
					<a href="{{ site_url('produsen/tambah') }}" class="btn btn-default btn-sm" title="Tambah Brand"><i class="fa fa-plus"></i></a>
					<button class="btn btn-default btn-sm" title="Filter Data" data-toggle="modal" data-target="#modal-filter"><i class="fa fa-filter"></i> Filter Data</button> 
					<button class="btn btn-default btn-sm" title="Arsip berita"><i class="fa fa-archive"></i></button>
					<button class="btn btn-default btn-sm reload" title="segarkan"><i class="fa fa-refresh"></i></button>
				</div>
				<div class="clearfix"></div>
			</div>

			<div align="right"> 
				<div class="form-group col-sm-4" align="left"><br> 
					<select onChange="window.location.href=this.value" name="row" id="row">
						<option {{ ($row == 20) ? 'selected' : '' }} value="<?php echo site_url('Produsen/index/20'); ?>">20</option>
						<option {{ ($row == 50) ? 'selected' : '' }} value="<?php echo site_url('Produsen/index/50'); ?>">50</option>
						<option {{ ($row == 100) ? 'selected' : '' }} value="<?php echo site_url('Produsen/index/100'); ?>">100</option>
					</select>
					<label for="row"> Menampilkan <b><?php echo $row; ?></b> dari <b><?php echo $jumlah_data ?></b> data</label> 
				</div> 
				<div class="form-group col-sm-8" style="margin-bottom: -38px;top:43px;" align="right"> <br>
					<?php 
							echo $paginasi; 
					?>  
				</div>  
			</div>
			
			<div class="panel-body table-responsive table-full">
				<table class="table table-hover table-striped">
					<thead>
						<tr>
							<th class="text-center">NO</th>
							<th colspan="2">Nama</th> 
							<th class="text-center text-nowrap">AKSI</th>
						</tr>
					</thead>
					<tbody> 

					@if(is_null($producer) || empty($producer))
						<td colspan="6" class="text-center">Tidak ada data</td>
					@else

					<?php $i=$this->uri->segment('4') + 1; ?>
						@foreach($producer as $producers)
						<tr>
							<td class="text-center">{{$i++}}</td>
							<td>
								<img src="{{base_url('assets/images/producers/'.$producers->image)}}" alt="thumbnail">
							</td>
							<td>
								<h4>{{ $producers->name }}</h4>
								<p>{{ potong_teks(strip_tags($producers->description), 217) }}</p>
							</td> 
							<td class="text-center text-nowrap">
								<a href="{{ site_url('produsen/selengkapnya/'.$producers->id) }}" class="btn btn-default btn-xs" title="selengkapnya"><i class="fa fa-ellipsis-h"></i></a>
								<a href="{{ site_url('produsen/sunting/'.$producers->id) }}" class="btn btn-primary btn-xs" title="sunting"><i class="fa fa-pencil"></i></a>
								<a href="{{ site_url('produsen/hapus/'.$producers->id) }}" class="btn btn-danger btn-xs" title="hapus" onclick="return confirm('Produsen akan dihapus. Anda Yakin?')"><i class="fa fa-trash"></i></a>
							</td>
						</tr>
						@endforeach
						@endif
					</tbody>
				</table> 
			</div>

			<div class="panel-footer" style="padding: 10px 25px;"> 
				<div align="right"> 
					<div class="form-group" align="left">  <br><br>
						<select onChange="window.location.href=this.value" name="row" id="row">
							<option {{ ($row == 20) ? 'selected' : '' }} value="<?php echo site_url('produsen/index/20'); ?>">20</option>
							<option {{ ($row == 50) ? 'selected' : '' }} value="<?php echo site_url('produsen/index/50'); ?>">50</option>
							<option {{ ($row == 100) ? 'selected' : '' }} value="<?php echo site_url('produsen/index/100'); ?>">100</option>
						</select>   
						<label for="row"> Menampilkan <b><?php echo $row; ?></b> dari <b><?php echo $jumlah_data ?></b> data</label>
					</div>     
					<?php 
						echo $paginasi;
					 ?>  
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('modal')
<div class="modal fade" tabindex="-1" role="dialog" id="modal-filter">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Filter Produk</h4>
			</div>
			<div class="modal-body">
				<form action="{{ base_url('produsen/search') }}" method="post">
				{{ $csrf }}
					<div class="form-group">
						<label for="">Nama</label> 
						<input value="{{ (isset($filter['name'])) ? $filter['name'] : '' }}" type="text" class="form-control" name="name" placeholder="Nama Kategori" />
					</div>  
					<div class="form-group">
						<label for="">Urutkan berdasarkan</label>
						<div class="input-group">
							<select name="order_by" class="form-control"> 
								<option {{ ($order_by == "name") ? 'selected' : '' }} value="name">Nama</option> 
							</select>
							<span class="input-group-addon">secara</span>
							<select name="order_type" class="form-control">
								<option {{ ($order_type == "desc") ? 'selected' : '' }} value="desc" selected>Menaik</option>
								<option {{ ($order_type == "asc") ? 'selected' : '' }} value="asc">Menurun</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<button class="btn btn-primary" type="submit"><i class="fa fa-filter"></i> Filter</button>
						<button class="btn btn-warning" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection

@section('style')
<style>
	td, th{
		vertical-align: middle!important;
		padding-bottom: 10px!important;
	}

	td > img{
		width: 125px;
		height: 100px;
		object-fit: cover;
		object-position: center;
	}

	td > p{
		margin-bottom: 5px;
	}
</style>
@endsection

@section('javascript')
<script>
	$(".modal").on('hide.bs.modal', function(e){
		$(".modal form").trigger('reset');
	});
</script>
@endsection