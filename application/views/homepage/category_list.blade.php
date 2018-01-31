@layout('_layout/homepage/index')
@section('title') {{ $category->name }} @endsection

@section('content')
    <!-- Main component call to action -->
    <div class="row">
        <div class="width100 section-block ">
            <div class="row featureImg">
                <div class="col-md-3 col-sm-3 col-xs-6">
                    <a href="{{ $setting->banner_header_1_link ? $setting->banner_header_1_link : '#' }}">
                        <img src="{{ base_url('assets/images/banner/header/'.cek_file($setting->banner_header_1,'./assets/images/banner/header/','default.jpg')) }}"
                             class="img-responsive" alt="img">
                    </a>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-6">
                    <a href="{{ $setting->banner_header_2_link ? $setting->banner_header_2_link : '#' }}">
                        <img src="{{ base_url('assets/images/banner/header/'.cek_file($setting->banner_header_2,'./assets/images/banner/header/','default.jpg')) }}"
                             class="img-responsive" alt="img">
                    </a>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-6">
                    <a href="{{ $setting->banner_header_3_link ? $setting->banner_header_3_link : '#' }}">
                        <img src="{{ base_url('assets/images/banner/header/'.cek_file($setting->banner_header_3,'./assets/images/banner/header/','default.jpg')) }}"
                             class="img-responsive" alt="img">
                    </a>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-6">
                    <a href="{{ $setting->banner_header_4_link ? $setting->banner_header_4_link : '#' }}">
                        <img src="{{ base_url('assets/images/banner/header/'.cek_file($setting->banner_header_4,'./assets/images/banner/header/','default.jpg')) }}"
                             class="img-responsive" alt="img">
                    </a>
                </div>
            </div>
            <!--/.row-->
        </div>
        <!--/.section-block-->

        <!--left column-->
    @include('_layout/homepage/leftbar')

    <!--right column-->
        <div class="col-lg-9 col-md-9 col-sm-12">
            <div class="w100 clearfix category-top">
                <div class="categoryImage"><img
                            src="{{ base_url('assets/images/categories/'.cek_file($category->banner_image,'./assets/images/categories/','default.jpg')) }}"
                            class="img-responsive" alt="img">
                </div>
            </div>
            <!--/.category-top-->
            <h3 class="section-title style2 text-center"><span> {{ $category->name }} </span></h3>

            <div class="w100 productFilter clearfix">
                {{-- <p class="pull-left"> Menampilkan <strong>12</strong> produk </p> --}}

                <div class="pull-right ">
                    <div class="change-order pull-right">
                        <select class="form-control" id="orderby">
                            <?php $orderBy = $this->uri->segment(4); ?>
                            <option value="terbaru" <?=$orderBy == 'terbaru' ? 'selected' : ''?>>Terbaru</option>
                            <option value="a-z" <?=$orderBy == 'a-z' ? 'selected' : ''?>>Nama: A-Z</option>
                            <option value="z-a" <?=$orderBy == 'z-a' ? 'selected' : ''?>>Nama: Z-A</option>
                            <option value="terpopuler" <?=$orderBy == 'terpopuler' ? 'selected' : ''?>>Terpopuler
                            </option>
                            <option value="termurah" <?=$orderBy == 'termurah' ? 'selected' : ''?>>Harga: Rendah ke
                                Tinggi
                            </option>
                            <option value="termahal" <?=$orderBy == 'termahal' ? 'selected' : ''?>>Harga: Tinggi ke
                                Rendah
                            </option>
                        </select>
                    </div>
                    <button class="btn btn-default" id="image-style"><i class="fa fa-th-large"></i></button>
                    <button class="btn btn-primary" id="text-style"><i class="fa fa-list"></i></button>
                </div>
            </div>
            <!--/.productFilter-->

            <div class="row  categoryProduct xsResponse clearfix table-responsive table-full">
                <?php $page = $this->uri->segment('6') ? ($this->uri->segment('6') - 1) : 0; $i = $this->uri->segment('5') * $page + 1; ?>
                @if($products)
                    <table class="table">
                        <thead>
                        <tr>
                            <th class="text-center">NO</th>
                            <th colspan="2">PRODUK</th>
                            <th width="15%">HARGA</th>
                            <th class="text-center text-nowrap">AKSI</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td class="text-center">{{$i++}}</td>
                                <td>
                                    <a href="{{ site_url('homepage/produk/'.$product->slug) }}">
                                    <img src="{{ base_url('assets/images/products/'.cek_file($product->image_1,'./assets/images/products/','default.png')) }}"
                                         alt="thumbnail" class="img img-responsive"
                                         style="max-height: 255px !important; width: auto !important;">
                                    </a>
                                </td>
                                <td>
                                    <h4>
                                        <a href="{{ site_url('homepage/produk/'.$product->slug) }}">
                                        {{ $product->name }}
                                        </a>
                                    </h4>
                                    <p>{{ potong_teks(strip_tags($product->description), 217) }}</p>
                                    <a href="{{ site_url('homepage/kategori/'. $product->category->slug) }}" class="label label-primary">{{ (!isset($product->category->name)) ? 'Lainnya' : $product->category->name }}</a>
                                    <a href="{{ site_url('homepage/produsen/'. $product->producer->slug) }}" class="label label-success">{{ (!isset($product->producer->name)) ? 'Tidak ada Brand' : $product->producer->name }}</a>
                                </td>
                                <td>
                                    @if(!is_null($product->discount))
                                        <div class="real-price"><span><del>Rp {{ number_format($product->price, 0, ',', '.') }}</del></span>
                                        </div>
                                    @endif
                                    <div class="price">
                                        <span><strong>Rp {{ number_format($product->price - ($product->price * $product->discount), 0, ',', '.') }}</strong></span>
                                    </div>
                                    <div>
                                        <?php $today = date('Y-m-d'); ?>
                                        @if(date('Y-m-d', strtotime("+7 day", strtotime($product->created_at))) > $today)
                                            <span class="new-product"> New</span>
                                        @endif
                                        @if(!is_null($product->discount))
                                            <span class="discount">{{ $product->discount*100 }}% OFF</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-center text-nowrap">
                                    <form action="{{ site_url('member/keranjang/tambah') }}" method="POST">
                                        {{ $csrf }}
                                        <input type="hidden" name="product_code" value="{{ $product->code }}">
                                        <button type="submit" class="btn btn-primary"><span
                                                    class="add2cart">Beli </span></button>
                                    </form>
                                </td>
                            </tr>
                            <!--/.item-->
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
            <!--/.categoryProduct || product content end-->
            <div class="w100 categoryFooter col">
                 <div class="pagination pull-left no-margin-top col-xs-8" style="z-index: 9999">
                    <div class="col">
                        <div class="form-group col-xs-2">
                            <select class="form-control" style="width: 50pt !important;" id="perpage">
                                <?php $perpage = $this->uri->segment(5); ?>
                                <option value="12" <?=$perpage == '12' ? 'selected' : ''?>>12</option>
                                <option value="24" <?=$perpage == '24' ? 'selected' : ''?>>24</option>
                                <option value="36" <?=$perpage == '36' ? 'selected' : ''?>>36</option>
                                <option value="48" <?=$perpage == '48' ? 'selected' : ''?>>48</option>
                                <option value="60" <?=$perpage == '60' ? 'selected' : ''?>>60</option>
                            </select>
                        </div>
                        <div class="form-group col-xs-8">
                            <?=$paginasi?>
                        </div>
                    </div>
                </div>
                <div class="pull-right pull-right col-sm-4 col-xs-4 no-padding text-right text-left-xs">
                    <p>Menampilkan <?=count($products) ?> hasil dari <?=$total?> produk</p>
                </div>
            </div>
        </div>
        <!--/.categoryFooter-->

        <!-- PRODUCER START -->
        <div class="width100 section-block clearfix" >
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="section-title text-center" style="margin-bottom:40px;padding:10px; font-size:26px;">
                        <span> BRAND</span> <a id="nextBrand" class="link pull-right carousel-nav"> <i
                                    class="fa fa-angle-right"></i></a> <a id="prevBrand"
                                                                          class="link pull-right carousel-nav"> <i
                                    class="fa fa-angle-left"></i> </a></h3>
                    <ul class="no-margin brand-carousel owl-carousel owl-theme">
                        <?php $i = 1; ?>
                        @foreach($producers as $producer)
                            @if(cek_file('assets/images/producers',$producer->image) && $producer->image != 'default.png')
                                <li><a href="{{ site_url('homepage/produsen/'.$producer->slug) }}"><img
                                                src="{{ base_url('assets/images/producers/'.$producer->image) }}"
                                                alt="img"></a></li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            <!--/.row-->
        </div>
        <!--/.section-block-->
    </div>
    <!--/right column end-->
    </div>
@endsection

@section('outer-content')
    <div class="gap"></div>

    <div class="parallax-section parallax-image-2"
         style="background: url({{ base_url('assets/images/banner/footer/'.cek_file($setting->banner_footer,'./assets/images/banner/footer/','default.png')) }}) fixed;">
        <div class="w100 parallax-section-overley">
            <a href="{{ isset($setting->bannner_footer_link) ? $setting->bannner_footer_link : '' }}"
               class="w100 parallax-section-overley">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="parallax-content clearfix">
                                <h1 class="xlarge"> Senyummedia Online </h1>
                                <h5 class="parallaxSubtitle"> Toko Alat Tulis dan Kantor, Murah dan Terlengkap </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <!--/.parallax-section-->
@endsection

@section('scripts')
    <script>
        $('#orderby').on('change', function () {
            var url = $(location).attr('href').split("/").splice(0, 6).join("/");
            window.location.href = url + '/' + this.value;
        });
        $('#perpage').on('change', function () {
            var url = $(location).attr('href').split("/").splice(0, 6).join("/");
            var orderBy = $('#orderby').val();
            window.location.href = url + '/' + orderBy + '/' + this.value;
        });
        $('#image-style').on('click', function () {
            var url = window.location.pathname;
            window.location.href = url + '?type=image';
        });
        $('#text-style').on('click', function () {
            var url = window.location.pathname;
            window.location.href = url + '?type=text';
        })
    </script>
@endsection