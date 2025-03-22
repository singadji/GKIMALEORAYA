@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')

@include('layouts.navbars.auth.topnav')

@section('alert-error')
    @if (Session::has('errors'))
        <div class="col-md-12">
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <strong>Oops, terjadi kesalahan. </strong> 
                <ul style="font-size:12px;margin-top:5px;">
                    @foreach ($errors->all() as $error)
                    <li> &nbsp; - {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
@endsection
<div class="container-fluid mt--6">
    <div class="card mb-10">
        <div class="card-header mb-0">
            <h3>{{$subjudul}}</h3>
        </div>
        <div class="">
            <div id="alert">
                @if ($errors->any())
                    <div class="alert alert-danger" style="color:#fff; font-size:10pt">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
        <div class="">
                <div id="alert">
                    @include('includes.alert')
                </div>
            </div>
        <div class="card-body px-0 pt-0 pb-2">
            <div class="card-body">
                <form role="form" method="POST" action="{{ $aksi }}" enctype="multipart/form-data">
                @csrf
                @if(isset($item))
                    @method('PUT')
                @endif
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label" for="">Judul</label>
                                <input class="form-control" type="text" name="judul_artikel" placeholder="mis: Beranda" 
                                @if(isset($item)) value="{{ $item->judul }}" 
                                @else value="{{ old('judul_artikel') }}" @endif required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-control-label" for="">Berita / Kegiatan</label>
                                <select class="form-control select2-hidden-accessible" data-toggle="select" name="kategori" required>
                                    @foreach($kategori as $kategori)
                                        <option value="{{ $kategori->id_kategori }}" 
                                        @if((isset($item)) && ($item->id_kategori == $kategori->id_kategori)) 
                                        selected="selected" @endif>{{ $kategori->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
								<div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Isi</label>
                                        <textarea style="height: 800px" id="editor" name="isi_artikel" required class="form-control"> @if(isset($item)) {{ $item->isi }} @else {{ old('isi') }} @endif</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Foto/ Gambar (<font style="color:red">W: 1172px, H: 648px, 72pixel</font>)</label>
                                        <input type="file" name="gambar" class="form-control" accept="image/jpeg,image/jpg,image/png">
                                        @if(isset($item))
                                            @if($item->gambar)
                                               <img src="{{ asset('images/artikel/'.$item->gambar) }}" alt="" style="width:100%; max-width: 200px;">
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="" class="form-control-label">Publish</label>
                                    <div class="form-check">
                                    <label class="custom-toggle">
                                        <input type="checkbox" name="publish" id="" value="1" @if(isset($item) && $item->publish == '1') checked @endif>
                                        <span class="custom-toggle-slider rounded-circle" data-label-off="Tidak" data-label-on="Ya"></span>
                                    </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="" class="form-control-label">Is Slider</label>
                                    <div class="form-check">
                                    <label class="custom-toggle">
                                        <input type="checkbox" name="isslider" id="" value="1" @if(isset($item) && $item->isslider == '1') checked @endif>
                                        <span class="custom-toggle-slider rounded-circle" data-label-off="Tidak" data-label-on="Ya"></span>
                                    </label>
                                    </div>
                                </div>
                            </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success bg-gradient-success btn-md"> Simpan </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Structure -->

    @include('layouts.footers.auth.footer')
</div>

@endsection
