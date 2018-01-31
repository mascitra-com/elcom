@layout('_layout/homepage/index')
@section('title') Pembayaran@endsection

@section('content')
    <div class="row">
        <div class="breadcrumbDiv col-lg-12">
            <ul class="breadcrumb">
                <li><a href="{{ site_url('/') }}">Beranda</a></li>
                <li><a href="{{ site_url('member/keranjang') }}">Keranjang</a></li>
                <li class="active"> Pembayaran</li>
            </ul>
        </div>
    </div>
    <!--/.row-->

    <form name="paymentform" action="{{ site_url('member/pesanan/tambah') }}" method="POST"
          enctype="multipart/form-data">
        {{ $csrf }}
        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-7">
                <h1 class="section-title-inner"><span><i
                                class="glyphicon glyphicon-shopping-cart"></i> Pembayaran</span></h1>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-5 rightSidebar">
                <h4 class="caps"><a href="{{ site_url('member/keranjang') }}"><i class="fa fa-chevron-left"></i>
                        Kembali ke Keranjang </a></h4>
            </div>
        </div>
        <!--/.row-->

        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-12">
                <div class="row userInfo">
                    <div class="col-xs-12 col-sm-12">
                        <div class="w100 clearfix">
                            <div class="row userInfo">

                                <div style="clear: both"></div>
                                <div class="onepage-checkout col-lg-12">
                                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingOne">
                                                <h4 class="panel-title">
                                                    <a role="button" data-toggle="collapse" data-parent="#accordion"
                                                       href="#BillingInformation" aria-expanded="true"
                                                       aria-controls="BillingInformation">
                                                        Alamat Pengiriman
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="BillingInformation" class="panel-collapse collapse in"
                                                 role="tabpanel"
                                                 aria-labelledby="BillingInformation">
                                                <div class="panel-body">
                                                    <div style="clear: both"></div>
                                                    <div id="exisitingAddressBox" class="collapse in">
                                                        <div class="form-group uppercase"><strong>Pilih Alamat
                                                                Pengiriman</strong></div>
                                                        <div class="col-md-4">
                                                            <div class="form-group required">
                                                                <label for="InputCountry">Pilih Alamat <sup>*</sup>
                                                                </label>
                                                                <select class="form-control" required
                                                                        aria-required="true"
                                                                        id="SelectAddress" name="shipment_address_id">
                                                                    @foreach($user_addresses as $user_address)
                                                                        <option value="{{ $user_address->id }}">{{ $user_address->address_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="form-group">
                                                                <a href="#" data-toggle="modal"
                                                                   data-target="#modal-new-address"
                                                                   class="btn btn-md btn-warning"
                                                                   style="margin-top: 30px;">Tambah Alamat Baru</a>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- END Data Pembeli --}}
                                            {{-- Jasa Pengiriman --}}
                                            <div class="panel panel-default">
                                                <div class="panel-heading" role="tab" id="">
                                                    <h4 class="panel-title">
                                                        <a class="collapsed" role="button" data-toggle="collapse"
                                                           data-parent="#accordion" href="#Deliverymethod"
                                                           aria-expanded="false"
                                                           aria-controls="Deliverymethod">
                                                            Jasa Pengiriman
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="Deliverymethod" class="panel-collapse collapse" role="tabpanel"
                                                     aria-labelledby="Deliverymethod">
                                                    <div class="panel-body">
                                                        <div class="w100 row">
                                                            <div class="form-group col-lg-12 col-sm-12 col-md-12 -col-xs-12">
                                                                <table style="width:100%" id="shipments-agency"
                                                                       class="table-bordered table tablelook2">
                                                                    <thead>
                                                                    <tr>
                                                                        <td>Jasa Pengiriman</td>
                                                                        <td>Keterangan</td>
                                                                        <td>Ongkos Kirim</td>
                                                                        <td>Lama Pengiriman</td>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    @foreach($ongkirJne["costs"] as $data)
                                                                        <tr>
                                                                            <td>
                                                                                <label class="radio">
                                                                                    <input type="radio"
                                                                                           name="ship_agent"
                                                                                           id="{{$data["service"]}}"
                                                                                           value="{{strtoupper($ongkirTiki["code"])}}-{{$data["service"]}}">
                                                                                    <img height="30"
                                                                                         src="{{ base_url('assets/homepage/images/site/delivery/jne.png') }}"
                                                                                         alt="jne"></label>
                                                                            </td>
                                                                            <td>{{ $data["service"] }}</td>
                                                                            <td class="cost">{{ $data["cost"][0]["value"] }}</td>
                                                                            <td>{{ $data["cost"][0]["etd"] }} Hari</td>
                                                                        </tr>
                                                                    @endforeach
                                                                    @foreach($ongkirTiki["costs"] as $data)
                                                                        <tr>
                                                                            <td>
                                                                                <label class="radio">
                                                                                    <input type="radio"
                                                                                           name="ship_agent"
                                                                                           id="{{$data["service"]}}"
                                                                                           value="{{strtoupper($ongkirTiki["code"])}}-{{$data["service"]}}">
                                                                                    <img height="30"
                                                                                         src="{{ base_url('assets/homepage/images/site/delivery/tiki.png') }}"
                                                                                         alt="jne"></label>
                                                                            </td>
                                                                            <td>{{ $data["service"] }}</td>
                                                                            <td>{{ $data["cost"][0]["value"] }}</td>
                                                                            <td>{{ $data["cost"][0]["etd"] }} Hari</td>
                                                                        </tr>
                                                                    @endforeach
                                                                    @if(empty($ongkirTiki) && empty($ongkirJne))
                                                                        <tr>
                                                                            <td colspan="4" style="text-align: center">Maaf Total Berat Produk Yang Anda Pesan Tidak bisa dilayani oleh Jasa Pengiriman Kami.
                                                                                <br/> Silahkan Hubungi Customer Service Kami untuk Info Lebih Lanjut. Terima Kasih</td>
                                                                        </tr>
                                                                    @endif
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- END Jasa Pengiriman --}}

                                        {{-- Metode Pembayaran --}}
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="">
                                                <h4 class="panel-title">
                                                    <a class="collapsed" role="button" data-toggle="collapse"
                                                       data-parent="#accordion" href="#Paymentmethod"
                                                       aria-expanded="false"
                                                       aria-controls="Paymentmethod">
                                                        Metode Pembayaran
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="Paymentmethod" class="panel-collapse collapse" role="tabpanel"
                                                 aria-labelledby="Paymentmethod">
                                                <div class="panel-body">
                                                    <div class="w100 row">
                                                        <div class="form-group col-lg-12 col-sm-12 col-md-12 -col-xs-12">
                                                            <p>Transfer Ke:</p>
                                                            <table style="width:100%"
                                                                   class="table-bordered table tablelook2">
                                                                <tbody>
                                                                <tr>
                                                                    <td>Bank</td>
                                                                    <td>Keterangan</td>
                                                                </tr>
                                                                @foreach($senyum_bank_accounts as $key => $senyum_bank)
                                                                    <tr>
                                                                        <td>
                                                                            <label class="radio">
                                                                                <input type="radio"
                                                                                       name="bank_account_id"
                                                                                       id="bank_account_id1"
                                                                                       value="{{ $senyum_bank->id }}">
                                                                                <img height="30"
                                                                                     src="{{ base_url("assets/images/bank/$bank_icon[$key].png") }}"
                                                                                     alt="{{ $senyum_bank->bank->name }}">
                                                                            </label>
                                                                        </td>
                                                                        <td>Nomor Rekening:
                                                                            <strong>{{ $senyum_bank->account }}</strong>
                                                                            <br>Atas Nama:
                                                                            <strong>{{ $senyum_bank->behalf }}</strong>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- END Metode Pembayaran --}}
                                    </div>
                                </div>
                                <!--onepage-checkout-->

                            </div>
                            <!--/row end-->

                        </div>


                    </div>
                </div>
                <!--/row end-->

            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 rightSidebar">
                <div class="w100 cartMiniTable">
                    <table id="cart-summary" class="std table">
                        <tbody>
                        <?php
                        $discount = 0;
                        if($membership && $reseller && $reseller->active){
                            $tax = ($cart->total_without_tax - ($cart->total_without_tax * $membership->discount) - ($cart->total_without_tax * 0.02)) * 0.1;
                            $discount = ($cart->total_without_tax * $membership->discount) + ($cart->total_without_tax * 0.02);
                        } else if($membership || ($reseller && $reseller->active)){
                            if(isset($membership)){
                                $tax = ($cart->total_without_tax - ($cart->total_without_tax * $membership->discount)) * 0.1;
                                $discount = ($cart->total_without_tax * $membership->discount);
                            } else if($reseller && $reseller->active){
                                $tax = ($cart->total_without_tax - ($cart->total_without_tax * 0.02)) * 0.1;
                                $discount = ($cart->total_without_tax * 0.02);
                            }
                        } else {
                            $tax = $cart->total_without_tax * 0.1;
                        }
                        $total_all = $ongkirJne["costs"][0]["cost"][0]["value"] + $cart->total_without_tax - $discount;
                        ?>
                        <tr class="cart-total-price ">
                            <td width="40%">Total Harga Produk</td>
                            <td class="price">Rp {{ number_format($cart->total_without_tax, 0, ',', '.') }}</td>
                        </tr>
                        @if(isset($membership))
                            <tr>
                                <td>Diskon Member <br>{{$membership->name}} ({{$membership->discount * 100}} %)</td>
                                <td class="price" id="membership">-
                                    Rp {{ number_format($cart->total_without_tax * $membership->discount, 0, ',', '.') }}</td>
                            </tr>
                        @endif
                        @if(isset($reseller) && $reseller->active)
                            <tr>
                                <td>Diskon Reseller <br></td>
                                <td class="price" id="membership">-
                                    Rp {{ number_format($cart->total_without_tax * 0.02, 0, ',', '.') }}</td>
                            </tr>
                        @endif
                        <tr style="">
                            <td>Ongkos Kirim</td>
                            <td style="font-size: 18px;font-weight: bold;" id="shipment-fee">
                                <span class="success">Rp {{ number_format($ongkirJne["costs"][0]["cost"][0]["value"], 0, ',', '.') }}</span><br>
                            </td>
                        </tr>
                        <tr>
                            <td>Total Belanja</td>
                            {{-- todo display total-price with ship price amount --}}
                                <td class="site-color" id="total-price">
                                    Rp {{ number_format($total_all, 0, ',', '.') }}</td>
                        </tr>
                        </tbody>
                        <tbody>
                        </tbody>
                    </table>
                    {{-- todo promo id --}}
                    <input type="hidden" name="promo_id" value="">

                    {{-- todo ship price amount --}}
                    <input type="hidden" name="ship_price" value="{{ $ongkirJne["costs"][0]["cost"][0]["value"] }}">
                    <input type="hidden" name="ship_district" value="{{ $user_addresses[0]->regency_id }}">

                    <input type="hidden" name="membership_discount"
                           value="{{ isset($membership) ? ($cart->total_without_tax * $membership->discount) : '0' }}">
                    <input type="hidden" name="reseller_discount"
                           value="{{ isset($reseller) && $reseller->active ? ($cart->total_without_tax * 0.02) : '0' }}">
                    <input type="hidden" name="total_products_price_without_tax" value="{{ $cart->total_without_tax }}">
                    <input type="hidden" name="total_tax" value="{{ $tax }}">
                    {{-- todo total_all with shp price amount --}}
                    <input type="hidden" name="total_all" value="{{ $total_all }}">
                    @if(!empty($ongkirTiki) || !empty($ongkirJne))
                    <button type="submit" class="btn btn-primary btn-lg btn-block "
                            title="pembayaran"
                            style="margin-bottom:20px">BAYAR
                    </button>
                    @endif
                </div>
                <!--  /cartMiniTable-->

            </div>
            <!--/rightSidebar-->
        </div>
        <!--/row-->
    </form>


    <div style="clear:both"></div>
@endsection

@section('modal')
    <!-- Modal New Address start -->
    <div class="modal fade" id="modal-new-address" tabindex="-1" role="dialog">
        <div class="modal-dialog ">
            <div class="modal-body">
                <form action="{{site_url('member/pembayaran/address_save')}}" method="POST">
                    {{form_hidden('user_id', $user->id);}}
                    {{$csrf}}
                    <div class="form-group uppercase"><strong>Tambah Alamat</strong></div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group required">
                            <label for="address_name">Nama Alamat<sup>*</sup> </label>
                            <input placeholder="Kantor, Saudara, dll." name="address_name" required type="text"
                                   class="form-control"
                                   id="address_name" placeholder="Nama Awal">
                        </div>
                        <div class="form-group required">
                            <label for="owner_first_name">Nama Depan Pemilik Alamat<sup>*</sup> </label>
                            <input name="owner_first_name" required type="text" class="form-control"
                                   id="owner_first_name" placeholder="Nama Awal">
                        </div>
                        <div class="form-group required">
                            <label for="owner_last_name">Nama Belakang Pemilik Alamat<sup>*</sup>
                            </label>
                            <input name="owner_last_name" required type="text" class="form-control"
                                   id="owner_last_name" placeholder="Nama Terakhir">
                        </div>
                        <div class="form-group required">
                            <label for="full_address">Alamat Lengkap<sup>*</sup> </label>
                            <textarea name="full_address" rows="5" cols="26" required type="text" class="form-control"
                                      id="full_address" placeholder="Alamat"></textarea>
                        </div>
                        <div class="form-group required">
                            <label for="phone">Nomor HP
                                <sup>*</sup></label>
                            <div class="input-group">
                                <span class="input-group-addon">+62</span>
                                <input required type="tel" name="phone"
                                       class="form-control" id="phone">
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group required">
                            <label for="province_id">Provinsi <sup>*</sup> </label>
                            <select name="province_id" class="form-control" required id="provinces">
                                <option value="">Pilih Provinsi</option>
                                @foreach($provinces as $data)
                                    <option value="{{$data['province_id']}}">{{$data['province']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group required">
                            <label for="regencies">Kota / Kabupaten <sup>*</sup> </label>

                            <select name="regency_id" class="form-control" required id="regencies">
                                <option value="">Pilih Kota / Kabupaten</option>
                            </select>
                        </div>
                        <div class="form-group required">
                            <label for="district">Kecamatan <sup>*</sup> </label>
                            <input name="district" required type="text" class="form-control"
                                   id="district" placeholder="Kecamatan">
                        </div>
                        <div class="form-group required">
                            <label for="village">Desa / Kelurahan<sup>*</sup></label>
                            <input name="village" required type="text" class="form-control"
                                   id="village" placeholder="Desa / Kelurahan">
                        </div>
                        <div class="form-group required">
                            <label for="postal_code">Kode Pos<sup>*</sup></label>
                            <input name="postal_code" required type="text" class="form-control" id="postal_code"
                                   placeholder="Kode Pos">
                        </div>
                    </div>

            </div>
            <div>
                <button type="submit" class="btn btn-block btn-lg btn-primary">SIMPAN</button>
            </div>
            </form>
            <!--userForm-->
        </div>
        <!-- /.modal-content -->
        <!-- /.Modal New Address -->
        @endsection
        @section('scripts')
            <script src="<?=base_url('assets/plugins/jquery-number/jquery.number.min.js')?>"></script>
            <script>
                $(document).ready(function () {
                    function disableAllOption($a) {
                        $("#provinces").attr("disabled", "disabled");
                        $("#regencies").attr("disabled", "disabled");
                        $("#districts").attr("disabled", "disabled");
                        $("#villages").attr("disabled", "disabled");
                    }

                    function showAllOption($a) {
                        $('#provinces').removeAttr("disabled");
                        $('#regencies').removeAttr("disabled");
                        $('#districts').removeAttr("disabled");
                        $('#villages').removeAttr("disabled");
                    }

                    $("#regencies").attr("disabled", "disabled");
                    $("#districts").attr("disabled", "disabled");
                    $("#villages").attr("disabled", "disabled");

                    $("#provinces").change(function () {
                        disableAllOption();

                        var url = "<?php echo site_url('member/alamat/add_regencies');?>/" + $(this).val();
                        $('#regencies').load(url, function () {
                            $("#districts").attr("disabled", "disabled");
                            $("#villages").attr("disabled", "disabled");
                        });

                        showAllOption();
                        return false;
                    });

                    $("#regencies").change(function () {
                        disableAllOption();

                        $("#districts").attr("disabled", "disabled");
                        $("#villages").attr("disabled", "disabled");
                        $("#regencies").attr("disabled", "disabled");
                        var url = "<?php echo site_url('member/alamat/add_districts');?>/" + $(this).val();
                        $('#districts').load(url, function () {
                            $("#villages").attr("disabled", "disabled");
                        });

                        showAllOption();
                        return false;
                    });

                    $("#districts").change(function () {
                        disableAllOption();

                        $("#districts").attr("disabled", "disabled");
                        var url = "<?php echo site_url('member/alamat/add_villagess');?>/" + $(this).val();
                        $('#villages').load(url, function () {
                            $('#villages').removeAttr("disabled");
                        });
                        showAllOption();
                        return false;
                    })
                });
            </script>
            <script type="text/javascript">
                $(document).ready(function () {

                    //cheked first radio button on Metode Pembayaran
                    $("input:radio[name=bank_account_id]:first").attr('checked', true);
                    $("input:radio[name=ship_agent]:first").attr('checked', true);

                    //radio button on Jasa Pengiriman
                    $("#SelectAddress").on('change', function () {
                        var id = $('#SelectAddress').val();
                        $.ajax({
                            type: 'get',
                            url: 'pembayaran/getShipmentTable/' + id + '/' + {{ $weight }},
                            success: function (data) {
                                $('table#shipments-agency tbody').empty();
                                $('table#shipments-agency tbody').html(data);
                            },
                            error: function () {
                                console.log('Error');
                            },
                            complete: function () {
                                $("input:radio[name=ship_agent]:first").attr('checked', true);
                                $('input').iCheck({
                                    checkboxClass: 'icheckbox_square-green iCheck-margin',
                                    radioClass: 'iradio_square-green iChk iCheck-margin',
                                    increaseArea: '50%' // optional
                                });
                                updateTotal();
                                $("#shipments-agency label.radio").on('ifChanged', function () {
                                    updateTotal();
                                });
                            }

                        });
                    })
                });
                $("#shipments-agency label.radio").on('ifChanged', function () {
                    updateTotal();
                });

                function updateTotal() {
                    var total = 0;
                    var cost = 0;
                    // iterate through each td based on class and add the values
                    $("#cart-summary td.price").each(function () {
                        cost = $("input:radio[name=ship_agent]:checked").closest("tr").find('td:eq(2)').text();
                        $("#shipment-fee").empty();
                        $("#shipment-fee").html("<span class='success'>Rp " + $.number(cost, 0, ',', '.') + "</span>");
                        $("input[name='ship_price']").val('');
                        $("input[name='ship_price']").val(cost);
                        var value = $(this).text().replace(/Rp|,|/g, '').replace(/\./g, '');
                        // add only if the value is number
                        if (!isNaN(value) && value.length != 0) {
                            total += parseInt(value);
                        }
                    });
                    total += parseInt(cost);
                    @if(isset($membership))
                        total -= parseInt({{ $cart->total_without_tax * $membership->discount }});
                    @endif
                    @if(isset($reseller))
                        total -= parseInt({{ $cart->total_without_tax * 0.02 }});
                    @endif
                    $("#total-price").empty();
                    $("#total-price").text("Rp " + $.number(total, 0, ',', '.'));
                    $("input[name='total_all']").val('');
                    $("input[name='total_all']").val(total);
                }
            </script>
@endsection