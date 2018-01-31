<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Daftar Pesanan</title>
    <link rel="stylesheet" href="http://senyummedia.co.id/assets/plugins/bootstrap/css/bootstrap.min.css">
    <style>
        @media print{@page {size:landscape;}}
    </style>
</head>
<body>

<table class="table table-bordered">
    <thead>
    <tr>
        <th class="text-center">NO.</th>
        <th>KODE PESANAN</th>
        <th>PEMBELI</th>
        <th class="text-center">TGL PESAN</th>
        <th class="text-center">TGL VERIFIKASI</th>
        <th class="text-center">TGL DIKIRIM</th>
        <th class="text-center">TGL DITERIMA</th>
        <th class="text-center">ONGKIR</th>
        <th class="text-center">TOTAL PEMBAYARAN</th>
        <th class="text-center">ALAMAT PENGIRIMAN</th>
        <th class="text-center">METODE PEMBAYARAN</th>
        <th class="text-center">MEMBERSHIP</th>
        <th class="text-center">RESELLER</th>
        <th class="text-center">STATUS</th>
    </tr>
    </thead>
    <tbody>
    @if(is_null($orders) || empty($orders))
        <td colspan="6" class="text-center">Belum ada data Pemesanan</td>
    @else
        <?php $i=$this->uri->segment('4') + 1; ?>
        @foreach($orders as $data)
            <tr>
                <td class="text-center">{{$i++}}</td>
                <td>{{$data->id}}</td>
                <td>{{$data->member->first_name.' '.$data->member->last_name}}</td>
                <td class="text-center">{{ $data->created_at ? date("d/m/Y", strtotime($data->created_at)) : '-'}}</td>
                <td class="text-center">{{ $data->verified_at ? date("d/m/Y", strtotime($data->verified_at)) : '-'}}</td>
                <td class="text-center">-</td>
                <td class="text-center">-</td>
                <td class="text-right text-nowrap">Rp. {{ number_format($data->ship_price, 0, ',', '.') }}</td>
                <td class="text-right text-nowrap">Rp. {{ number_format($data->total_all, 0, ',', '.') }}</td>
                <td class="text-right">{{ $data->ship_address .', '. $data->ship_village .', '. $data->ship_district  }}</td>
                <td class="text-right">Kirim via {{ $data->senyum_bank_account->bank->name }}</td>
                <td class="text-center">{{ isset($data->member->users_membership[0]->membership[0]) ? $data->member->users_membership[0]->membership[0]->name: '-'}}</td>
                <td class="text-center">{{ $data->member->reseller == '1' ? 'Ya' : '-' }}</td>
                <td class="text-center">{{($data->status == '2') ? 'Terbayar' : ''}}{{($data->status == '3') ? 'Dikirim' : ''}}{{($data->status == '4') ? 'Diterima' : ''}}</td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>

<script>
    window.print();
</script>
</body>
</html>