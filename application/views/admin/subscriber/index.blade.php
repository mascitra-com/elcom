@layout('_layout/dashboard/index')
@section('title')Daftar Subscriber@endsection

@section('content')
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-theme">
			<div class="panel-heading">
				<h3 class="panel-title pull-left">Daftar Subscriber</h3>
				<div class="btn-group pull-right">
					<a href="{{ site_url('subscriber/download') }}" class="btn btn-xs btn-default" title="Download"><i class="fa fa-download"></i></a>
				</div>
				<div class="clearfix"></div>
			</div>

			<div align="right"> 
				<div class="form-group col-sm-4" align="left"><br> 
					<select onChange="window.location.href=this.value" name="row" id="row">
						<option {{ ($row == 20) ? 'selected' : '' }} value="<?php echo site_url('subscriber/index/20'); ?>">20</option>
						<option {{ ($row == 50) ? 'selected' : '' }} value="<?php echo site_url('subscriber/index/50'); ?>">50</option>
						<option {{ ($row == 100) ? 'selected' : '' }} value="<?php echo site_url('subscriber/index/100'); ?>">100</option>
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
							<th>Email</th>
							<th width="10%" class="text-center">Aksi</th>
						</tr>
					</thead>
					<tbody>						

						@if(is_null($subscribers) || empty($subscribers))
						<td colspan="6" class="text-center">Belum ada Data Member</td>
						@else
						<?php $i=$this->uri->segment('4') + 1; ?>
						@foreach($subscribers as $list)
						<tr>
							<td class="text-center">{{$i++}}</td>
							<td>{{ $list->email }}</td>
							<td class="text-center text-nowrap">
								<a href="{{ site_url('berita/unsubscribe/'.$list->id) }}" class="btn btn-danger btn-xs" title="Unsubscribe"><i class="fa fa-trash"></i></a>
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
							<option {{ ($row == 20) ? 'selected' : '' }} value="<?php echo site_url('subscriber/index/20'); ?>">20</option>
							<option {{ ($row == 50) ? 'selected' : '' }} value="<?php echo site_url('subscriber/index/50'); ?>">50</option>
							<option {{ ($row == 100) ? 'selected' : '' }} value="<?php echo site_url('subscriber/index/100'); ?>">100</option>
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