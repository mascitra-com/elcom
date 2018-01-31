@layout('_layout/dashboard/index')
@section('title')Detail Brand@endsection

@section('content')
<div class="row">
	<div class="col-xs-12">
		<a href="{{ site_url('Produsen') }}" class="btn btn-default break-bottom-10"><i class="fa fa-arrow-left"></i> Kembali</a>

		<div class="panel">
			<div class="panel-body">
				<img src="{{base_url('assets/images/producers/'.$producer->image)}}" class="headline" alt="thumbnail">
				<h1 class="title">{{ $producer->name }}</h1> 
				<div class="content"> 
					{{ $producer->description }}
				</div>
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