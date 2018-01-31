@layout('_layout/homepage/index')
@section('title') Beranda@endsection

@section('styles')
    <link href="{{ base_url('assets/css/product-details-5.css') }}" rel="stylesheet">

    <!-- gall-item Gallery for gallery page -->
    <link href="{{ base_url('assets/plugins/magnific/magnific-popup.css') }}" rel="stylesheet">


    <!-- bxSlider CSS file -->
    <link href="{{ base_url('assets/plugins/bxslider/jquery.bxslider.css') }}" rel="stylesheet"/>

    <style type="text/css">
        .bxslider.product-view-slides li img {
            width: 300px;
            height: 300px;
            object-fit: cover;
            object-position: center;
        }

        .bxslider.product-view-slides li img {
            width: auto !important
        }
    </style>

@endsection

@section('content')
    <div class="row">
        <div class="breadcrumbDiv col-lg-12">
            <ul class="breadcrumb">
                <li><a href="{{ site_url('/') }}">Beranda</a></li>
                @foreach($breadcumb as $bread)
                    <li><a href="<?=base_url("homepage/kategori/$bread[0]")?>"><?=$bread[1]?></a></li>
                @endforeach
                <li class="active">{{ $product->name }}</li>
            </ul>
        </div>
    </div>
    <div class="row transitionfx">

        <!-- left column -->

        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="product-images-carousel-wrapper">

                <div class="productMainImage">
                    <ul class="bxslider product-view-slides product-view-slides-h">
                        <li>
                            <img src="{{ base_url('assets/images/products/'.cek_file($product->image_1,'./assets/images/products/','default.png')) }}"
                                 alt="img"/></li>
                        @if($product->image_2 != "default.png")
                            <li>
                                <img src="{{ base_url('assets/images/products/'.cek_file($product->image_2,'./assets/images/products/','default.png')) }}"
                                     alt="img"/></li>
                        @endif
                        @if($product->image_3 != "default.png")
                            <li>
                                <img src="{{ base_url('assets/images/products/'.cek_file($product->image_3,'./assets/images/products/','default.png')) }}"
                                     alt="img"/></li>
                        @endif
                        @if($product->image_4 != "default.png")
                            <li>
                                <img src="{{ base_url('assets/images/products/'.cek_file($product->image_4,'./assets/images/products/','default.png')) }}"
                                     alt="img"/></li>
                        @endif
                    </ul>
                </div>

                <div class="product-view-thumb-wrapper has-carousel-v">
                    <div class="product-view-thumb-nav prev">
                    </div>

                    <ul id="bx-pager" class="product-view-thumb">
                        <li><a class="thumb-item-link" data-slide-index="0" href=""><img
                                        src="{{ base_url('assets/images/products/'.cek_file($product->image_1,'./assets/images/products/','default.png')) }}"
                                        alt="img"/></a></li>
                        @if($product->image_2 != "default.png")
                            <li><a class="thumb-item-link" data-slide-index="1" href=""><img
                                            src="{{ base_url('assets/images/products/'.cek_file($product->image_2,'./assets/images/products/','default.png')) }}"
                                            alt="img"/></a></li>
                        @endif
                        @if($product->image_3 != "default.png")
                            <li><a class="thumb-item-link" data-slide-index="2" href=""><img
                                            src="{{ base_url('assets/images/products/'.cek_file($product->image_3,'./assets/images/products/','default.png')) }}"
                                            alt="img"/></a></li>
                        @endif
                        @if($product->image_4 != "default.png")
                            <li><a class="thumb-item-link" data-slide-index="3" href=""><img
                                            src="{{ base_url('assets/images/products/'.cek_file($product->image_4,'./assets/images/products/','default.png')) }}"
                                            alt="img"/></a></li>
                        @endif
                    </ul>
                    <div class="product-view-thumb-nav next">

                    </div>

                </div>


            </div>


        </div>
        <!--/ left column end -->


        <!-- right column -->
        <div class="col-lg-4 col-md-4 col-sm-5 col-xs-12">

            <h1 class="product-title"> {{ $product->name }}</h2>

                <h3 class="product-code">Kode Produk : {{ $product->code }}</h3>

                <div class="product-price">
                    <span class="price-sales"> Rp {{ number_format($product->price - ($product->price * $product->discount), 0, ',', '.') }}</span>
                    @if(!is_null($product->discount))
                        <span class="price-standard">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        <span class="label label-danger" style="font-size: 10pt">-{{ $product->discount * 100 }}%</span>
                    @endif
                </div>

                <div class="details-description">
                    <p>{{ (is_null($product->overview) || empty($product->overview)) ? 'Belum ada deskripsi singkat produk.' : $product->overview }}</p>
                </div>

                <div class="productFilter productFilterLook2">

                </div>
                <!-- productFilter -->

                <div class="cart-actions">
                    <div class="addto row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <form action="{{ site_url('member/keranjang/tambah') }}" method="POST">
                                {{ $csrf }}
                                <input type="hidden" name="product_code" value="{{ $product->code }}">
                                <button class="button btn-block btn-cart cart first" title="Tambahkan ke Keranjang"
                                        type="submit">BELI
                                </button>
                            </form>
                        </div>
                        {{-- <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><a class="link-wishlist wishlist btn-block "> Daftar Keinginan</a></div> --}}
                    </div>

                    <div style="clear:both"></div>

                    @if($product->stock == 0)
                        <h3 class="incaps"><i class="fa fa-minus-circle color-out"></i> Stok Habis</h3>
                    @else
                        <h3 class="incaps"><i class="fa fa fa-check-circle-o color-in"></i> Stok Ada</h3>
                    @endif

                </div>
                <!--/.cart-actions-->


        </div>
        <!--/.product-tab-->

        <div style="clear:both"></div>
        <div class="clear"></div>

        <div class="product-tab w100 clearfix">

            <ul class="nav nav-tabs">
                <li class="active"><a href="#description" data-toggle="tab">Deskripsi</a></li>
                <li class=""><a href="#specification" data-toggle="tab">Spesifikasi</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="description">
                    {{ (is_null($product->description) || empty($product->description)) ? 'Belum ada deskripsi lengkap produk.' : $product->description }}
                </div>
                <div class="tab-pane" id="specification">
                    <table>
                        <colgroup>
                            <col style="width:33%">
                            <col style="width:33%">
                            <col style="width:33%">
                        </colgroup>
                        <tbody>
                        <tr>
                            <td>Panjang</td>
                            <td>:</td>
                            <td>{{ (is_null($product->length)) ? '-' : $product->length }} m</td>
                        </tr>
                        <tr>
                            <td>Lebar</td>
                            <td>:</td>
                            <td>{{ (is_null($product->width)) ? '-' : $product->width }} m</td>
                        </tr>
                        <tr>
                            <td>Tinggi</td>
                            <td>:</td>
                            <td>{{ (is_null($product->height)) ? '-' : $product->height }} m</td>
                        </tr>
                        <tr>
                            <td>Berat</td>
                            <td>:</td>
                            <td>{{ (is_null($product->weight)) ? '-' : $product->weight }} kg</td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <!-- /.tab content -->

            <div class="product-share clearfix">
                {{-- <p> Bagikan </p> --}}

                <div class="socialIcon">
                    {{-- <a href="#"> <i class="fa fa-facebook"></i></a> --}}
                    {{-- <a href="#"> <i class="fa fa-twitter"></i></a> --}}
                    {{-- <a href="#"> <i class="fa fa-google-plus"></i></a> --}}
                    {{-- <a href="#"> <i class="fa fa-pinterest"></i></a> --}}
                </div>
            </div>
            <!--/.product-share-->

        </div>
        <!--/ right column end -->

    </div>
    <!--/.row-->

    <div class="row recommended">

        <h1> PRODUK LAINNYA </h1>

        <div id="SimilarProductSlider">
            @foreach($similar_products as $product)
                <div class="item">
                    <div class="product">
                        <div class="image">
                            <a href="<?= site_url('homepage/produk/' . $product->slug)?>" class="product-image">
                                <img src="{{ base_url('assets/images/products/'.cek_file($product->image_1,'./assets/images/products/','default.png')) }}"
                                     alt="img">
                            </a>
                            <div class="promotion">
                                @if(!is_null($product->discount))
                                    <span class="discount">{{ $product->discount*100 }}%</span>
                                @endif
                            </div>
                        </div>
                        <div class="description">
                            <h4><a href="{{ site_url('homepage/produk/'.$product->slug) }}">{{ $product->name }}</a></h4>
                            <div class="price">
                                <span>Rp {{ number_format($product->price - ($product->price * $product->discount), 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
        @endforeach
        <!--/.item-->
        </div>

        <!--/.recommended-->

    </div>


    <div style="clear:both"></div>
@endsection

@section('scripts')
    <script src='{{ base_url('assets/homepage/assets/js/jquery.zoom.js') }}'></script>
    <script>
        $(document).ready(function () {
            //$('.swipebox').zoom();

            $('#zoomContent').zoom();
            $(".zoomThumb a").click(function () {
                var largeImage = $(this).find("img").attr('data-large');
                $(".zoomImage1").attr('src', largeImage);
                $(".zoomImg").attr('src', largeImage);
                $(".gall-item").attr('href', largeImage);

            });

            $('.productImageZoomx').magnificPopup({
                delegate: 'img', type: 'image', gallery: {enabled: true},

                callbacks: {
                    elementParse: function () {
                        this.item.src = this.item.el.attr('src');
                    }
                }

            });


            $('.gall-item').magnificPopup({
                type: 'image',
                gallery: {
                    enabled: true
                }
            });

            $("#zoomContent").click(function () {
                //alert();
                $('.gall-item').trigger('click');
            });

            // CHANGE IMAGE MODAL THUMB

            $(".product-thumbList a").click(function () {
                var largeImage = $(this).find("img").attr('data-large');
                $(".mainImg").attr('src', largeImage);

            });

        });
    </script>

    <script src="{{ base_url('assets/homepage/assets/plugins/magnific/jquery.magnific-popup.min.js') }}"></script>

    <script src="{{ base_url('assets/homepage/assets/plugins/rating/bootstrap-rating.min.js') }}"></script>

    <!-- bxSlider Javascript file -->
    <script src="{{ base_url('assets/plugins/bxslider/plugins/jquery.fitvids.js') }}"></script>
    <script src="{{ base_url('assets/plugins/bxslider/jquery.bxslider.min.js') }}"></script>


    <script>
        $(document).ready(function () {

            var $$mainImgSliderPager = $('#bx-pager');

            // Slider
            var $mainImgSlider = $('.bxslider').bxSlider({
                pagerCustom: '#bx-pager',
                video: true,
                useCSS: false,
                mode: 'fade',
                controls: false
            });

            // initiates responsive slide
            var settings = function () {
                var mobileSettings = {
                    slideWidth: 60,
                    minSlides: 2,
                    maxSlides: 3,
                    slideMargin: 10,
                    controls: false

                };
                var pcSettings = {
                    mode: 'vertical',
                    minSlides: 3,
                    pager: false,
                    slideMargin: 10,
                    nextSelector: '.product-view-thumb-nav.next',
                    prevSelector: '.product-view-thumb-nav.prev',
                    nextText: ' <i class="fa fa-angle-down"></i>',
                    prevText: ' <i class="fa fa-angle-up"></i>'
                };
                return ($(window).width() < 768) ? mobileSettings : pcSettings;
            }

            var thumbSlider;

            function tourLandingScript() {
                thumbSlider.reloadSlider(settings());
            }

            thumbSlider = $('.has-carousel-v .product-view-thumb').bxSlider(settings());
            $(window).resize(tourLandingScript);

        });

    </script>


    <script>
        $(function () {

            $('.rating-tooltip-manual').rating({
                extendSymbol: function () {
                    var title;
                    $(this).tooltip({
                        container: 'body',
                        placement: 'bottom',
                        trigger: 'manual',
                        title: function () {
                            return title;
                        }
                    });
                    $(this).on('rating.rateenter', function (e, rate) {
                        title = rate;
                        $(this).tooltip('show');
                    })
                        .on('rating.rateleave', function () {
                            $(this).tooltip('hide');
                        });
                }
            });

        });
    </script>

    <script type="text/javascript" src="{{base_url('assets/js/skrollr.min.js')}}"></script>
    <script type="text/javascript">
        var isMobile = function () {
            //console.log("Navigator: " + navigator.userAgent);
            return /(iphone|ipod|ipad|android|blackberry|windows ce|palm|symbian)/i.test(navigator.userAgent);
        };

        if (isMobile()) {
            // For  mobile , ipad, tab

        } else {

            if ($(window).width() < 768) {
            } else {
                var s = skrollr.init({forceHeight: false});
            }

        }


    </script>


@endsection