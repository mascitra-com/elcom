@layout('_layout/homepage/index')
@section('title')Pesanan Saya@endsection

@section('styles')
<!-- styles needed by footable  -->
<link href="{{ base_url('assets/homepage/assets/css/footable-0.1.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ base_url('assets/homepage/assets/css/footable.sortable-0.1.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
<div class="row">
	<div class="breadcrumbDiv col-lg-12">
		<ul class="breadcrumb">
			<li><a href="{{ site_url('/') }}">Beranda</a></li>
			<li><a href="{{ site_url('member/akun') }}">Akun Saya</a></li>
			<li class="active"> Daftar Pesanan</li>
		</ul>
	</div>
</div>


<div class="row">
	<div class="col-lg-9 col-md-9 col-sm-7">
		<h1 class="section-title-inner"><span><i class="fa fa-list-alt"></i> Daftar Pesanan </span></h1>

		<div class="row userInfo">
			<div class="col-lg-12">
				<h2 class="block-title-2"> Daftar Pesanan Anda </h2>
			</div>

			<div style="clear:both"></div>

			<div class="col-xs-12 col-sm-12">
				@if(is_null($orders) || empty($orders))
				<p class="text-center">Belum ada data pesanan.</p>
				@else
				<table class="footable">
					<thead>
						<tr>
							<th data-class="expand" data-sort-initial="true"><span
								title="table sorted by this column on load">Kode Pesanan</span></th>
								<th data-hide="phone,tablet" data-sort-ignore="true">Jumlah Produk</th>
								<th data-hide="phone,tablet"><strong>Metode Pembayaran</strong></th>
								<th data-hide="phone,tablet"><strong></strong></th>
								<th data-hide="default"> Total Harga</th>
								<th data-hide="default" data-type="numeric"> Tanggal Dipesan</th>
								<th data-hide="phone" data-type="numeric"> Status</th>
							</tr>
						</thead>
						<tbody>
							@foreach($orders as $order)
								<tr>
								<td><strong>{{ $order->id }}</strong></td>
								<td>{{ $order->order_details[0]->counted_rows }}
									<small>produk</small>
								</td>
								<td>Transfer Bank</td>
								<td><a href="{{ site_url('member/pesanan/detail/'.$order->id) }}" class="btn btn-primary btn-sm">detail pesanan</a></td>
								<td>Rp {{ $order->total_all }}</td>
								<td>{{ tgl_indo(date('Y-m-d', strtotime($order->order_date))) }}</td>
								<td>
									@if($order->status === '0')
										<span class="label label-warning">Belum Dibayar</span>
									@elseif($order->status === '1')
										<span class="label label-warning">Menunggu konfirmasi dari Admin</span>
									@elseif($order->status === '2')
										<span class="label label-warning">Menunggu pengiriman</span>
									@elseif($order->status === '3')
										<span class="label label-warning">Sedang dikirim</span>
									@else
										<span class="label label-primary">Diterima</span>
									@endif
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				@endif
				</div>

				<div style="clear:both"></div>

				<div class="col-lg-12 clearfix">
					<ul class="pager">
						<li class="previous pull-right"><a href="{{ site_url('/') }}"> <i class="fa fa-home"></i> Ke Beranda </a>
						</li>
						<li class="next pull-left"><a href="{{ site_url('member/akun') }}">&larr; Kembali Ke Akun Saya</a></li>
					</ul>
				</div>
			</div>
			<!--/row end-->

		</div>
		<div class="col-lg-3 col-md-3 col-sm-5"></div>
	</div>
	<!--/row-->

	<div style="clear:both"></div>
	@endsection

	@section('scripts')
	<!-- include footable plugin -->
	<script src="{{ base_url('assets/homepage/assets/js/footable.js') }}" type="text/javascript"></script>
	<script src="{{ base_url('assets/homepage/assets/js/footable.sortable.js') }}" type="text/javascript"></script>
	<script type="text/javascript">
		$(function () {
			$('.footable').footable();
		});
	</script>
	@endsection