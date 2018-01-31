<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144"
          href="<?= base_url('assets/homepage/assets/ico/apple-touch-icon-144-precomposed.png') ?>">
    <link rel="apple-touch-icon-precomposed" sizes="114x114"
          href="<?= base_url('assets/homepage/assets/ico/apple-touch-icon-114-precomposed.png') ?>">
    <link rel="apple-touch-icon-precomposed" sizes="72x72"
          href="<?= base_url('assets/homepage/assets/ico/apple-touch-icon-72-precomposed.png') ?>">
    <link rel="apple-touch-icon-precomposed"
          href="<?= base_url('assets/homepage/assets/ico/apple-touch-icon-57-precomposed.png') ?>">
    <link rel="shortcut icon" href="<?= base_url('assets/favicon.png') ?>">
    <!-- Bootstrap core CSS -->
    <link href="<?= base_url('assets/homepage/assets/bootstrap/css/bootstrap.css') ?>" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?= base_url('assets/homepage/assets/css/style.css') ?>" rel="stylesheet">
    <link href="{{ base_url('assets/plugins/dropdown/css/styles.css') }}" rel="stylesheet">

    <!-- Just for debugging purposes. -->
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js') ?>/1.3.0/respond.min.js"></script>
    <![endif]-->

    <!-- include pace script for automatic web page progress bar  -->


    <script>
        paceOptions = {
            elements: true
        };
    </script>

    <script src="<?= base_url('assets/homepage/assets/js/pace.min.js') ?>"></script>
    <title>Senyum Media Stationary | Autentikasi </title>
</head>

<body>

<!-- ALERT -->
<?php $message = $this->session->flashdata('message'); ?>
@if($message)
    <div class="modal fade" tabindex="-1" role="dialog" id="alerts">
        <div class="modal-dialog modal-{{$message[1]}} modal-sm" role="document"
             style="width: 30%; border-radius: 2px;">
            <div class="modal-content" style="background-color: #092C52;">
                <div class="modal-body">
                    <p class="text-center"><i class="fa fa-bell fa-2x" style="color: #DEDEDE; margin-top: 30px;"></i>
                    </p>
                    <p class="break-20 text-size-18 text-center"
                       style="font-size:20px; font-weight:700;color: #DEDEDE; margin-top: 50px;">{{$message[0]}}</p>
                </div>
            </div>
        </div>
    </div>
@endif
<!-- END ALERT -->
<!-- Fixed navbar start -->
<div class="navbar navbar-tshop navbar-fixed-top megamenu" role="navigation">
    <div class="navbar-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-xs-6 col-md-6">
                    <div class="pull-left ">
                        <ul class="userMenu ">
                            <li><a href="#"> <span class="hidden-xs">BANTUAN</span><i
                                            class="glyphicon glyphicon-info-sign hide visible-xs "></i> </a></li>
                            <li class="phone-number"><a href="callto:{{ $setting->website_phone }}"> <span> <i
                                                class="glyphicon glyphicon-phone-alt "></i></span> <span
                                            class="hidden-xs"
                                            style="margin-left:5px"> {{ $setting->website_phone }} </span>
                                </a></li>
                            <li class="dropdown active megamenu-80width "><a data-toggle="dropdown"
                                                                             class="dropdown-toggle"
                                                                             href="#"> Konfirmasi Pembayaran <b
                                            class="caret"> </b> </a>
                                <ul class="dropdown-menu">
                                    <li class="megamenu-content">
                                        <!-- megamenu-content -->
                                        <form action="{{ site_url('member/pesanan/konfirmasi_pembayaran') }}"
                                              method="POST">
                                            <input type="hidden" name="{{ $this->security->get_csrf_token_name() }}"
                                                   value="{{ $this->security->get_csrf_hash() }}">
                                            <div class="col-xs-12">
                                                <div class="form-group required">
                                                    <label for="InputOrderId">ID Pesanan
                                                        <sup>*</sup></label>
                                                    <input name="id" required type="text" name="InputOrderId"
                                                           class="form-control" id="InputOrderId"
                                                           placeholder="Masukkan ID Pesanan">
                                                </div>
                                                <div class="form-group required">
                                                    <label for="InputLastName">Nilai Pembayaran<sup>*</sup>
                                                    </label>
                                                    <input name="transfer_amount" required type="number"
                                                           class="form-control"
                                                           id="InputLastName"
                                                           placeholder="Masukkan jumlah nilai pembayaran">
                                                </div>
                                                <div class="form-group">
                                                    <label>Tanggal Transfer</label>
                                                </div>
                                                <div class="form-group inline-select">
                                                    <select name="transfer_day" class="form-control">
                                                        @for($i=1; $i<=31; $i++)
                                                            <option value="{{ $i }}" {{ ($i == date('d')) ? 'selected' : '' }}>{{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="form-group inline-select">
                                                    <select name="transfer_month" class="form-control">
                                                        @for($i=1; $i<=12; $i++)
                                                            <option value="{{ $i }}" {{ ($i == date('m')) ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $i + 1, 0, 0)) }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="form-group inline-select">
                                                    <select name="transfer_year" class="form-control">
                                                        <option value="{{ date('Y') }}"
                                                                selected>{{ date('Y') }}</option>
                                                        <option value="{{ date('Y') - 1 }}">{{ date('Y') - 1 }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div>
                                                <div>
                                                    <button type="submit" class="btn btn-block btn-lg btn-primary">
                                                        KONFIRMASI
                                                    </button>
                                                </div>
                                            </div>
                                            <!--userForm-->
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6 col-md-6 no-margin no-padding">
                    <div class="pull-right">
                        <ul class="userMenu">
                        @if($this->ion_auth->logged_in())
                            <!-- IF LOGGED IN -->
                                <li class="dropdown hasUserMenu"><a href="#" class="dropdown-toggle"
                                                                    data-toggle="dropdown"
                                                                    aria-expanded="false"> <i
                                                class="glyphicon glyphicon-log-in hide visible-xs "></i>
                                        Halo, {{ $username->first_name .' '. $username->last_name }} <b
                                                class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ site_url('member/profil') }}"> <i class="fa fa-user"></i> Profil</a>
                                        </li>
                                        <li><a href="{{ site_url('member/pesanan') }}"><i class="fa  fa-calendar"></i>
                                                Pesanan</a></li>
                                        @if(!$reseller)
                                            <li><a href="{{ site_url('member/daftar/reseller') }}"><i
                                                            class="fa  fa-user-circle"></i> Jadi Reseller</a></li>
                                        @else
                                            <li><a href="{{ site_url('member/reseller') }}"><i
                                                            class="fa  fa-user-circle"></i> Reseller Panel</a></li>
                                        @endif
                                        <li class="divider"></li>
                                        <li><a href="{{ site_url('auth/logout') }}"><i class="fa  fa-sign-out"></i>
                                                Keluar</a></li>
                                    </ul>
                                </li>
                        @endif
                        <!-- END LOGGED IN -->
                            @if(!$this->ion_auth->logged_in())
                                <li><a href="{{ site_url('auth') }}"> <span class="hidden-xs">Masuk</span>
                                        <i class="glyphicon glyphicon-log-in hide visible-xs "></i> </a></li>
                                <li class="hidden-xs"><a href="{{ site_url('member/daftar') }}"> Daftar </a></li>
                        </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/.navbar-top-->

    <div class="container">
        <div class="navbar-header">
            <a href="{{ site_url('member/keranjang') }}" class="navbar-toggle"><i
                        class="fa fa-shopping-cart colorWhite"> </i> <span
                        class="cartRespons colorWhite"> </span></a>
            <a class="navbar-brand " href="{{ site_url('/') }}"> <img src="{{ base_url('assets/images/logo.jpg') }}"
                                                                      width="280" alt="Senyum Media"> </a>

        </div>

        <div class="navbar-collapse collapse">
            <div id="custom-search-form" class="nav navbar-form navbar-left form-search form-horizontal">
                <div class="input-append">
                    <input type="text" id="search_product" class="search-query" placeholder=" Cari Produk">
                    <button id="search" type="button" class="btn"><i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
            <div class="nav navbar-nav navbar-right hidden-xs">
                <div class="dropdown cartMenu">
                    <a href="{{ site_url('member/keranjang') }}" class="dropdown-toggle">
                        <i class="fa fa-shopping-cart fa-2x"> </i> <span class="cartRespons">  </span>
                    </a>
                </div>
                <!--/.cartMenu-->
            </div>
            <!--/.navbar-nav hidden-xs-->
        </div>
        <!--/.nav-collapse -->

    </div>
    <!--/.container -->
    <!--/.search-full-->

</div>
<!-- /.Fixed navbar  -->
<nav>
    <div class="wrapper">
        <ul id="menu" class="clearfix">
            <li><a href="#">SEMUA KATEGORI</a>
                <ul>
                    <?=$categories_navbar?>
                </ul>
            </li>
        <!--li><a href="{{ site_url('/') }}">Home</a></li-->

        </ul>
    </div>
</nav>
<!-- /.Fixed navbar  -->
<div class="container main-container headerOffset login" style="margin-top: 10px !important;">
    <!-- START CONTENT HERE -->
    <div class="row">
        <div class="breadcrumbDiv col-lg-12">
            <ul class="breadcrumb">
                <li><a href="<?= site_url('/') ?>">Beranda</a></li>
                <li class="active"> Autentikasi</li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-4">
            <h1 class="section-title-inner" id="header"><span><i class="fa fa-lock"></i> Ganti Password</span></h1>
            <div class="row userInfo">
                <div class="col-xs-12 col-sm-6">
                    <h2 class="block-title-2" id="head"><span>Ganti Password</span></h2>
                    <?php $message = $this->session->flashdata('message'); ?>
                    <form role="form" action="<?= site_url(uri_string()) ?>" method="POST" class="logForm ">
                        <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>"
                               value="<?=$this->security->get_csrf_hash();?>"/>
                        <input type="hidden" name="user_id" value="<?=$user_id?>">
                        <div class="form-group" id="password">
                            <?php echo lang('reset_password_new_password_label', 'password');?>
                            <input type="password" class="form-control" name="new" placeholder="Password">
                        </div>
                        <div class="form-group" id="password">
                            <?php echo lang('reset_password_new_password_confirm_label', 'password');?>
                            <input type="password" class="form-control" name="new_confirm" placeholder="Password">
                        </div>
                        <button class="btn btn-primary" type="submit" id="sumbit"><i class="fa fa-sign-in"></i> Ganti Password</button>
                    </form>
                </div>
            </div>
            <!--/row end-->

        </div>

        <div class="col-lg-6 col-md-6 col-sm-8">
            <img src="{{ base_url("assets/images/login-image.jpg") }}" alt="Image" class="img img-responsive" style="height:350px">
        </div>
    </div>
    <!--/row-->

    <div style="clear:both"></div>
    <!-- /.row  -->
</div>
<!-- END CONTENT HERE -->
<!-- /main container -->

<footer>
    <div class="footer" id="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-3  col-md-3 col-sm-4 col-xs-6">
                    <h3>
                        Kontak
                    </h3>
                    <ul>
                        <li class="supportLi">
                            <p>
                                Senyum Media Stationary
                            </p>
                            <h4>

                                <a class="inline" href="callto:+62331332333">
                                    <strong>
                                        <i class="fa fa-phone">
                                        </i> {{ $setting->website_phone }} </strong>
                                </a>
                            </h4>
                            <h4>
                                <a class="inline" href="mailto:{{ $setting->website_email }}">
                                    <i class="fa fa-envelope-o">
                                    </i>
                                    {{ $setting->website_email }}
                                </a>
                            </h4>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-2  col-md-2 col-sm-4 col-xs-6">
                    <h3> Senyum Media </h3>
                    <ul>
                        @foreach($footer_0 as $page)
                            <li><a href="{{ site_url('homepage/halaman/'.$page->slug) }}"> {{ $page->name }} </a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-lg-2  col-md-2 col-sm-4 col-xs-6">
                    <h3>
                        Layanan
                    </h3>
                    <ul>
                        @foreach($footer_1 as $page)
                            <li><a href="{{ site_url('homepage/halaman/'.$page->slug) }}"> {{ $page->name }} </a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-lg-2  col-md-2 col-sm-4 col-xs-6">
                    <h3>
                        Lainnya
                    </h3>
                    <ul>
                        @foreach($footer_2 as $page)
                            <li><a href="{{ site_url('homepage/halaman/'.$page->slug) }}"> {{ $page->name }} </a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-lg-3  col-md-3 col-sm-6 col-xs-12 ">
                    <h3>
                        Dapatkan Pemberitahuan
                    </h3>
                    <ul>
                        <li>
                            <div class="input-append newsLatterBox text-center">
                                <input type="text" class="full text-center" placeholder="Email ">
                                <button class="btn  bg-gray" type="button">
                                    Langganan
                                </button>
                            </div>
                        </li>
                    </ul>
                    <ul class="social">
                        @if(!empty($setting->website_facebook))
                            <li><a href={{ "http://facebook.com/".$setting->website_facebook }}>
                                    <i class=" fa fa-facebook">
                                        &nbsp;
                                    </i>
                                </a>
                            </li>
                        @endif
                        @if(!empty($setting->website_twitter))
                            <li><a href={{ "http://twitter.com/".$setting->website_twitter }}>
                                    <i class=" fa fa-twitter">
                                        &nbsp;
                                    </i>
                                </a>
                            </li>
                        @endif
                        @if(!empty($setting->website_instagram))
                            <li><a href={{ "http://instagram.com/".$setting->website_instagram }}>
                                    <i class=" fa fa-instagram">
                                        &nbsp;
                                    </i>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <p class="pull-left">
                &copy; <a href="https://www.mascitra.com">Mascitra.com | Konsultan IT</a>. All right reserved.
            </p>


        </div>
    </div>
</footer>

<!-- Le javascript
    ================================================== -->

<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js">
</script>
<script src="<?= base_url('assets/homepage/assets/bootstrap/js/bootstrap.min.js') ?>"></script>
<!-- include  parallax plugin -->
<script type="text/javascript" src="<?= base_url('assets/homepage/assets/js/jquery.parallax-1.1.js') ?>"></script>

<!-- optionally include helper plugins -->
<script type="text/javascript"
        src="<?= base_url('assets/homepage/assets/js/helper-plugins/jquery.mousewheel.min.js') ?>"></script>

<!-- include mCustomScrollbar plugin //Custom Scrollbar  -->

<script type="text/javascript" src="<?= base_url('assets/homepage/assets/js/jquery.mCustomScrollbar.js') ?>"></script>

<!-- include icheck plugin // customized checkboxes and radio buttons   -->
<script type="text/javascript"
        src="<?= base_url('assets/homepage/assets/plugins/icheck-1.x/icheck.min.js') ?>"></script>

<!-- include grid.js') ?> // for equal Div height  -->
<script src="<?= base_url('assets/homepage/assets/js/grids.js') ?>"></script>

<!-- include carousel slider plugin  -->
<script src="<?= base_url('assets/homepage/assets/js/owl.carousel.min.js') ?>"></script>

<!-- jQuery select2 // custom select   -->
<script src="http://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>

<!-- include touchspin.js') ?> // touch friendly input spinner component   -->
<script src="<?= base_url('assets/homepage/assets/js/bootstrap.touchspin.js') ?>"></script>

<!-- include custom script for site  -->
<script src="<?= base_url('assets/homepage/assets/js/script.js') ?>"></script>
<script>
    $(document).ready(function () {
        $('#search').on('click', function () {
            var $input = $('#search_product').val();
            window.location.href = document.location.origin + '/homepage/search/' + $input;
        });
        $('#search_product').keypress(function (e) {
            var key = e.which;
            if (key === 13)  // the enter key code
            {
                var $input = $('#search_product').val();
                window.location.href = document.location.origin + '/homepage/search/' + $input;
            }
        });

        $('a[href="#"]').on('click', function (e) {
            e.preventDefault();
        });

        $('#menu > li').on('mouseover', function (e) {
            $(this).find("ul:first").show();
            $(this).find('> a').addClass('active');
        }).on('mouseout', function (e) {
            $(this).find("ul:first").hide();
            $(this).find('> a').removeClass('active');
        });

        $('#menu li li').on('mouseover', function (e) {
            if ($(this).has('ul').length) {
                $(this).parent().addClass('expanded');
            }
            $('ul:first', this).parent().find('> a').addClass('active');
            $('ul:first', this).show();
        }).on('mouseout', function (e) {
            $(this).parent().removeClass('expanded');
            $('ul:first', this).parent().find('> a').removeClass('active');
            $('ul:first', this).hide();
        });
        $("#alerts").modal('show');
    });
</script>
</body>
</html>
