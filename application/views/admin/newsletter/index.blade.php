@layout('_layout/dashboard/index')
@section('title')Daftar Produk@endsection

@section('content')
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-theme">
			<div class="panel-heading">
				<h3 class="panel-title pull-left">Daftar Berita</h3>
				<div class="btn-group pull-right">
					<a href="{{ site_url('produk/tambah') }}" class="btn btn-default btn-sm" title="Tambah Produk"><i class="fa fa-plus"></i></a>
				</div>
				<div class="clearfix"></div>
			</div>

			<div align="right"> 
				<div class="form-group col-sm-4" align="left"><br> 
					<select onChange="window.location.href=this.value" name="row" id="row">
						<option {{ ($row == 20) ? 'selected' : '' }} value="<?php echo site_url('berita/index/20'); ?>">20</option>
						<option {{ ($row == 50) ? 'selected' : '' }} value="<?php echo site_url('berita/index/50'); ?>">50</option>
						<option {{ ($row == 100) ? 'selected' : '' }} value="<?php echo site_url('berita/index/100'); ?>">100</option>
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
							<th width="10%" class="text-center">NO</th>
							<th>BERITA</th>
							<th width="10%" class="text-center text-nowrap">AKSI</th>
						</tr>
					</thead>
					<tbody>

					@if(is_null($newsletters) || empty($newsletters))
						<td colspan="6" class="text-center">Tidak ada data</td>
					@else

					<?php $i=$this->uri->segment('4') + 1; ?>
						@foreach($newsletters as $newsletter)
						<tr>
							<td class="text-center">{{$i++}}</td>
							<td>
								<h4>{{ $newsletter->title }}</h4>
								<p>{{ substr(strip_tags($newsletter->body),0, 217) }}</p>
							</td>
							<td class="text-center text-nowrap">
								<a href="{{ site_url('berita/edit/'.$newsletter->id) }}" class="btn btn-primary btn-xs" title="sunting"><i class="fa fa-pencil"></i></a>
								<a href="{{ site_url('berita/kirim/'.$newsletter->id) }}" onclick="return confirm('Anda Yakin Ingin Mengirim Berita Ini ke Semua Subscriber? Ini akan membutuhkan beberapa waktu.')" class="btn btn-success btn-xs" title="kirim"><i class="fa fa-send"></i></a>
								<a href="{{ site_url('berita/hapus/'.$newsletter->id) }}" class="btn btn-danger btn-xs" title="hapus"><i class="fa fa-trash"></i></a>
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
							<option {{ ($row == 20) ? 'selected' : '' }} value="<?php echo site_url('berita/index/20'); ?>">20</option>
							<option {{ ($row == 50) ? 'selected' : '' }} value="<?php echo site_url('berita/index/50'); ?>">50</option>
							<option {{ ($row == 100) ? 'selected' : '' }} value="<?php echo site_url('berita/index/100'); ?>">100</option>
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
				<form action="{{ base_url('produk/search') }}" method="post">
				{{ $csrf }}
					<div class="form-group">
						<label for="">Nama</label>
						<input value="{{ (isset($filter['name'])) ? $filter['name'] : '' }}" type="text" class="form-control" name="name" placeholder="Nama Produk" />
					</div> 
					<div class="row">
						<div class="col-sm-12 col-md-6">
							<div class="form-group">
								<label for="">Kategori Produk</label>
								<input name="category_id" list="kategori" class="form-control" placeholder="kode atau nama kategori" autocomplete="off" value="{{ (isset($data_option['category_name'])) ? $data_option['category_name'] : '' }}">
								<datalist id="kategori">
									@foreach($categories as $category)
									<option value="{{ $category->id. ' | '.$category->name }}">
									@endforeach
								</datalist>
							</div>
						</div>
						<div class="col-sm-12 col-md-6">
							<div class="form-group">
								<label for="">Brand</label>
								<input name="producer_id" list="produsen" class="form-control" placeholder="kode atau nama produsen" autocomplete="off" value="{{ (isset($data_option['producer_name'])) ? $data_option['producer_name'] : '' }}">
								<datalist id="produsen">
									@foreach($producers as $producer)
									<option value="{{ $producer->id. ' | '.$producer->name }}">
									@endforeach
								</datalist>
							</div>
						</div>
					</div> 
					<div class="form-group">
						<label for="">Urutkan berdasarkan</label>
						<div class="input-group">
							<select name="order_by" class="form-control"> 
								<option {{ ($order_by == "name") ? 'selected' : '' }} value="name">Nama</option>
								<option {{ ($order_by == "price") ? 'selected' : '' }} value="price">Harga</option>
								<option {{ ($order_by == "stock") ? 'selected' : '' }} value="stock">Stok</option>
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

	function check_usage(product_code) {
        $.ajax({
            type: 'get',
            url: 'produk/check_products_usage/' + product_code,
            dataType: 'json',
            success: function (result) {
                if(result.status){
                    if(confirm('Apakah Anda Yakin? Semua Order dengan Produk Ini Yang Sedang Berjalan Akan Terhapus!')){
                        $.ajax({
                            type: 'get',
                            url: 'produk/hapus/' + product_code
                        });
                        setTimeout(location.reload.bind(location), 1500);
                    }
                } else {
                    if(confirm('Apakah Anda Yakin?')){
                        $.ajax({
                            type: 'get',
                            url: 'produk/hapus/' + product_code
                        });
                        setTimeout(location.reload.bind(location), 1500);
                    }
                }
            }
        });
    }
</script>
@endsection