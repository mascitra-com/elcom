@layout('_layout/dashboard/index')
@section('title')Reseller@endsection

@section('content')
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-theme">
				<div class="panel-heading">
					<h3 class="panel-title pull-left">Daftar Reseller</h3>
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
							<th>Nama Reseller</th>
							<th>E-mail</th>
							<th width="20%" class="text-center">Status Reseller</th>
							<th width="20%" class="text-center">Deposit</th>
							<th class="text-center" width="15%">Aksi</th>
						</tr>
						</thead>
						<tbody>

						@if(is_null($resellers) || empty($resellers))
							<td colspan="7" class="text-center">Belum ada Data Membership</td>
						@else
                            <?php $i=$this->uri->segment('4') + 1; ?>
							@foreach($resellers as $list)
								<tr>
									<td class="text-center">{{$i++}}</td>
									<td>{{ $list->user_first_name . ' ' . $list->user_last_name }}</td>
									<td>{{ $list->email }}</td>
									<td class="text-center">{{ $list->active ? 'Aktif' : 'Tidak Aktif' }}</td>
									<td class="text-center">{{ $list->deposit ? 'Rp. ' . number_format($list->deposit, 0, ',', '.') : '-'}}</td>
									<td class="text-center">
										@if($list->active)
                                            <a href="{{ base_url('reseller/nonaktifkan/'.$list->id) }}" class="btn btn-xs btn-default" title="Nonaktifkan"><i class="fa fa-close"></i></a>
                                        @else
										    <a href="{{ base_url('reseller/aktifkan/'.$list->id) }}" class="btn btn-xs btn-default" title="Aktifkan"><i class="fa fa-check"></i></a>
                                        @endif
										{{--<a href="#" class="btn btn-xs btn-default" title="Sunting"><i class="fa fa-pencil"></i></a>--}}
										<a href="#" class="btn btn-xs btn-default" title="Hapus" onclick="return confirm('Apakah Anda yakin?')"><i class="fa fa-trash"></i></a>
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