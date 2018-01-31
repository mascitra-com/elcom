@layout('_layout/dashboard/index')
@section('title')Pengajuan Deposit@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-theme">
                <div class="panel-heading">
                    <h3 class="panel-title pull-left">Daftar Pengajuan</h3>
                    <div class="clearfix"></div>
                </div>

                <div align="right">
                    <div class="form-group col-sm-4" align="left"><br>
                        <select onChange="window.location.href=this.value" name="row" id="row">
                            <option {{ ($row == 20) ? 'selected' : '' }} value="<?php echo site_url('membership/index/20'); ?>">
                                20
                            </option>
                            <option {{ ($row == 50) ? 'selected' : '' }} value="<?php echo site_url('membership/index/50'); ?>">
                                50
                            </option>
                            <option {{ ($row == 100) ? 'selected' : '' }} value="<?php echo site_url('membership/index/100'); ?>">
                                100
                            </option>
                        </select>
                        <label for="row"> Menampilkan <b><?php echo $row; ?></b> dari <b><?php echo $jumlah_data ?></b>
                            data</label>
                    </div>
                    <div class="form-group col-sm-8" style="margin-bottom: -38px;top:43px;" align="right"><br>
                        <?php
                        //					echo $paginasi;
                        ?>
                    </div>
                </div>

                <div class="panel-body table-responsive table-full">
                    <table class="table table-hover table-striped table-bordered">
                        <thead>
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th>Nama Reseller</th>
                            <th>E-mail</th>
                            <th>Dari Rekening</th>
                            <th>Atas Nama</th>
                            <th>Dari Bank</th>
                            <th width="20%" class="text-center">Nominal</th>
                            <th class="text-center" width="15%">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>

                        @if(is_null($resellers) || empty($resellers))
                            <td colspan="7" class="text-center">Belum ada Data Membership</td>
                        @else
                            <?php $i=$this->uri->segment('4') + 1; ?>
                            @foreach($resellers as $list)
                                <tr>
                                    <td class="text-center">{{$i++}}</td>
                                    <td>{{ $list->user_first_name . ' ' . $list->user_last_name }}</td>
                                    <td>{{ $list->email }}</td>
                                    <td>{{ $list->account_number }}</td>
                                    <td>{{ $list->account_name }}</td>
                                    <td>{{ $list->bank_name }}</td>
                                    <td class="text-center">{{ $list->nominal ? 'Rp. ' . number_format($list->nominal, 0, ',', '.') : '-'}}</td>
                                    <td class="text-center">
                                        @if(is_null($list->status))
                                            <a href="{{ base_url('reseller/terima_deposit/'.$list->id) }}"
                                               class="btn btn-xs btn-default" title="Terima"><i
                                                        class="fa fa-check"></i></a>
                                            <a href="{{ base_url('reseller/tolak_deposit/'.$list->id) }}"
                                               class="btn btn-xs btn-default" title="Tolak"><i
                                                        class="fa fa-close"></i></a>
                                        @else
                                            @if($list->status == 1)
                                                Di Terima
                                            @else
                                                Di Tolak
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>

                <div class="panel-footer" style="padding: 10px 25px;">
                    <div align="right">
                        <div class="form-group" align="left"><br><br>
                            <select onChange="window.location.href=this.value" name="row" id="row">
                                <option {{ ($row == 20) ? 'selected' : '' }} value="<?php echo site_url('membership/index/20'); ?>">
                                    20
                                </option>
                                <option {{ ($row == 50) ? 'selected' : '' }} value="<?php echo site_url('membership/index/50'); ?>">
                                    50
                                </option>
                                <option {{ ($row == 100) ? 'selected' : '' }} value="<?php echo site_url('membership/index/100'); ?>">
                                    100
                                </option>
                            </select>
                            <label for="row"> Menampilkan <b><?php echo $row; ?></b> dari
                                <b><?php echo $jumlah_data ?></b> data</label>
                        </div>
                        <?php
                        //					echo $paginasi;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <style>
        .label {
            display: block;
            width: 100%;
            padding: 8px;
        }

        .btn-xxs {
            padding: 0 5px;
        }

        .pager {
            margin-top: 0;
            margin-bottom: 0;
        }
    </style>
@endsection