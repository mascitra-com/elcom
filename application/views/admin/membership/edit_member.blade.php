@layout('_layout/dashboard/index')
@section('title')Edit Anggota@endsection

@section('content')
<div class="row">
	<div class="col-xs-12">
		<a href="{{ site_url('membership') }}" class="btn btn-default break-bottom-10"><i class="fa fa-arrow-left"></i> Kembali</a>
		<div class="panel panel-theme">
			<div class="panel-heading">
				<h3 class="panel-title">Tambah Membership Baru</h3>
			</div>
			<div class="panel-body">
				<form action="{{ site_url('membership/update_member') }}" method="POST">
					<input type="hidden" name="id" value="{{ $member->id }}">
					{{ $csrf }}
					<div class="form-group">
						<div class="row">
							<div class="col-xs-12 col-sm-6">
								<label for="">E-mail / Nama Member</label>
								{{ form_error('user') }}
                                <input name="user" list="users" class="form-control" placeholder="Masukkan Email atau Nama Member" value="{{ $member->user_id }}" disabled>
							</div>
							<div class="col-xs-12 col-sm-6">
                                <label for="">Membership</label>
                                {{ form_error('membership_id') }}
                                <select name="membership_id" id="membership_id" class="form-control">
                                    <option value="">Pilih Salah Satu</option>
                                    @foreach($membership as $list)
                                        <option value="{{ $list->id }}" {{ $list->id == $member->membership_id ? 'selected' : '' }}>{{ $list->name }}</option>
                                    @endforeach
                                </select>
                            </div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-xs-12 col-sm-6">
								<label for="">Mulai Aktif</label>
								<input type="date" class="form-control" name="start" value="{{ date('Y-m-d', strtotime($member->start)) }}" required/>
							</div>
							<div class="col-xs-12 col-sm-6">
                                <label for="">Aktif Hingga</label>
                                <input type="date" class="form-control" name="end" value="{{ date('Y-m-d', strtotime($member->end)) }}" required/>

                            </div>
						</div>
					</div>
					<div class="form-group">
						<button class="btn btn-primary" type="submit"><i class="fa fa-send-o"></i> Simpan</button>
						<button class="btn btn-default" type="reset"><i class="fa fa-refresh"></i> bersihkan</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection