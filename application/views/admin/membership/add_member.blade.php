@layout('_layout/dashboard/index')
@section('title')Tambah Anggota@endsection

@section('content')
<div class="row">
	<div class="col-xs-12">
		<a href="{{ site_url('membership') }}" class="btn btn-default break-bottom-10"><i class="fa fa-arrow-left"></i> Kembali</a>
		<div class="panel panel-theme">
			<div class="panel-heading">
				<h3 class="panel-title">Tambah Membership Baru</h3>
			</div>
			<div class="panel-body">
				<form action="{{ site_url('membership/store_member') }}" method="POST">
					{{ $csrf }}
					<div class="form-group">
						<div class="row">
							<div class="col-xs-12 col-sm-6">
								<label for="">E-mail / Nama Member</label>
								{{ form_error('name') }}
                                <input name="user" list="users" class="form-control" placeholder="Masukkan Email atau Nama Member" autocomplete="off">
                                <datalist id="users">
                                    @foreach($users as $user)
                                        <option value="{{ $user->email. ' | '.$user->first_name . ' ' . $user->last_name}}">
                                    @endforeach
                                </datalist>
							</div>
							<div class="col-xs-12 col-sm-6">
                                <label for="">Membership</label>
                                {{ form_error('membership') }}
                                <select name="membership_id" id="membership_id" class="form-control">
                                    <option value="">Pilih Salah Satu</option>
                                    @foreach($membership as $list)
                                        <option value="{{ $list->id }}">{{ $list->name }}</option>
                                    @endforeach
                                </select>
                            </div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-xs-12 col-sm-6">
								<label for="">Mulai Aktif</label>
								{{ form_error('name') }}
								<input type="date" class="form-control" name="start" required/>
							</div>
							<div class="col-xs-12 col-sm-6">
                                <label for="">Aktif Hingga</label>
                                {{ form_error('membership') }}
                                <input type="date" class="form-control" name="end" required/>

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