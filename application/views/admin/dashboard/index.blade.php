@layout('_layout/dashboard/index')
@section('title')Dashboard@endsection
@section('nama-kelurahan')Lumajang@endsection

@section('content')
<!-- WIDGET -->
<div class="row">
    <div class="col-xs-6">
        <div class="panel panel-default panel-widget">
            <div class="panel-body">
                <h4>Member</h4>
                <div class="break-5">{{$members}} Terdaftar</div>
            </div>
        </div>
    </div>
    <div class="col-xs-6">
        <div class="panel panel-default panel-widget">
            <div class="panel-body">
                <h4>Produk</h4>
                <div class="break-5">{{ $boughted_products }} Dibeli</div>
            </div>
        </div>
    </div>
</div>
<!-- END WIDGET -->
<!-- CHART -->

<!-- END CHART -->
@endsection