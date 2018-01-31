@layout('_layout/homepage/index')
@section('title') Beranda@endsection
@section('content')
    <!-- Main component call to action -->
    <div class="container-fluid">
        <div class="row">
            <div class="width100 section-block container-fluid">
                <div class="row featureImg">
                    <div class="col-md-3 col-sm-3 col-xs-6">
                        <a href="{{ $setting->banner_header_1_link ? $setting->banner_header_1_link : '#' }}">
                            <img src="{{ base_url('assets/images/banner/header/'.cek_file($setting->banner_header_1,'./assets/images/banner/header/','default.jpg')) }}"
                                 class="img-responsive" alt="img">
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-6">
                        <a href="{{ $setting->banner_header_2_link  ? $setting->banner_header_2_link : '#'}}">
                            <img src="{{ base_url('assets/images/banner/header/'.cek_file($setting->banner_header_2,'./assets/images/banner/header/','default.jpg')) }}"
                                 class="img-responsive" alt="img">
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-6">
                        <a href="{{ $setting->banner_header_3_link  ? $setting->banner_header_3_link : '#'}}">
                            <img src="{{ base_url('assets/images/banner/header/'.cek_file($setting->banner_header_3,'./assets/images/banner/header/','default.jpg')) }}"
                                 class="img-responsive" alt="img">
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-6">
                        <a href="{{ $setting->banner_header_4_link  ? $setting->banner_header_4_link : '#'}}">
                            <img src="{{ base_url('assets/images/banner/header/'.cek_file($setting->banner_header_4,'./assets/images/banner/header/','default.jpg')) }}"
                                 class="img-responsive" alt="img">
                        </a>
                    </div>
                </div>
                <!--/.row-->
            </div>
        </div>
    </div>

    <!--/.section-block-->

    <!--left column-->
    <div class="container-fluid">
        <div class="row">
        @include('_layout/homepage/leftbar')
        <!--right column-->
            <div class="col-lg-9 col-md-9 col-sm-12">
                <div class="w100 clearfix category-top">
                    <div class="imageHover">
                        <div id="carousel-id-1" class="carousel slide" data-ride="carousel" data-interval="3000">
                            <!-- Indicators -->
                            <ol class="carousel-indicators">
                                <li data-target="#carousel-id-1" data-slide-to="0" class="active"></li>
                                <li data-target="#carousel-id-1" data-slide-to="1"></li>
                                <li data-target="#carousel-id-1" data-slide-to="2"></li>
                            </ol>

                            <!-- Wrapper for slides -->
                            <div class="carousel-inner" role="listbox">
                                <?php $i = 0; ?>
                                @foreach($sliders as $slider)
                                    <div class="item {{ ($i==0) ? 'active' : '' }}"><img
                                                src="{{ base_url('assets/images/sliders/'.cek_file($slider,'./assets/images/sliders/','default.png')) }}"
                                                class="img-responsive" alt="img"></div>
                                    <?php ++$i; ?>
                                @endforeach
                            </div>

                            <!-- Controls -->
                            <a class="left carousel-control" href="#carousel-id-1" role="button" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="right carousel-control" href="#carousel-id-1" role="button" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
                <!--/.category-top-->

                <h3 class="section-title style2 text-center"><span> Terpopuler </span></h3>
                <div class="container-fluid">
                    <div class="row categoryProduct xsResponse clearfix">
                        <?php $i = 200; ?>
                        @foreach($most_popular_products as $product)
                            <div class="item col-sm-4 col-lg-4 col-md-4 col-xs-6">
                                <div class="product">
                                    <div class="image">
                                        <a href="{{ site_url('homepage/produk/'.$product->slug) }}"><img
                                                    class="img-responsive"
                                                    alt="img"
                                                    src="{{ base_url('assets/images/products/'.cek_file($product->image_1,'./assets/images/products/','default.png')) }}"></a>

                                        <div class="promotion">
                                            <?php $today = date('Y-m-d'); ?>
                                            @if(date('Y-m-d', strtotime("+7 day", strtotime($product->created_at))) > $today)
                                                <span class="new-product"> New</span>
                                            @endif
                                            @if(!is_null($product->discount))
                                                <span class="discount">{{ $product->discount*100 }}% OFF</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="description">
                                        <h4>
                                            <a href="{{ site_url('homepage/produk/'.$product->slug) }}">{{ $product->name }}</a>
                                        </h4>
                                        <div class="grid-description">
                                            <p>{{ (is_null($product->overview) || empty($product->overview)) ? 'Belum ada overview produk.' : potong_teks(strip_tags($product->overview), 56) }}</p>
                                        </div>
                                        <span class="size">{{ $product->category->name }} </span></div>
                                    <div class="price">
                                        @if(!is_null($product->discount))
                                            <span class="real-price"><del>Rp {{ number_format($product->price, 0, ',', '.') }}</del></span>
                                        @endif
                                        <span><strong>Rp {{ number_format($product->price - ($product->price * $product->discount), 0, ',', '.') }}</strong></span>
                                    </div>
                                    <div class="action-control">
                                        <form action="{{ site_url('member/keranjang/tambah') }}" method="POST">
                                            {{ $csrf }}
                                            <input type="hidden" name="product_code" value="{{ $product->code }}">
                                            <button type="submit" class="btn btn-primary"><span
                                                        class="add2cart">Beli </span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!--/.item-->
                        @endforeach
                    </div>
                </div>
                <!--/.categoryProduct || product content end-->

                <div class="w100 clearfix category-top">
                    <div class="categoryImage">
                        <a href="{{ $setting->banner_center_link  ? $setting->banner_center_link : '#'}}">
                            <img src="{{ base_url('assets/images/banner/center/'.cek_file($setting->banner_center,'./assets/images/banner/center/','default.jpg')) }}"
                                 class="img-responsive" alt="img">
                        </a>
                    </div>
                </div>
                <!--/.category-top-->

                <h3 class="section-title style2 text-center"><span> Terbaru </span></h3>
                <div class="container-fluid">
                    <div class="row  categoryProduct xsResponse clearfix">
                        <?php $i = 200; ?>
                        @foreach($newest_products as $product)
                            <div class="item col-sm-4 col-lg-4 col-md-4 col-xs-6">
                                <div class="product">
                                    <div class="image">
                                        <a href="{{ site_url('homepage/produk/'.$product->slug) }}">
                                            <img class="img-responsive" alt="img"
                                                 src="{{ base_url('assets/images/products/'.cek_file($product->image_1,'./assets/images/products/','default.png')) }}"></a>

                                        <div class="promotion">
                                            <?php $today = date('Y-m-d'); ?>
                                            @if(date('Y-m-d', strtotime("+7 day", strtotime($product->created_at))) > $today)
                                                <span class="new-product"> New</span>
                                            @endif
                                            @if(!is_null($product->discount))
                                                <span class="discount">{{ $product->discount*100 }}% OFF</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="description">
                                        <h4>
                                            <a href="{{ site_url('homepage/produk/'.$product->slug) }}">{{ $product->name }}</a>
                                        </h4>
                                        <div class="grid-description">
                                            <p>{{ (is_null($product->overview) || empty($product->overview)) ? 'Belum ada overview produk.' : potong_teks(strip_tags($product->overview), 56) }}</p>
                                        </div>
                                        <span class="size">{{ $product->category->name }} </span></div>
                                    @if(!is_null($product->discount))
                                        <div class="real-price"><span><del>Rp {{ number_format($product->price, 0, ',', '.') }}</del></span>
                                        </div>
                                    @endif
                                    <div class="price">
                                        <span><strong>Rp {{ number_format($product->price - ($product->price * $product->discount), 0, ',', '.') }}</strong></span>
                                    </div>
                                    <div class="action-control">
                                        <form action="{{ site_url('member/keranjang/tambah') }}" method="POST">
                                            {{ $csrf }}
                                            <input type="hidden" name="product_code" value="{{ $product->code }}">
                                            <button type="submit" class="btn btn-primary"><span
                                                        class="add2cart">Beli </span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!--/.item-->
                        @endforeach
                    </div>
                </div>
                @if($discount_20)
                    <h3 class="section-title style2 text-center"><span> Discount 20% </span></h3>
                    <div class="container-fluid">
                        <div class="row categoryProduct xsResponse clearfix">
                            <?php $i = 200; ?>
                            @foreach($discount_20 as $product)
                                <div class="item col-sm-4 col-lg-4 col-md-4 col-xs-6">
                                    <div class="product">
                                        <div class="image">
                                            <a href="{{ site_url('homepage/produk/'.$product->slug) }}"
                                               title="{{ $product->image_1 }}">
                                                <img class="img-responsive" alt="img"
                                                     src="{{ base_url('assets/images/products/'.cek_file($product->image_1,'./assets/images/products/','default.png')) }}"></a>
                                            </a>
                                            <div class="promotion">
                                                <?php $today = date('Y-m-d'); ?>
                                                @if(date('Y-m-d', strtotime("+7 day", strtotime($product->created_at))) > $today)
                                                    <span class="new-product"> New</span>
                                                @endif
                                                @if(!is_null($product->discount))
                                                    <span class="discount">{{ $product->discount*100 }}% OFF</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="description">
                                            <h4>
                                                <a href="{{ site_url('homepage/produk/'.$product->slug) }}">{{ $product->name }}</a>
                                            </h4>
                                            <div class="grid-description">
                                                <p>{{ (is_null($product->overview) || empty($product->overview)) ? 'Belum ada overview produk.' : potong_teks(strip_tags($product->overview), 56) }}</p>
                                            </div>
                                            <span class="size">{{ $product->category->name }} </span></div>
                                        @if(!is_null($product->discount))
                                            <div class="real-price"><span><del>Rp {{ number_format($product->price, 0, ',', '.') }}</del></span>
                                            </div>
                                        @endif
                                        <div class="price">
                                            <span><strong>Rp {{ number_format($product->price - ($product->price * $product->discount), 0, ',', '.') }}</strong></span>
                                        </div>
                                        <div class="action-control">
                                            <form action="{{ site_url('member/keranjang/tambah') }}" method="POST">
                                                {{ $csrf }}
                                                <input type="hidden" name="product_code" value="{{ $product->code }}">
                                                <button type="submit" class="btn btn-primary"><span
                                                            class="add2cart">Beli </span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!--/.item-->
                            @endforeach
                        </div>
                    </div>
                @endif
                @if($discount_10)
                    <h3 class="section-title style2 text-center"><span> Discount 10% </span></h3>
                    <div class="container-fluid">
                        <div class="row  categoryProduct xsResponse clearfix">
                            <?php $i = 200; ?>
                            @foreach($discount_10 as $product)
                                <div class="item col-sm-4 col-lg-4 col-md-4 col-xs-6">
                                    <div class="product">
                                        <div class="image">
                                            <a href="{{ site_url('homepage/produk/'.$product->slug) }}">
                                                <img class="img-responsive" alt="img"
                                                     src="{{ base_url('assets/images/products/'.cek_file($product->image_1,'./assets/images/products/','default.png')) }}"></a>

                                            <div class="promotion">
                                                <?php $today = date('Y-m-d'); ?>
                                                @if(date('Y-m-d', strtotime("+7 day", strtotime($product->created_at))) > $today)
                                                    <span class="new-product"> New</span>
                                                @endif
                                                @if(!is_null($product->discount))
                                                    <span class="discount">{{ $product->discount*100 }}% OFF</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="description">
                                            <h4>
                                                <a href="{{ site_url('homepage/produk/'.$product->slug) }}">{{ $product->name }}</a>
                                            </h4>
                                            <div class="grid-description">
                                                <p>{{ (is_null($product->overview) || empty($product->overview)) ? 'Belum ada overview produk.' : potong_teks(strip_tags($product->overview), 56) }}</p>
                                            </div>
                                            <span class="size">{{ $product->category->name }} </span></div>
                                        @if(!is_null($product->discount))
                                            <div class="real-price"><span><del>Rp {{ number_format($product->price, 0, ',', '.') }}</del></span>
                                            </div>
                                        @endif
                                        <div class="price">
                                            <span><strong>Rp {{ number_format($product->price - ($product->price * $product->discount), 0, ',', '.') }}</strong></span>
                                        </div>
                                        <div class="action-control">
                                            <form action="{{ site_url('member/keranjang/tambah') }}" method="POST">
                                                {{ $csrf }}
                                                <input type="hidden" name="product_code" value="{{ $product->code }}">
                                                <button type="submit" class="btn btn-primary"><span
                                                            class="add2cart">Beli </span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!--/.item-->
                            @endforeach
                        </div>
                    </div>
                @endif
            <!--/.categoryProduct || product content end-->
                @if($product_category1)
                    <h3 class="section-title style2 text-center"><span> Stationery</span></h3>
                    <div class="container-fluid">
                        <div class="row  categoryProduct xsResponse clearfix">
                            <?php $i = 200; ?>
                            @foreach($product_category1 as $product)
                                <div class="item col-sm-4 col-lg-4 col-md-4 col-xs-6">
                                    <div class="product">
                                        <div class="image">
                                            <a href="{{ site_url('homepage/produk/'.$product->slug) }}">
                                                <img class="img-responsive" alt="img"
                                                     src="{{ base_url('assets/images/products/'.cek_file($product->image_1,'./assets/images/products/','default.png')) }}"></a>

                                            <div class="promotion">
                                                <?php $today = date('Y-m-d'); ?>
                                                @if(date('Y-m-d', strtotime("+7 day", strtotime($product->created_at))) > $today)
                                                    <span class="new-product"> New</span>
                                                @endif
                                                @if(!is_null($product->discount))
                                                    <span class="discount">{{ $product->discount*100 }}% OFF</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="description">
                                            <h4>
                                                <a href="{{ site_url('homepage/produk/'.$product->slug) }}">{{ $product->name }}</a>
                                            </h4>
                                            <div class="grid-description">
                                                <p>{{ (is_null($product->overview) || empty($product->overview)) ? 'Belum ada overview produk.' : potong_teks(strip_tags($product->overview), 56) }}</p>
                                            </div>
                                            <span class="size">{{ $product->category->name }} </span></div>
                                        @if(!is_null($product->discount))
                                            <div class="real-price"><span><del>Rp {{ number_format($product->price, 0, ',', '.') }}</del></span>
                                            </div>
                                        @endif
                                        <div class="price">
                                            <span><strong>Rp {{ number_format($product->price - ($product->price * $product->discount), 0, ',', '.') }}</strong></span>
                                        </div>
                                        <div class="action-control">
                                            <form action="{{ site_url('member/keranjang/tambah') }}" method="POST">
                                                {{ $csrf }}
                                                <input type="hidden" name="product_code" value="{{ $product->code }}">
                                                <button type="submit" class="btn btn-primary"><span
                                                            class="add2cart">Beli </span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!--/.item-->
                            @endforeach
                        </div>
                    </div>
                @endif
                @if($product_category2)
                    <h3 class="section-title style2 text-center"><span> Perlengkapan Kantor</span></h3>
                    <div class="container-fluid">
                        <div class="row  categoryProduct xsResponse clearfix">
                            <?php $i = 200; ?>
                            @foreach($product_category2 as $product)
                                <div class="item col-sm-4 col-lg-4 col-md-4 col-xs-6">
                                    <div class="product">
                                        <div class="image">
                                            <a href="{{ site_url('homepage/produk/'.$product->slug) }}">
                                                <img class="img-responsive" alt="img"
                                                     src="{{ base_url('assets/images/products/'.cek_file($product->image_1,'./assets/images/products/','default.png')) }}"></a>

                                            <div class="promotion">
                                                <?php $today = date('Y-m-d'); ?>
                                                @if(date('Y-m-d', strtotime("+7 day", strtotime($product->created_at))) > $today)
                                                    <span class="new-product"> New</span>
                                                @endif
                                                @if(!is_null($product->discount))
                                                    <span class="discount">{{ $product->discount*100 }}% OFF</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="description">
                                            <h4>
                                                <a href="{{ site_url('homepage/produk/'.$product->slug) }}">{{ $product->name }}</a>
                                            </h4>
                                            <div class="grid-description">
                                                <p>{{ (is_null($product->overview) || empty($product->overview)) ? 'Belum ada overview produk.' : potong_teks(strip_tags($product->overview), 56) }}</p>
                                            </div>
                                            <span class="size">{{ $product->category->name }} </span></div>
                                        @if(!is_null($product->discount))
                                            <div class="real-price"><span><del>Rp {{ number_format($product->price, 0, ',', '.') }}</del></span>
                                            </div>
                                        @endif
                                        <div class="price">
                                            <span><strong>Rp {{ number_format($product->price - ($product->price * $product->discount), 0, ',', '.') }}</strong></span>
                                        </div>
                                        <div class="action-control">
                                            <form action="{{ site_url('member/keranjang/tambah') }}" method="POST">
                                                {{ $csrf }}
                                                <input type="hidden" name="product_code" value="{{ $product->code }}">
                                                <button type="submit" class="btn btn-primary"><span
                                                            class="add2cart">Beli </span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!--/.item-->
                            @endforeach
                        </div>
                    </div>
                @endif
                @if($product_category3)
                    <h3 class="section-title style2 text-center"><span> Peralatan Kantor</span></h3>
                    <div class="container-fluid">
                        <div class="row  categoryProduct xsResponse clearfix">
                            <?php $i = 200; ?>
                            @foreach($product_category3 as $product)
                                <div class="item col-sm-4 col-lg-4 col-md-4 col-xs-6">
                                    <div class="product">
                                        <div class="image">
                                            <a href="{{ site_url('homepage/produk/'.$product->slug) }}">
                                                <img class="img-responsive" alt="img"
                                                     src="{{ base_url('assets/images/products/'.cek_file($product->image_1,'./assets/images/products/','default.png')) }}"></a>

                                            <div class="promotion">
                                                <?php $today = date('Y-m-d'); ?>
                                                @if(date('Y-m-d', strtotime("+7 day", strtotime($product->created_at))) > $today)
                                                    <span class="new-product"> New</span>
                                                @endif
                                                @if(!is_null($product->discount))
                                                    <span class="discount">{{ $product->discount*100 }}% OFF</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="description">
                                            <h4>
                                                <a href="{{ site_url('homepage/produk/'.$product->slug) }}">{{ $product->name }}</a>
                                            </h4>
                                            <div class="grid-description">
                                                <p>{{ (is_null($product->overview) || empty($product->overview)) ? 'Belum ada overview produk.' : potong_teks(strip_tags($product->overview), 56) }}</p>
                                            </div>
                                            <span class="size">{{ $product->category->name }} </span></div>
                                        @if(!is_null($product->discount))
                                            <div class="real-price"><span><del>Rp {{ number_format($product->price, 0, ',', '.') }}</del></span>
                                            </div>
                                        @endif
                                        <div class="price">
                                            <span><strong>Rp {{ number_format($product->price - ($product->price * $product->discount), 0, ',', '.') }}</strong></span>
                                        </div>
                                        <div class="action-control">
                                            <form action="{{ site_url('member/keranjang/tambah') }}" method="POST">
                                                {{ $csrf }}
                                                <input type="hidden" name="product_code" value="{{ $product->code }}">
                                                <button type="submit" class="btn btn-primary"><span
                                                            class="add2cart">Beli </span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!--/.item-->
                            @endforeach
                        </div>
                    </div>
            @endif
            <!--/.categoryProduct || product content end-->

                <!--/.section-block-->
            </div>
        </div>
    </div>
    <!--/right column end-->

@endsection

@section('outer-content')
    <!-- PRODUCER START -->
    <div class="width100 container-fluid" id="producer">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="section-title text-center"><span> BRAND</span>
                    <a id="nextBrand" class="link pull-right carousel-nav"> <i
                                class="fa fa-angle-right"></i></a> <a id="prevBrand"
                                                                      class="link pull-right carousel-nav"> <i
                                class="fa fa-angle-left"></i> </a></h3>
                <ul class="no-margin brand-carousel owl-carousel owl-theme">
                    <?php $i = 1; ?>
                    @foreach($producers as $producer)
                        @if(cek_file('assets/images/producers',$producer->image) && $producer->image != 'default.png')
                            <li><a href="{{ site_url('homepage/produsen/'.$producer->slug) }}"><img
                                            src="{{ base_url('assets/images/producers/'.$producer->image) }}" alt="img"></a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
        <!--/.row-->
    </div>
    <div class="gap"></div>

    <div class="parallax-section parallax-image-2"
         style="background: url({{ base_url('assets/images/banner/footer/'.cek_file($setting->banner_footer,'./assets/images/banner/footer/','default.png')) }}) fixed;">
        <a href="{{ isset($setting->bannner_footer_link) ? $setting->bannner_footer_link : '' }}"
           class="w100 parallax-section-overley">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="parallax-content clearfix">
                            <h1 class="xlarge"> Senyummedia Online </h1>
                            <h5 class="parallaxSubtitle"> Toko Alat Tulis dan Kantor, Murah dan Terlengkap</h5>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <!--/.parallax-section-->
@endsection
@section('modal')
    @if($setting->modal_active == 'Aktif')
        <!-- Beginning modal -->
        <div class="modal fade hide" id="modalAds" role="dialog">
            <div class="modal-dialog  modal-bg-1"
                 style="background: url({{ base_url('assets/images/modal/'.cek_file($setting->modal_image,'./assets/images/modal/','default.png')) }}) right bottom no-repeat;">
                <div class="modal-body-content">
                    <a class="close" data-dismiss="modal">×</a>

                    <div class="modal-body">
                        <div class="col-lg-6 col-sm-8 col-xs-8">
                            <h3>{{ $setting->modal_header_text }}</h3>

                            <p class="discountLg">{{ $setting->modal_sub_header_text }} </p>

                            <p>{{ $setting->modal_additional_info }}
                            </p>

                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- beginning modal end -->
    @endif
    <!-- Modal Login start -->
    <div class="modal signUpContent fade" id="ModalLogin" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times;</button>
                    <h3 class="modal-title-site text-center"> Login to TSHOP </h3>
                </div>
                <div class="modal-body">
                    <div class="form-group login-username">
                        <div>
                            <input name="log" id="login-user" class="form-control input" size="20"
                                   placeholder="Enter Username" type="text">
                        </div>
                    </div>
                    <div class="form-group login-password">
                        <div>
                            <input name="Password" id="login-password" class="form-control input" size="20"
                                   placeholder="Password" type="password">
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <div class="checkbox login-remember">
                                <label>
                                    <input name="rememberme" value="forever" checked="checked" type="checkbox">
                                    Remember Me </label>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div>
                            <input name="submit" class="btn  btn-block btn-lg btn-primary" value="LOGIN"
                                   type="submit">
                        </div>
                    </div>
                    <!--userForm-->

                </div>
                <div class="modal-footer">
                    <p class="text-center"> Not here before? <a data-toggle="modal" data-dismiss="modal"
                                                                href="#ModalSignup"> Sign Up. </a> <br>
                        <a href="#"> Lost your password? </a></p>
                </div>
            </div>
            <!-- /.modal-content -->

        </div>
        <!-- /.modal-dialog -->

    </div>
    <!-- /.Modal Login -->

    <!-- Modal Signup start -->
    <div class="modal signUpContent fade" id="ModalSignup" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times;</button>
                    <h3 class="modal-title-site text-center"> REGISTER </h3>
                </div>
                <div class="modal-body">
                    <div class="control-group"><a class="fb_button btn  btn-block btn-lg " href="#"> SIGNUP WITH
                            FACEBOOK </a></div>
                    <h5 style="padding:10px 0 10px 0;" class="text-center"> OR </h5>

                    <div class="form-group reg-username">
                        <div>
                            <input name="login" class="form-control input" size="20" placeholder="Enter Username"
                                   type="text">
                        </div>
                    </div>
                    <div class="form-group reg-email">
                        <div>
                            <input name="reg" class="form-control input" size="20" placeholder="Enter Email"
                                   type="text">
                        </div>
                    </div>
                    <div class="form-group reg-password">
                        <div>
                            <input name="password" class="form-control input" size="20" placeholder="Password"
                                   type="password">
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <div class="checkbox login-remember">
                                <label>
                                    <input name="rememberme" id="rememberme" value="forever" checked="checked"
                                           type="checkbox">
                                    Remember Me </label>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div>
                            <input name="submit" class="btn  btn-block btn-lg btn-primary" value="REGISTER"
                                   type="submit">
                        </div>
                    </div>
                    <!--userForm-->

                </div>
                <div class="modal-footer">
                    <p class="text-center"> Already member? <a data-toggle="modal" data-dismiss="modal"
                                                               href="#ModalLogin">
                            Sign in </a></p>
                </div>
            </div>
            <!-- /.modal-content -->

        </div>
        <!-- /.modal-dialog -->

    </div>
@endsection

@section('scripts')
    <script>
        // this script required for subscribe modal
        $(window).load(function () {
            // full load
            @if($setting->modal_active == 'Aktif')
            $('#modalAds').modal('show');
            $('#modalAds').removeClass('hide');
            @endif
        });

    </script>
@endsection