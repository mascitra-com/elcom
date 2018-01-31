@layout('_layout/dashboard/index')
@section('title')Manajemen Pesanan Produk@endsection

@section('content')
<div class="panel panel-theme">
	<div class="panel-heading">
		<h3 class="panel-title pull-left">Daftar Pesanan</h3>
		<div class="btn-group pull-right">
			<a href="{{ site_url('pesanan/cetak') }}" target="_blank" class="btn btn-default btn-sm"><i class="fa fa-print"></i></a>
			<button class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal-konfirmasi">
				<span class="badge badge-sm space-right-10">{{$count_payment}}</span>
				<i class="fa fa-bell"></i>
			</button>
			<a href="{{site_url('pesanan/refresh')}}" class="btn btn-default btn-sm reload"><i class="fa fa-refresh"></i></a>
			<button class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal-cari"><i class="fa fa-search"></i></button>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="panel-body table-responsive table-full">
		<table class="table table-stripped table-hover table-bordered">
			<thead>
				<tr>
					<th class="text-center">NO.</th>
					<th>KODE PESANAN</th>
					<th>PEMBELI</th>
					<th class="text-center">TGL PESAN</th>
					<th class="text-center">TGL VERIFIKASI</th>
					<th class="text-center">TGL DIKIRIM</th>
					<th class="text-center">TGL DITERIMA</th>
					<th class="text-center">MEMBERSHIP</th>
					<th class="text-center">RESELLER</th>
					<th class="text-center">STATUS</th>
					<th class="text-center">AKSI</th>
				</tr>
			</thead>
			<tbody>
				@if(is_null($orders) || empty($orders))
				<td colspan="6" class="text-center">Belum ada data Pemesanan</td>
				@else
				<?php $i=$this->uri->segment('4') + 1; ?>
				@foreach($orders as $data)
				<tr>
					<td class="text-center">{{$i++}}</td>
					<td>{{$data->id}}</td>
					<td>{{$data->member->first_name.' '.$data->member->last_name}}</td>
					<td class="text-center">{{date("d/m/Y", strtotime($data->created_at));}}</td> 
					<td class="text-center">{{date("d/m/Y", strtotime($data->verified_at));}}</td> 
					<td class="text-center">-</td>
					<td class="text-center">-</td>
					<td class="text-center">{{ isset($data->member->users_membership[0]->membership[0]) ? $data->member->users_membership[0]->membership[0]->name: '-'}}</td>
					<td class="text-center">{{ $data->member->reseller == '1' ? '<i class="fa fa-check"></i>' : '-' }}</td>
					<td class="text-center">{{($data->status == '2') ? '<span class="label label-primary"> terbayar </span>' : ''}}{{($data->status == '3') ? '<span class="label label-warning"> dikirim </span>' : ''}}{{($data->status == '4') ? '<span class="label label-success"> diterima </span>' : ''}}</td>
					<td class="text-center text-nowrap">
						@if($data->status !== '3')
						<a href="#" class="btn btn-warning btn-xs btn-shipment" title="pengiriman" data-order-id="{{$data->id}}"" data-toggle="modal" data-target="#modal-pengiriman"><i class="fa fa-truck"></i></a>
						@endif
						<a href="{{ site_url('pesanan/detail/'.$data->id) }}" class="btn btn-default btn-xs" title="detail pesanan"><i class="fa fa-info"></i> {{ ($data->status == '2') ? ' ' : 'detail' }}</a>
					</td>
				</tr>
				@endforeach
				@endif  
			</tbody>
		</table>
	</div>
	<div class="panel-footer"><span class="text-grey">last edited by admin 12/02/2017 08:50</span></div>
</div>
@endsection

@section('modal')
<div class="modal fade" tabindex="-1" role="dialog" id="modal-tambah">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Tambah Data</h4>
			</div>
			<div class="modal-body">
				<form action="#">
					<div class="form-group">
						<label for="">NIK / NAMA</label>
						<input type="text" class="form-control" name="nik" placeholder="NIK/NAMA" />
					</div>
					<div class="form-group">
						<button class="btn btn-primary"><i class="fa fa-save"></i> tambah</button>
						<button class="btn btn-default" type="refresh"><i class="fa fa-refresh"></i> bersihkan</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="modal-cari">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Filter Pencarian</h4>
			</div>
			<div class="modal-body">
				<form action="{{ base_url('pesanan/search') }}" method="post">
				{{$csrf}}
					<div class="form-group">
						<label for="">Kode Pesanan</label>
						<input value="{{ (isset($filter['id'])) ? $filter['id'] : '' }}" name="id" value="" type="text" class="form-control" placeholder="Kode Pesanan" />
					</div> 
					<div class="row">
						<div class="col-sm-12 col-md-6">
							<div class="form-group">
								<label for="">Nama Pembeli</label>
								<input disabled="" value="" type="text" class="form-control" placeholder="Nama Pembeli" />
							</div> 
						</div>
						<div class="col-sm-12 col-md-6">
							<div class="form-group">
								<label for="">Tanggal Dipesan</label>
								<input value="{{ (isset($filter['created_at'])) ? $filter['created_at'] : '' }}" type="date" name="created_at" class="form-control" placeholder="tanggal dipesan" />
							</div>
						</div>
					</div>
					<div class="form-group">
							<label for="">Status Pesanan</label>
							<select name="status" class="form-control"> 
								<option value="" selected>Semua</option>
								<option {{ ($filter['status'] == "2") ? 'selected' : '' }} value="2">Terbayar</option>
								<option {{ ($filter['status'] == "3") ? 'selected' : '' }} value="3">Sedang Dikirm</option>
								<option {{ ($filter['status'] == "4") ? 'selected' : '' }} value="4">Diterima</option>
							</select>
						</div> 
					<div class="form-group">
						<label for="">Urutkan berdasarkan</label>
						<div class="input-group">
							<select name="order_by" class="form-control"> 
								<option {{($order_by == "id") ? 'selected' : '' }} value="id">Kode Pesanan</option>
								<option {{($order_by == "first_name") ? 'selected' : '' }} value="first_name">Nama Pembeli</option>
								<option {{($order_by == "created_at") ? 'selected' : '' }} value="created_at">Tanggal Dipesan</option>
								<option {{($order_by == "verified_at") ? 'selected' : '' }} value="verified_at">Tanggal Konfirmasi Pembayaran</option>
								<option>Tanggal Dikirm</option>
								<option>Tanggal Pesanan Diterima</option>
							</select>
							<span class="input-group-addon">secara</span>
							<select name="order_type" class="form-control">
								<option {{($order_by == "desc") ? 'selected' : '' }} value="desc" selected>Menaik</option>
								<option {{($order_by == "asc") ? 'selected' : '' }} value="asc">Menurun</option>
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
<div class="modal fade" tabindex="-1" role="dialog" id="modal-konfirmasi">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Konfirmasi Pembayaran Pesanan</h4>
			</div>
			<div class="modal-body table-responsive table-full">
				<table class="table table-bordered table-striped table-hover">
					<thead>
						<tr>
							<td class="text-center">Kode Pesanan</td>
							<td class="text-center">Nama Pembeli</td>
							<td class="text-center">Tanggal Dipesan</td>
							<td class="text-center">Konfirmasi</td>
						</tr>
					</thead>
					<tbody>
						@if(is_null($payments) || empty($payments))
						<td colspan="6" class="text-center">Belum ada data Pembayaran</td>
						@else
						<?php $i=$this->uri->segment('4') + 1; ?>
						@foreach($payments as $data)
						<tr>
							<td class="text-center">{{$data->id}}</td>
							<td>{{$data->member->first_name.' '.$data->member->last_name}}</td>
							<td class="text-center">{{date('d-m-Y', strtotime($data->order_date))}}</td>
							<td class="text-center">
								<button class="btn btn-sm btn-success" data-konfirmasi="1" data-id="{{$data->id}}"><i class="fa fa-check space-right-5"></i>Terima</button>
								<button class="btn btn-sm btn-danger" data-konfirmasi="0" data-id="{{$data->id}}"><i class="fa fa-times space-right-5"></i>Tolak</button>
								<a href="{{ site_url('pesanan/detail/'.$data->id) }}" class="btn btn-sm btn-default"><i class="fa fa-info space-right-5"></i>Detail</a>
							</td>
						</tr>
						@endforeach
						@endif

					</tbody>
				</table>
			</div>
			<div class="modal-footer"></div>
		</div>
	</div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="modal-pengiriman">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Pengiriman Pesanan</h4>
			</div>
			<div class="modal-body">
				<form action="{{site_url('pesanan/konfirmasi_pengiriman')}}" method="POST" class="form">
				{{$csrf}}
				<input type="hidden" name="status" value="3"> 
					<div class="form-group">
						<label for="">ID Pesanan</label>
						<input type="text" class="form-control" name="id" value="" readonly required/>
					</div>
					<div class="form-group">
						<label for="">No. Resi</label>
						<input type="text" class="form-control" name="ship_receipt_number" placeholder="masukkan nomor resi pengiriman" required/>
					</div>
					<div class="form-group" align="right">
						<button class="btn btn-primary">simpan</button>
						<button class="btn btn-default" data-dismiss="modal">batal</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="modal-konfirmasi-dialog">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Alasan <span class="status"></span></h4>
			</div>
			<div class="modal-body">
				<form action="{{site_url('pesanan/konfirmasi')}}" method="POST" id="form-konfirmasi">
					{{$csrf}}
					<div class="form-group">
						<input type="hidden" name="id" value="">
						<input type="hidden" name="status" value="">
						<label for="transfer_note">Keterangan</label>
						<textarea class="form-control" name="transfer_note" placeholder="Keterangan"></textarea>
					</div>
					<div class="form-group">
						<button class="btn btn-primary">simpan</button>
						<button class="btn btn-default" data-dismiss="modal">batal</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection

@section('style')
<style>
	.label{display:block; width: 100%; padding: 5px 0;}
	/*BARU DARISINI*/
	td, th{
		vertical-align: middle!important;
		font-size: 10pt;
	}
</style>
@endsection

@section('javascript')
<script>
	$(document).ready(function(){
		$("[data-konfirmasi]").click(function(){
			var status = ($(this).data('konfirmasi') == 1) ? 'Penerimaan' : 'Penolakan';
			$("#modal-konfirmasi-dialog .modal-title > .status").empty().html(status);
			$("#form-konfirmasi input[name='id']").val($(this).data('id'));
			$("#form-konfirmasi input[name='status']").val($(this).data('konfirmasi'));
			$("#modal-konfirmasi-dialog").modal('show');
		});

		$(".btn-shipment").click(function(){
			$("#modal-pengiriman .form input[name='id']").val($(this).data('order-id'));
		});

		$('#modal-pengiriman').on('hidden.bs.modal', function (e) {
			$("#modal-pengiriman .form").trigger("reset");
		});
	});
</script>
@endsection