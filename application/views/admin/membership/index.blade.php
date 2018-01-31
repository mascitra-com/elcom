@layout('_layout/dashboard/index')
@section('title')Membership@endsection

@section('content')
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-theme">
			<div class="panel-heading">
				<h3 class="panel-title pull-left">Daftar Membership</h3>
				<div class="btn-group pull-right">
					<a href="{{ site_url('membership/tambah') }}" class="btn btn-xs btn-default"><i class="fa fa-plus"></i></a>
					<a href="{{ site_url('membership/refresh') }}" class="btn btn-xs btn-default" title="segarkan"><i class="fa fa-refresh"></i></a>
				</div>
				<div class="clearfix"></div>
			</div>

			<div align="right"> 
				<div class="form-group col-sm-4" align="left"><br> 
					<select onChange="window.location.href=this.value" name="row" id="row">
						<option {{ ($row == 20) ? 'selected' : '' }} value="<?php echo site_url('membership/index/20'); ?>">20</option>
						<option {{ ($row == 50) ? 'selected' : '' }} value="<?php echo site_url('membership/index/50'); ?>">50</option>
						<option {{ ($row == 100) ? 'selected' : '' }} value="<?php echo site_url('membership/index/100'); ?>">100</option>
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
							<th class="text-center" width="5%">No</th>
							<th width="25%">Nama</th>
							<th>Deksripsi</th>
							<th class="text-center" width="10%">Diskon</th>
							<th class="text-center" width="10%">Aksi</th>
						</tr>
					</thead>
					<tbody>						

						@if(is_null($membership) || empty($membership))
						<td colspan="6" class="text-center">Belum ada Data Membership</td>
						@else
						<?php $i=$this->uri->segment('4') + 1; ?>
						@foreach($membership as $list)
						<tr>
							<td class="text-center">{{$i++}}</td>
							<td>{{ $list->name }}</td>
							<td>{{ $list->description }}</td>
							<td class="text-center" >{{ $list->discount * 100 }}%</td>
							<td class="text-center">
								<a href="{{ site_url('membership/sunting/'.$list->id) }}" class="btn btn-xs btn-default" title="sunting"><i class="fa fa-pencil"></i></a>
								<a href="{{ site_url('membership/hapus/'.$list->id) }}" class="btn btn-xs btn-default" title="hapus" onclick="return confirm('Apakah Anda yakin?')"><i class="fa fa-trash"></i></a>
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
							<option {{ ($row == 20) ? 'selected' : '' }} value="<?php echo site_url('membership/index/20'); ?>">20</option>
							<option {{ ($row == 50) ? 'selected' : '' }} value="<?php echo site_url('membership/index/50'); ?>">50</option>
							<option {{ ($row == 100) ? 'selected' : '' }} value="<?php echo site_url('membership/index/100'); ?>">100</option>
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