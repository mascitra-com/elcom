@layout('_layout/reseller/index')
@section('title')Dashboard@endsection
@section('nama-kelurahan')Lumajang@endsection

@section('content')
<!-- WIDGET -->
<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-body">
                @if($reseller->active)
                    <h4>Hi, Reseller Setia Senyum</h4><br>
                    <p>Anda Telah Menjadi Salah Satu Reseller Kami. Fitur Reseller Sedang Kami Bangun. Mohon Menunggu.</p>
                    <p>Saat ini Anda dapat menikmati diskon dari Kami setiap pembelian produk di Senyummedia.co.id</p>
                    <p>Terima Kasih</p>
                    <p>Jumlah Deposit Anda saat ini adalah : <strong>Rp. {{ number_format($reseller->deposit, 0, ',', '.' ) }},-</strong></p>
                    <p>Jumlah Poin Anda saat ini adalah : <strong>Rp. {{ number_format($reseller->point, 0, ',', '.' ) }},-</strong></p>
                @else
                    <h4>Menunggu Persetujuan</h4><br>
                    <p>Saat ini permohonan Anda untuk menjadi reseller kami sedang dalam proses pengecekan. Mohon Menunggu.</p>
                    <p>Terima kasih.</p>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- END WIDGET -->
<!-- CHART -->

<!-- END CHART -->
@endsection