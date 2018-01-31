@layout('_layout/dashboard/index')
@section('title')Promo/Voucher@endsection

@section('content')
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-theme">
			<div class="panel-heading">
				<h3 class="panel-title pull-left">Daftar Promo</h3>
				<div class="btn-group pull-right">
					<a href="{{ site_url('promo/tambah') }}" class="btn btn-xs btn-default"><i class="fa fa-plus"></i></a>
					<a class="btn btn-xs btn-default" title="Filter Data" data-toggle="modal" data-target="#modal-filter"><i class="fa fa-filter"></i></a>
					<a href="{{ site_url('promo/refresh') }}" class="btn btn-xs btn-default" title="segarkan"><i class="fa fa-refresh"></i></a>
				</div>
				<div class="clearfix"></div>
			</div>

			<div align="right"> 
				<div class="form-group col-sm-4" align="left"><br> 
					<select onChange="window.location.href=this.value" name="row" id="row">
						<option {{ ($row == 20) ? 'selected' : '' }} value="<?php echo site_url('promo/index/20'); ?>">20</option>
						<option {{ ($row == 50) ? 'selected' : '' }} value="<?php echo site_url('promo/index/50'); ?>">50</option>
						<option {{ ($row == 100) ? 'selected' : '' }} value="<?php echo site_url('promo/index/100'); ?>">100</option>
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
				<table class="table table-hover table-striped table-bordered">
					<thead>
						<tr>
							<th class="text-center">No</th>
							<th>Nama Promo</th>
							<th>Kode Promo</th>
							<th>Maksimal Penggunaan</th>
							<th class="text-center">Tanggal Berakhir</th>
							<th class="text-center">Aksi</th>
						</tr>
					</thead>
					<tbody>						

						@if(is_null($promos) || empty($promos))
						<td colspan="6" class="text-center">Belum ada data promo</td>
						@else
						<?php $i=$this->uri->segment('4') + 1; ?>
						@foreach($promos as $promo)
						<tr>
							<td class="text-center">{{$i++}}</td>
							<td>{{ $promo->name }}</td>
							<td>{{ $promo->code }}</td>
							<td> {{ (is_null($promo->max_use)) ? 'Tidak terbatas' : $promo->max_use.' kali' }}</td>
							<td class="text-center">{{ is_null($promo->end_date) ? 'Tidak terbatas' : date('d/m/Y', strtotime($promo->end_date)) }}</td>
							<td class="text-center">
								<a href="{{ site_url('promo/sunting/'.$promo->id) }}" class="btn btn-xs btn-default" title="sunting"><i class="fa fa-pencil"></i></a>
								<a href="{{ site_url('promo/hapus/'.$promo->id) }}" class="btn btn-xs btn-default" title="hapus" onclick="return confirm('Apakah Anda yakin?')"><i class="fa fa-trash"></i></a>
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
							<option {{ ($row == 20) ? 'selected' : '' }} value="<?php echo site_url('kategori/index/20'); ?>">20</option>
							<option {{ ($row == 50) ? 'selected' : '' }} value="<?php echo site_url('kategori/index/50'); ?>">50</option>
							<option {{ ($row == 100) ? 'selected' : '' }} value="<?php echo site_url('kategori/index/100'); ?>">100</option>
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
				<form action="{{ base_url('kategori/search') }}" method="post">
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
	.label{
		display: block;
		width: 100%;
		padding: 8px;
	}

	.btn-xxs{
		padding: 0 5px;
	}
	.pager{
		margin-top: 0;
		margin-bottom: 0;
	}
</style>
@endsection