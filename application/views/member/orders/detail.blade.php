@layout('_layout/homepage/index')
@section('title') Detail Pesanan@endsection

@section('content')
    <div class="row">
        <div class="breadcrumbDiv col-lg-12">
            <ul class="breadcrumb">
                <li><a href="{{ site_url('/') }}">Beranda</a></li>
                <li><a href="{{ site_url('member/pesanan') }}">Daftar Pesanan</a></li>
                <li class="active"> Detail Pesanan (<strong>{{ $order->id }}</strong>)</li>
            </ul>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-7">
            <h1 class="section-title-inner"><span><i class="fa fa-list-alt"></i> Detail Pesanan </span></h1>

            <div class="row userInfo">
                <div class="col-lg-12">
                    <h2 class="block-title-2"> Detail Pesanan Anda </h2>
                </div>


                <div class="statusContent">


                    <div class="col-sm-12">
                        <div class=" statusTop">
                            <p><strong>Kode:</strong> {{ $order->id }}
                                {{-- <button class="btn btn-sm btn-default" id="btn-clipboard">Salin Kode</button> --}}
                            </p>
                            <p><strong>Tanggal
                                    Dipesan:</strong> {{ hari_indonesia(date('l', strtotime($order->order_date))) }}
                                , {{ tgl_indo(date('Y-m-d', strtotime($order->order_date))) }}</p>
                            <p><strong>Status:</strong>
                                @if($order->status === '0')
                                    <span class="text-warning">Belum dibayar</span>&nbsp;
                                    <a href="{{ site_url('member/pembayaran/konfirmasi') }}"
                                       class="btn btn-sm btn-primary">Konfirmasi Pembayaran</a>
                                @elseif($order->status === '1')
                                    <span class="text-warning">Sudah dibayar, menunggu konfirmasi dari Admin</span>
                                    &nbsp;
                                @elseif($order->status === '2')
                                    <span class="text-warning">Menunggu pengiriman</span>&nbsp;
                                @elseif($order->status === '3')
                                    <span class="text-warning">Sedang dikirim</span>&nbsp;
                                    <a href="{{ site_url('member/pesanan/diterima/'.$order->id) }}"
                                       class="btn btn-sm btn-primary">Pesanan telah diterima</a>
                                @else
                                    <span class="text-primary">Diterima</span>&nbsp;
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="order-box">
                            <div class="order-box-header">
                                Alamat Pengiriman
                            </div>

                            <div class="order-box-content">
                                <div class="address">
                                    <p> Dikirim via {{ str_replace('-', ' Paket Pengiriman ', $order->ship_agent) }}
                                        @if(!is_null($order->ship_receipt_number))
                                            No. Resi:
                                            <strong>
                                                <a title="nomor resi" href="#">{{ $order->ship_receipt_number }}</a>
                                            </strong>
                                        @endif
                                    </p>
                                    <p><strong>{{ $order->ship_first_name.' '.$order->ship_last_name }} </strong></p>

                                    <div class="adr">
                                        <p>{{ $order->ship_village }}, {{ $order->ship_district }}, {{ $order->ship_address }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-sm-6">
                        <div class="order-box">
                            <div class="order-box-header">
                                Metode Pembayaran
                            </div>
                            <div class="order-box-content">
                                <div class="address">
                                    <p>
                                        Transfer Bank {{ $order->senyum_bank_account->bank->name }}
                                        @if($order->status === '0')
                                            <span class="text-warning"> <strong>(Belum dibayar)</strong>
									</span>
                                        @elseif($order->status === '1')
                                            <span class="text-warning"> <strong>(Menunggu konfirmasi pembayaran dari Admin)</strong>
									</span>
                                        @elseif
                                            <span class="text-success"> <strong>(Terbayar)</strong>
									</span>
                                        @endif
                                    </p>
                                    <p><strong>Atas Nama: </strong> {{ $order->senyum_bank_account->behalf }} </p>

                                    <p><strong>No. Rekening: </strong> {{ $order->senyum_bank_account->account }} </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="clear: both"></div>

                    <div class="col-sm-12 clearfix">
                        <div class="order-box">
                            <div class="order-box-header">
                                Daftar Pesanan
                            </div>
                            <div class="order-box-content">
                                <div class="table-responsive">
                                    <p>Harga yang tertera adalah harga produk pada saat dipesan</p>
                                    <br>
                                    <table class="order-details-cart">
                                        <tbody>
                                        <?php $i = 5; ?>
                                        @foreach($order->order_details as $order_detail)
                                            <tr class="cartProduct">
                                                <td class="cartProductThumb" style="width:20%">
                                                    <div>
                                                        <a href="{{ site_url('homepage/produk/'.$order_detail->product->slug) }}">
                                                            <img alt="{{ $order_detail->product->name }}"
                                                                 src="{{ base_url('assets/images/products/'.cek_file($order_detail->product->image_1,'./assets/images/products/','default.png')) }}">
                                                        </a></div>
                                                </td>
                                                <td style="width:40%">
                                                    <div class="miniCartDescription">
                                                        <h4>
                                                            <a href="product-details.html"> {{ $order_detail->product->name }} </a>
                                                        </h4>
                                                        <span class="size"> {{ $order_detail->product->category->name }} </span>

                                                        <div class="price">
                                                            <span>Rp {{ number_format($order_detail->current_price, 0, ',', '.') }}</span>&nbsp;
                                                            @if(!is_null($order_detail->current_discount))
                                                                <span class="label label-warning">Diskon {{ $order_detail->current_discount * 100 }}
                                                                    %</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="" style="width:10%"><a> X {{ $order_detail->quantity }} </a>
                                                </td>
                                                <td class="" style="width:15%">
                                                    <span> Rp {{ number_format(($order_detail->current_price - ($order_detail->current_price * $order_detail->current_discount) ) * $order_detail->quantity, 0, ',', '.') }} </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr class="cartTotalTr blank">
                                            <td class="" style="width:20%">
                                                <div></div>
                                            </td>
                                            <td style="width:40%"></td>
                                            <td class="" style="width:20%"></td>
                                            <td class="" style="width:15%"><span>  </span></td>

                                        </tr>

                                        <tr class="cartTotalTr">
                                            <td class="" style="width:20%">
                                                <div></div>
                                            </td>
                                            <td colspan="2" style="width:40%">Jumlah</td>
                                            <td class="" style="width:15%">
                                                <span> Rp {{ number_format($order->total_products_price_without_tax, 0, ',', '.') }} </span>
                                            </td>

                                        </tr>
                                        @if($order->membership_discount)
                                            <tr class="cartTotalTr">
                                                <td class="" style="width:20%">
                                                    <div></div>
                                                </td>
                                                <td colspan="2" style="width:40%">Diskon Member</td>
                                                <td class="" style="width:15%">
                                                    <span> - Rp {{number_format($order->membership_discount, 0, ',', '.')}} </span>
                                                </td>
                                            </tr>
                                        @endif
                                        @if($order->reseller_discount)
                                            <tr class="cartTotalTr">
                                                <td class="" style="width:20%">
                                                    <div></div>
                                                </td>
                                                <td colspan="2" style="width:40%">Diskon Reseller</td>
                                                <td class="" style="width:15%">
                                                    <span> - Rp {{number_format($order->reseller_discount, 0, ',', '.')}} </span>
                                                </td>
                                            </tr>
                                        @endif
                                        <tr class="cartTotalTr">
                                            <td class="" style="width:20%">
                                                <div></div>
                                            </td>
                                            <td colspan="2" style="width:40%">Ongkos Kirim</td>
                                            <td class="" style="width:15%">
                                                <span> Rp {{ number_format($order->ship_price, 0, ',', '.') }} </span>
                                            </td>

                                        </tr>
                                        <tr class="cartTotalTr">
                                            <td class="" style="width:20%">
                                                <div></div>
                                            </td>
                                            <td style="width:40%"></td>
                                            <td class="" style="width:20%">Total</td>
                                            <td class="" style="width:15%">
                                                <span class="price"> Rp {{ number_format($order->total_all, 0, ',', '.') }} </span>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12">
                    {{-- todo cetak invoice --}}
                </div>
                <br><br>
                <div class="col-lg-12 clearfix">
                    <ul class="pager">
                        <li class="previous pull-right"><a href="{{ site_url('/') }}"> <i class="fa fa-home"></i> Ke
                                Beranda </a>
                        </li>
                        <li class="next pull-left"><a href="{{ site_url('member/akun') }}">&larr; Kembali Ke Akun
                                Saya</a></li>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.7.1/clipboard.min.js"></script>
    <script type="text/javascript">
        var clipboard = new Clipboard('#btn-clipboard');
    </script>
@endsection