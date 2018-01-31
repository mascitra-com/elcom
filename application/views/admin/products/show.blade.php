@layout('_layout/dashboard/index')
@section('title')Detail Produk@endsection

@section('content')
<div class="row">
	<div class="col-xs-12">
		<div class="panel">
			<div class="panel-body">
				<img src="{{base_url('assets/images/products/' . $product->image_1)}}" class="headline" alt="thumbnail">
				<h1 class="title">{{ $product->name }}</h1>
				<span class="label label-primary"><i class="fa fa-clock-o"></i> {{ (!isset($product->category->name)) ? 'Lainnya' : $product->category->name }}</span>
				<span class="label label-success"><i class="fa fa-user"></i> {{ (!isset($product->producer->name)) ? 'Tidak ada Brand' : $product->producer->name }}</span>
				<span class="label label-danger">{{ (is_null($product->discount)) ? 'Tidak ada diskon' : 'Diskon '. $product->discount*100 . '%' }}</span>
				<span class="label label-warning">Stok: {{ $product->stock }}</span>
				<div class="content">
					<h3>Harga asli:  {{ $product->price }}</h3>
					<h3>Harga total (termasuk diskon): <span class="text-red">{{ $product->price-($product->price*$product->discount) }}</span> </h3>
					{{ $product->description }}
				</div>
			</div>
			<div class="panel-footer">
				@if($product->archived == '0')
                    <a href="{{ site_url('produk/arsipkan/'.$product->code) }}" class="btn btn-warning"><i class="fa fa-archive"></i> Arsipkan</a>
                @else
                    <a href="{{ site_url('produk/nonarsipkan/'.$product->code) }}" class="btn btn-success"><i class="fa fa-archive"></i> Non Arsipkan</a>
                @endif
				<button onclick="window.history.back()" class="btn btn-default"><i class="fa fa-arrow-left"></i> kembali</button>
			</div>
		</div>
	</div>
</div>
@endsection

@section('style')
<style>
	.panel-body{
		padding: 30px;
	}

	.headline{
		width: 100%;
		height: 250px;
		object-fit: cover;
		object-position: center;
		margin-bottom: 20px;
	}
	
	.title{
		margin-bottom: 5px;
	}

	.content{
		margin-top: 20px;
	}

	.content > p{
		font-size: 11pt;
		line-height: 28px;
	}
</style>
@endsection