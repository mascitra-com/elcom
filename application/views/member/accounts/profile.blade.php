@layout('_layout/homepage/index')
@section('title') Profil Saya @endsection

@section('content')

    <div class="row">
        <div class="breadcrumbDiv col-lg-12">
            <ul class="breadcrumb">
                <li><a href="{{ site_url('/') }}">Beranda</a></li>
                <li class="active"> Profil</li>
            </ul>
        </div>
    </div>
    <!--/.row-->


    <div class="row">

        <div class="col-lg-12 col-md-12 col-sm-7">
            <h1 class="section-title-inner"><span><i class="fa fa-user"></i> Profil Saya </span></h1>
            <div class="row userInfo">

                {{-- START DATA DIRI --}}
                <div class="col-lg-12">
                    <h2 class="block-title-2"> Data Diri</h2>
                </div>

                <div class="w100 clearfix">
                    <div class="col-xs-12">
                        <form role="form" class="regForm" action="{{ site_url('member/daftar/update') }}" method="POST">
                            {{ $csrf }}
                            <div class="row">
                                <div class="col-xs-12 col-sm-6">
                                    <div class="form-group">
                                        <label>Nama Pertama</label>
                                        <input title="Masukkan Nama Pertama" type="text"
                                               class="form-control" placeholder="Masukkan nama pertama"
                                               name="first_name" required minlength="3" maxlength="50"
                                               value="{{ $user->first_name }}">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <div class="form-group">
                                        <label>Nama Terakhir</label>
                                        <input title="Masukkan Nama Terakhir" type="text"
                                               class="form-control" placeholder="Masukkan nama terakhir"
                                               name="last_name" required minlength="3" maxlength="50"
                                               value="{{ $user->last_name }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input title="Masukkan email" type="email" class="form-control"
                                               placeholder="Masukkan email" name="email" value="{{ $user->email }}"
                                               required>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="width">Nomor HP</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">+62</span>
                                            <input title="Masukkan nomor handphone" class="form-control" type="tel"
                                                   name="phone" placeholder="Masukkan nomor handphone"
                                                   value="{{ substr($user->phone, 3) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ site_url('auth/change_password') }}" class="btn btn-warning"><i class="fa fa-key"></i> Ganti Password</a>
                        </form>
                    </div>
                    <!--/.w100-->
                    {{-- END DATA DIRI --}}

                    {{-- START REKENING --}}
                    <div class="col-lg-12">
                        <h2 class="block-title-2"> Daftar rekening saya</h2>
                    </div>

                    <div class="w100 clearfix">
                        @if(empty($bank_accounts))
                            <div class="col-xs-12 col-sm-6 col-md-4">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><strong>Belum ada data rekening.</strong></h3>
                                    </div>
                                </div>
                            </div>
                        @else
                            @foreach($bank_accounts as $bank_account)
                                <div class="col-xs-12 col-sm-6 col-md-4">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><strong>{{ $bank_account->account_name }}</strong>
                                            </h3>
                                        </div>
                                        <div class="panel-body">
                                            <ul>
                                                <li>
                                                    <span> <strong>Bank</strong> : {{ $bank_account->bank->name }} </span>
                                                </li>
                                                <li>
                                                    <span> <strong>No. Rek</strong> : {{ $bank_account->account_number }} </span>
                                                </li>
                                                <li>
                                                    <span> <strong>Atas Nama</strong> : {{ $bank_account->account_behalf }} </span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="panel-footer panel-footer-address"><a
                                                    href="{{ site_url('member/rekening/sunting/'.$bank_account->id) }}"
                                                    class="btn btn-sm btn-success"> <i
                                                        class="fa fa-edit"> </i> Sunting </a> <a
                                                    class="btn btn-sm btn-danger"
                                                    href="{{ site_url('member/rekening/hapus/'.$bank_account->id) }}"
                                                    onclick="return confirm('Apakah anda yakin?');"> <i
                                                        class="fa fa-minus-circle"></i> Hapus </a></div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <!--/.w100-->

                    <div class="col-lg-12 clearfix">
                        <a class="btn btn-primary" href="{{ site_url('member/rekening/tambah') }}"><i
                                    class="fa fa-plus-circle"></i> Tambah Rekening Baru
                        </a>
                    </div>
                    {{-- END REKENING --}}

                    <div class="col-lg-12">
                        <h2 class="block-title-2"> Daftar alamat saya</h2>
                    </div>

                    <div class="w100 clearfix">
                        @if(empty($addresses))
                            <div class="col-xs-12 col-sm-6 col-md-4">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><strong>Belum ada data alamat.</strong></h3>
                                    </div>
                                </div>
                            </div>
                        @else
                            @foreach($addresses as $address)
                                <div class="col-xs-12 col-sm-6 col-md-4">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><strong>{{ $address->address_name }}</strong></h3>
                                        </div>
                                        <div class="panel-body">
                                            <ul>
                                                <li>
                                                    <span class="address-name"> <strong>{{ $address->owner_first_name.' '.$address->owner_last_name }}</strong></span>
                                                </li>
                                                <li><span class="address-line1"> {{ $address->full_address }} </span>
                                                </li>
                                                <li><span> <strong>Provinsi</strong> : {{ $address->province }} </span>
                                                </li>
                                                <li><span> <strong>Kabupaten / Kota</strong> : {{ $address->regency }} </span>
                                                </li>
                                                <li><span> <strong>Kecamatan</strong> : {{ $address->district }} </span>
                                                </li>
                                                <li><span> <strong>Desa / Kelurahan</strong> : {{ $address->village }} </span>
                                                </li>
                                                <li><span> <strong>No. HP</strong> : {{ $address->phone }} </span></li>
                                            </ul>
                                        </div>
                                        <div class="panel-footer panel-footer-address"><a
                                                    href="{{ site_url('member/alamat/sunting/'.$address->id) }}"
                                                    class="btn btn-sm btn-success"> <i
                                                        class="fa fa-edit"> </i> Sunting </a> <a
                                                    href="{{ site_url('member/alamat/hapus/'.$address->id) }}"
                                                    class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Apakah anda yakin?')"> <i
                                                        class="fa fa-minus-circle"></i> Hapus </a></div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <!--/.w100-->

                    <div class="col-lg-12 clearfix">
                        <a class="btn   btn-primary" href="{{ site_url('member/alamat/tambah') }}"><i
                                    class="fa fa-plus-circle"></i> Tambah Alamat Baru
                        </a>
                    </div>

                    <div class="col-lg-12 clearfix">
                        <ul class="pager">
                            <li class="previous pull-left"><a href="{{ site_url('/') }}"> <i class="fa fa-home"></i> Ke
                                    Beranda </a>
                            </li>
                        </ul>
                    </div>

                </div>
                <!--/row end-->
            </div>
        </div>
        <!--/row-->

        <div style="clear:both"></div>
    </div>
@endsection
