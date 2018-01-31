@layout('_layout/dashboard/index')
@section('title')Batch Diskon Kategori@endsection

@section('content')
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-theme">
			<div class="panel-heading">
				<h3 class="panel-title">Batch Diskon Berdasarkan Kategori</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-12 col-md-6">
						<form action="{{ site_url('diskon/diskon_kategori') }}" method="POST">
							{{$csrf}}
							<div class="form-group">
								<label for="price">Nilai Diskon (kosongi jika ingin meniadakan diskon)</label>
								<div class="input-group">
									<input class="form-control" type="number" name="discount" min="0" placeholder="Nilai Diskon">
									<span class="input-group-addon">%</span>
								</div>
							</div>
							<label>Cari Kategori</label>
							<div class="input-group break-bottom-20">
								<input list="kategori" class="form-control input-cari" placeholder="masukkan kode atau nama kategori" autocomplete="off">
								<datalist id="kategori">
									@foreach($categories as $category)
									<option value="{{ $category->id. '|'.$category->name }}">
										@endforeach
									</datalist>
									<span class="input-group-btn"><button class="btn btn-primary btn-tambah" type="button">Tambah</button></span>
								</div>
								<div class="container-fluid table-responsive table-full">
									<table class="table table-stripped table-pengikut">
										<thead>
											<th class="text-center" width="10%">No.</th>
											<th colspan="2">Nama Kategori</th>
										</thead>
										<tbody></tbody>
									</table>
								</div>
								<div class="break-bottom-30"></div>
								<button class="btn btn-primary" type="submit">Simpan</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	@endsection

	@section('javascript')
	<script type="text/javascript">
		var data = [];
		$(".btn-tambah").click(function(){
			data.push($(".input-cari").val());
			refresh();
			$("input.input-cari").val("").focus();
		});

		$("tbody").delegate('tr>td>[data-index]','click', function(){
			var ind = data.indexOf($(this).data('index'));
			if (ind > -1) {
				data.splice(ind, 1);
			}
			refresh();
		});

		function refresh(){
			$(".table-pengikut > tbody").empty();
			data.forEach(function(item, index){
				var pecah = item.split('|');
				var html = "<tr class='data"+(index+1)+"'><td>"+(index+1)+"</td>";
				html+= "<td><input type='hidden' class='blank' name='category_id[]' value='"+pecah[0]+"' readonly>"+pecah[1]+"</td>";
				html+="<td><button class='btn btn-xs btn-default' data-index='"+(item)+"' type='button'><i class='fa fa-close text-red'></i></button></td></tr>";
				$(".table-pengikut > tbody").append(html);
			});
		}
	</script>
	@endsection