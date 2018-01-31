@layout('_layout/dashboard/index')
@section('title')Detail Pesanan <strong>{{ $order->id }}</strong>@endsection

@section('content')
<div class="row">
	<div class="col-xs-12">
		<p><a href="{{ site_url('pesanan') }}" class="btn btn-default"><i class="fa fa-arrow-left"></i> Daftar Pesanan</a></p>
		<div class="panel">
			<div class="panel-body">
				<h2 class="title">Kode Pesanan: {{ $order->id }}</h2>
				<br>
				<p class="title"><strong>Tanggal Dipesan:</strong> {{ date('d/m/Y', strtotime($order->order_date)) }}</p>
				<p class="title"><strong>Tanggal Dikonfirmasi:</strong> {{ (is_null($order->verified_at)) ? '-' : date('d/m/Y', strtotime($order->verified_at)) }}</p>
				<p class="title"><strong>Tanggal Dikirim:</strong> {{ (is_null($order->shipped_date)) ? '-' : date('d/m/Y', strtotime($order->shipped_date)) }}</p>
				<p class="title"><strong>Tanggal Diterima:</strong> {{ (is_null($order->required_date)) ? '-' : date('d/m/Y', strtotime($order->required_date)) }}</p>
				<div class="content">
					<div class="row">
						<div class="col-xs-12 col-sm-6">
							<div class="panel panel-default">
								<div class="panel-heading">Alamat Pengiriman</div>
								<div class="panel-body">
									<p> <strong>Dikirim via :</strong> {{ str_replace('-', ' Paket Pengiriman ', $order->ship_agent) }}
									@if(!is_null($order->ship_receipt_number))
										<strong>
											No. Resi: <a href="#">{{ $order->ship_receipt_number }}</a>
										</strong>
										@endif
									</p>
									<p><strong>Penerima :</strong> {{ $order->ship_first_name.' '.$order->ship_last_name }}</p>
									<p><strong>Alamat :</strong> {{ $order->ship_village }}, {{ $order->ship_district }}, {{ $order->ship_address }}</p>
									<p><strong>Nomor Telepon :</strong> {{ $order->ship_mobile }}</p>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-6">
							<div class="panel panel-default">
								<div class="panel-heading">Metode Pembayaran</div>
								<div class="panel-body">
									<p><strong>Transfer Bank {{ $order->senyum_bank_account->bank->name }} 
										@if($order->status === '0')
										<span class="text-warning">(belum dibayar)</span>
										@else
										<span class="text-success">(terbayarkan)</span>
										@endif
									</strong></p>
									<p>Bayar ke: {{ $order->senyum_bank_account->bank->name }} (Atas Nama: {{ $order->senyum_bank_account->behalf }})</p>
									<p>Nama Pentransfer: {{ (is_null($order->transfer_person_fullname)) ? '-' : $order->transfer_person_fullname }}</p>
									<p>Nilai transfer: {{ is_null($order->transfer_amount) ? '-' : 'Rp '.number_format($order->transfer_amount, 0, ',', '.') }}</p>
									<p>Tanggal transfer: {{ is_null($order->payment_date) ? '-' : date('Y/m/d', strtotime($order->payment_date)) }}</p>
									<p>Catatan: {{ (is_null($order->transfer_note)) ? '-' : strip_tags($order->transfer_note) }}</p>
								</div>
							</div>
						</div>
					</div>
					<div class="panel panel-theme">
						<div class="panel-heading">
							<h3 class="panel-title pull-left">Daftar Produk</h3>
							<div class="clearfix"></div>
						</div>
						<div class="panel-body table-responsive table-full">
							<table class="table table-stripped table-hover table-bordered">
								<thead>
									<tr>
										<th class="text-center">NO.</th>
										<th>Nama Produk</th>
										<th>Kuantitas</th>
										<th class="text-center">Diskon</th>
										<th class="text-center">Harga Asli</th>
										<th class="text-center">Total</th>
									</tr>
								</thead>
								<tbody>
									<?php $no=0; ?>
									@foreach($order->order_details as $order_detail)
									<tr>
										<td class="text-center">{{ ++$no }}</td>
										<td><a href="{{ site_url('produk/selengkapnya/'.$order_detail->product->code) }}" target="_blank">{{ $order_detail->product->name }}</a></td>
										<td>{{ $order_detail->quantity }}</td>
										<td class="text-center">{{ is_null($order_detail->current_discount) ? 'Tidak ada diskon' : ($order_detail->current_discount*100)."%" }}</td>
										<td class="text-center">Rp {{ number_format($order_detail->current_price, 0, ',', '.') }}</td>
										<td class="text-right">Rp {{ number_format(($order_detail->current_price - ($order_detail->current_price * $order_detail->current_discount)) * $order_detail->quantity, 0, ',', '.') }}</td>
									</tr>
									@endforeach
									{{-- Kalkulasi start --}}
									<tr>
										<td colspan="5"><span class="pull-right">Jumlah</span></td>
										<td colspan="5"><span class="pull-right">Rp {{ number_format($order->total_products_price_without_tax, 0, ',','.') }}</span></td>
									</tr>
									<!--<tr>
										<td colspan="5"><span class="pull-right">PPN (10%)</span></td>
										<td colspan="5" rowspan="2"><span class="pull-right">Rp {{ number_format($order->total_tax, 0, ',', '.') }}</span></td>
									</tr>-->
									<tr>
										<td colspan="5"><span class="pull-right">Ongkos Kirim</span></td>
										<td colspan="5"><span class="pull-right">Rp {{ number_format($order->ship_price, 0, ',', '.') }}</span></td>
									</tr>
									<tr style="font-size: 18px; font-weight: 700;">
										<td colspan="5"><span class="pull-right text-success">Total</span></td>
										<td colspan="5"><span class="pull-right text-success">Rp {{ number_format($order->total_all, 0, ',', '.') }}</span></td>
									</tr>
									{{-- end kalkulasi --}}
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="panel-footer">
				{{-- todo invoice --}}
				<a href="#" class="btn btn-block btn-primary"><i class="fa fa-print"></i> Cetak Tagihan</a>
			</div>
		</div>
	</div>
</div>
@endsection

@section('style')
<style>
	.panel-body{
		padding: 30px;
	}
	
	.title{
		margin-bottom: 5px;
	}

	.content{
		margin-top: 20px;
	}

	.content > p{
		font-size: 11pt;
		line-height: 28px;
	}
</style>
@endsection