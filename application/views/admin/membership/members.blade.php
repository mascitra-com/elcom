@layout('_layout/dashboard/index')
@section('title')Daftar Anggota@endsection

@section('content')
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-theme">
			<div class="panel-heading">
				<h3 class="panel-title pull-left">Daftar Membership</h3>
				<div class="btn-group pull-right">
					<a href="{{ site_url('membership/add_member') }}" class="btn btn-xs btn-default"><i class="fa fa-plus"></i></a>
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
//					echo $paginasi;
					?>  
				</div>      
			</div>

			<div class="panel-body table-responsive table-full">
				<table class="table table-hover table-striped table-bordered">
					<thead>
						<tr>
							<th class="text-center" width="5%">No</th>
							<th width="20%">E-mail</th>
							<th width="20%">Nama Lengkap</th>
							<th class="text-center">Membership</th>
							<th class="text-center">Member Sejak</th>
							<th class="text-center">Aktif Hingga</th>
							<th class="text-center" width="10%">Aksi</th>
						</tr>
					</thead>
					<tbody>						

						@if(is_null($members) || empty($members))
						<td colspan="7" class="text-center">Belum ada Data Membership</td>
						@else
						<?php $i=$this->uri->segment('4') + 1; ?>
						@foreach($members as $list)
						<tr>
							<td class="text-center">{{$i++}}</td>
							<td>{{ $list->email }}</td>
							<td>{{ $list->first_name }} {{ $list->last_name }}</td>
							<td class="text-center">{{ $list->name }}</td>
							<td class="text-center">{{ date('d-m-Y', strtotime($list->created_at)) }}</td>
							<td class="text-center">{{ date('d-m-Y', strtotime($list->end )) }}</td>
							<td class="text-center">
								<a href="{{ base_url('membership/edit_member/' . $list->user_id) }}" class="btn btn-xs btn-default" title="sunting"><i class="fa fa-pencil"></i></a>
								<a href="{{ base_url('membership/delete_member/' . $list->user_id) }}" class="btn btn-xs btn-default" title="hapus" onclick="return confirm('Apakah Anda yakin?')"><i class="fa fa-trash"></i></a>
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
//					echo $paginasi;
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