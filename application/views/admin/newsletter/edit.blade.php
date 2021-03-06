@layout('_layout/dashboard/index')
@section('title')Edit Berita@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <a href="{{ site_url('kategori') }}" class="btn btn-default break-bottom-10"><i
                        class="fa fa-arrow-left"></i> Kembali</a>
            <div class="panel panel-theme">
                <div class="panel-heading">
                    <h3 class="panel-title">Edit Berita Baru</h3>
                </div>
                <div class="panel-body">
                    <form action="{{ site_url('berita/ubah') }}" method="POST" enctype="multipart/form-data">
                        {{ $csrf }}
                        <input type="hidden" name="id" value="{{ $berita->id }}">
                        <div class="form-group">
                            <label for="">Judul</label>
                            {{ form_error('name') }}
                            <input type="text" class="form-control" name="title" placeholder="Judul Berita"
                                   maxlength="255" value="{{ $berita->title }}" required/>
                        </div>
                        <div class="form-group">
                            <label for="">Isi</label>
                            {{ form_error('description') }}
                            <textarea class="form-control content" name="body"
                                      placeholder="Isi Berita" rows="6">{{ $berita->body }}</textarea>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                            <a href="{{ site_url('berita/kirim/'.$berita->id) }}" class="btn btn-success" type="reset"><i class="fa fa-send"></i> Kirim ke Subscriber
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <style>
        .preview {
            width: 150px;
            height: 150px;
            object-fit: cover;
            object-position: center;
        }
    </style>
@endsection

@section('javascript')
    <script>
        // Initialize preview image
        $("[type='file']").change(function () {
            readURL(this);
        });

        // image preview function
        function readURL(input) {

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('.preview').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection