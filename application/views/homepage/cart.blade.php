@layout('_layout/homepage/index')
@section('title') Keranjang Belanja@endsection

@section('content')
    <div class="row">
        <div class="breadcrumbDiv col-lg-12">
            <ul class="breadcrumb">
                <li><a href="{{ site_url('/') }}">Beranda</a></li>
                <li class="active">Keranjang Belanja</li>
            </ul>
        </div>
    </div>
    <!--/.row-->

    <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-7 col-xs-6 col-xxs-12 text-center-xs">
            <h1 class="section-title-inner"><span><i
                            class="glyphicon glyphicon-shopping-cart"></i> Keranjang Belanja </span></h1>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-5 rightSidebar col-xs-6 col-xxs-12 text-center-xs">
            <h4 class="caps"><a onclick="window.history.back()"><i class="fa fa-chevron-left"></i> Kembali
                    berbelanja </a></h4>
        </div>
    </div>
    <!--/.row-->

    <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-7">
            <div class="row userInfo">
                <div class="col-xs-12 col-sm-12">
                    <div class="cartContent w100">
                        <table class="cartTable table-responsive" style="width:100%">
                            <tbody>

                            <tr class="CartProduct cartTableHeader">
                                <td style="width:15%"> Produk</td>
                                <td style="width:40%">Detail</td>
                                <td style="width:10%" class="delete">&nbsp;</td>
                                <td style="width:10%">Jumlah</td>
                                <td style="width:10%">Diskon</td>
                                <td style="width:15%">Total</td>
                            </tr>
                            @if(empty($cart_products))
                                <tr class="CartProduct">
                                    <td colspan="6">Belum ada produk dalam keranjang belanja anda</td>
                                </tr>
                            @else
                                <?php $i = 100; ?>
                                @foreach($cart_products as $cart_product)
                                    <tr class="CartProduct">
                                        <td class="CartProductThumb">
                                            <div>
                                                <a href="<?=base_url("homepage/produk/" . $cart_product->product->slug)?>"><img
                                                            src="{{ base_url('assets/images/products/'.$cart_product->product->image_1) }}"
                                                            alt="img"></a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="CartDescription">
                                                <h4>
                                                    <a href="<?=base_url("homepage/produk/" . $cart_product->product->slug)?>">{{ $cart_product->product->name }} </a>
                                                </h4>
                                                <span class="size">{{ $cart_product->product->category->name }}</span>

                                                @if(!is_null($cart_product->product->discount))
                                                    <div class="real-price"><span><del>Rp {{ number_format($cart_product->product->price, 0, ',', '.') }}</del></span>
                                                    </div>
                                                @endif
                                                <div class="price">
                                                    <span><strong>Rp {{ number_format($cart_product->product->price - ($cart_product->product->price * $cart_product->product->discount), 0, ',', '.') }}</strong></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="delete">
                                            @if($this->ion_auth->logged_in())
                                                <a href="{{ site_url('member/keranjang/hapus_produk/'.$cart_product->id) }}"
                                                   title="Hapus produk dari keranjang belanja"
                                                   onclick="return confirm('Apakah anda yakin?');"> <i
                                                            class="glyphicon glyphicon-trash fa-2x"></i></a>
                                            @else
                                                <a href="{{ site_url('member/keranjang/hapus_product_guest/'.$cart_product->product->code) }}"
                                                   title="Hapus produk dari keranjang belanja"
                                                   onclick="return confirm('Apakah anda yakin?');"> <i
                                                            class="glyphicon glyphicon-trash fa-2x"></i></a>
                                            @endif
                                        </td>
                                        <td><input class="quanitySniper" type="number"
                                                   value="{{ $cart_product->quantity }}" min="1" name="quantity"
                                                   data-cart-detail-id="{{ $cart_product->id }}"
                                                   data-product-code="{{ $cart_product->product->code }}"
                                                   data-product-price="{{ $cart_product->product->price }}"
                                                   data-product-discount="{{ (is_null($cart_product->product->discount) || empty($cart_product->product->discount)) ? 0 : $cart_product->product->discount }}">
                                        </td>
                                        <td>{{ $cart_product->product->discount * 100 }}%</td>
                                        <td class="price" id="price-for-{{ $cart_product->product->code }}">
                                            Rp {{ number_format(($cart_product->product->price - ($cart_product->product->price * $cart_product->product->discount)) * $cart_product->quantity , 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            @endif

                            </tbody>
                        </table>
                    </div>
                    <!--cartContent-->

                    <div class="cartFooter w100">
                        <div class="box-footer">
                            <div class="pull-left"><a href="{{ site_url() }}" class="btn btn-default"> <i
                                            class="fa fa-arrow-left"></i> &nbsp; Kembali berbelanja </a></div>
                            <div class="pull-right">
                                @if($this->ion_auth->logged_in())
                                    <a href="{{ site_url('member/keranjang/hapus_semua') }}" class="btn btn-default"
                                       onclick="return confirm('Apakah anda yakin?')"><i class="fa fa-trash"></i> &nbsp;
                                        Kosongkan
                                        keranjang belanja
                                    </a>
                                @else
                                    <a href="{{ site_url('member/keranjang/hapus_all_product_guest') }}"
                                       class="btn btn-default" onclick="return confirm('Apakah anda yakin?')"><i
                                                class="fa fa-trash"></i> &nbsp; Kosongkan
                                        keranjang belanja
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!--/ cartFooter -->

                </div>
            </div>
            <!--/row end-->

        </div>
        <div class="col-lg-3 col-md-3 col-sm-5 rightSidebar">
            <div class="contentBox">
                <div class="w100 costDetails">
                    <div class="table-block" id="order-detail-content">
                        <form method="POST" action="{{ site_url('member/keranjang/update_cart') }}">
                            {{$csrf}}
                            @if(!empty($cart_products))
                                <input type="hidden" name="total_without_tax">
                                <button type="submit" class="btn btn-primary btn-lg btn-block" title="pembayaran"
                                        style="margin-bottom:20px" {{ (is_null($cart_products) || empty($cart_products)) ? 'disabled' : '' }}>
                                    Lanjutkan ke pembayaran &nbsp; <i class="fa fa-arrow-right"></i>
                                </button>
                            @endif
                        </form>
                        <div class="w100 cartMiniTable">
                            <table id="cart-summary" class="std table">
                                <tbody>
                                <tr class="cart-total-price ">
                                    <td>Jumlah</td>
                                    <td class="price" id="total_without_tax">Rp 0</td>
                                </tr>
                                @if(isset($membership))
                                    <tr>
                                        <td>Diskon Member <br>{{$membership->name}} ({{$membership->discount * 100}} %)
                                        </td>
                                        <td class="price" id="membership">Rp 0</td>
                                    </tr>
                                @endif
                                @if(isset($reseller) && $reseller->active == '1')
                                    <tr>
                                        <td>Diskon Reseller</td>
                                        <td class="price" id="reseller">Rp 0</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td> Total</td>
                                    <td class=" site-color" id="total-price">Rp 0</td>
                                </tr>
                                </tbody>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End popular -->

        </div>
        <!--/rightSidebar-->

    </div>
    <!--/row-->
    <div style="clear:both"></div>
@endsection

@section('scripts')
    <script src="<?=base_url('assets/plugins/jquery-number/jquery.number.min.js')?>"></script>
    <script type="text/javascript">

        $(function () {
            $(calculateTotal);
        });

        //update harga masing-masing produk berdasarkan kuantitas
        $(".quanitySniper").on('keyup change', function () {
            var product_code = $(this).data("product-code");
            var price_column_id = "#price-for-" + product_code;
            var product_price = $(this).data("product-price"); //harga asli produk bersangkutan sebelum di diskon
            var product_discount = $(this).data("product-discount"); //diskon produk bersangkutan
            var product_quantity = $(this).val();
            var cart_detail_id = $(this).data("cart-detail-id");

            //update quantity produk yg bersangkutan sesuai yang diinputkan di cart_details

            clearTimeout($.data(this, 'timer'));
            var wait = setTimeout(updateProductPrice(price_column_id, cart_detail_id, product_quantity, product_price, product_discount, product_code), 500);
            $(this).data('timer', wait);
        });

        //functions
        //update harga produk
        function updateProductPrice(price_column_id, cart_detail_id, product_quantity, product_price, product_discount, product_code) {
            $(price_column_id).empty();

            var html_animated_loading = "<i class='fa fa-spinner fa-pulse fa-fw'></i>";
            html_animated_loading += "<span class='sr-only'>Loading...</span>";
            $(price_column_id).append(html_animated_loading);

            //update quantity produk yg bersangkutan sesuai yang diinputkan di cart_details
            $.post("{{ site_url('member/keranjang/updateQuantity') }}", {
                cart_detail_id: cart_detail_id,
                quantity: product_quantity,
                product_code: product_code
            }, function (data) {
                if (data.status) {
                    //update harga total produk yg bersangkutan
                    var total_product_price = ( product_price - (product_price * product_discount) ) * product_quantity;

                    $(price_column_id).empty();
                    $(price_column_id).append("Rp " + $.number(total_product_price, 0, ',', '.') + "");

                    $(calculateTotal);
                } else {
                    alert("Ada kesalahan pada saat transaksi ajax update quantity");
                }
            }, "json");
        }

        //update harga total produk yg bersangkutan

        //menghitung tabel akumulasi total di samping tampilan keranjang belanja
        function calculateTotal() {
            var total_without_tax = 0;
// iterate through each td based on class and add the values
            $(".cartTable td.price").each(function () {

                var value = $(this).text().replace(/Rp|,|/g, '').replace(/\./g, '');

                // add only if the value is number
                if (!isNaN(value) && value.length != 0) {
                    total_without_tax += parseFloat(value);
                }
            });
            var discount = 0;
            var discount_membersip = 0;
            var discount_reseller = 0;
            $("#total_without_tax").empty();
            $("#total_without_tax").text("Rp " + $.number(total_without_tax, 0, ',', '.'));
            var membership;
            var reseller;
            $.get("{{ site_url('member/keranjang/checkUserAttribute') }}", {}, function (data) {
                membership = data.membership;
                reseller = data.reseller;
                var tax;
                var total_all;
                if (membership) {
                    discount_membersip = total_without_tax * membership.discount;
                    discount += discount_membersip;
                    $("#membership").empty();
                    $("#membership").text("- Rp " + $.number(discount_membersip, 0, ',', '.'));
                }
                if (reseller) {
                    discount_reseller = total_without_tax * 0.02;
                    discount += discount_reseller;
                    $("#reseller").empty();
                    $("#reseller").text("- Rp " + $.number(discount_reseller, 0, ',', '.'));
                }
//                tax = (total_without_tax - discount) * .1;
                console.log(discount_membersip);
                console.log(discount_reseller);
                console.log(discount);
                total_all = total_without_tax - discount;
//                $("#tax").empty();
//                $("#tax").text("Rp " + $.number(tax, 0, ',', '.'));
                $("#total-price").empty();
                $("#total-price").text("Rp " + $.number(total_all, 0, ',', '.'));

            }, "json");

//set input value
            $("input[name='total_without_tax']").val('');
            $("input[name='total_without_tax']").val(total_without_tax);
        }
    </script>
@endsection