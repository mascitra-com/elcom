@layout('_layout/dashboard/index')
@section('title')Daftar Member@endsection

@section('content')
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-theme">
			<div class="panel-heading">
				<h3 class="panel-title pull-left">Daftar Member</h3>
				<div class="btn-group pull-right">
					<a href="{{ site_url('membership/refresh') }}" class="btn btn-xs btn-default" title="segarkan"><i class="fa fa-refresh"></i></a>
				</div>
				<div class="clearfix"></div>
			</div>

			<div align="right"> 
				<div class="form-group col-sm-4" align="left"><br> 
					<select onChange="window.location.href=this.value" name="row" id="row">
						<option {{ ($row == 20) ? 'selected' : '' }} value="<?php echo site_url('auth/all/20'); ?>">20</option>
						<option {{ ($row == 50) ? 'selected' : '' }} value="<?php echo site_url('auth/all/50'); ?>">50</option>
						<option {{ ($row == 100) ? 'selected' : '' }} value="<?php echo site_url('auth/all/100'); ?>">100</option>
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
							<th width="20%">Email</th>
							<th width="20%">Nama Lengkap</th>
						</tr>
					</thead>
					<tbody>						

						@if(is_null($members) || empty($members))
						<td colspan="6" class="text-center">Belum ada Data Member</td>
						@else
						<?php $i=$this->uri->segment('4') + 1; ?>
						@foreach($members as $list)
						<tr>
							<td class="text-center">{{$i++}}</td>
							<td>{{ $list->email }}</td>
							<td>{{ $list->first_name . ' ' . $list->last_name }}</td>
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
							<option {{ ($row == 20) ? 'selected' : '' }} value="<?php echo site_url('auth/all/20'); ?>">20</option>
							<option {{ ($row == 50) ? 'selected' : '' }} value="<?php echo site_url('auth/all/50'); ?>">50</option>
							<option {{ ($row == 100) ? 'selected' : '' }} value="<?php echo site_url('auth/all/100'); ?>">100</option>
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