
@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')

@include('layouts.navbars.auth.topnav')

    @section('alert-error')

        @if (Session::has('errors'))
            <div class="col-md-12">
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
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
                    @include('includes.alert')
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="card-body">
                    <form role="form" method="POST" action="{{ $aksi }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Nama Website</label>
                                        <div class="input-group input-group-merge">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-building"></i></span>
                                            </div>
                                            <input class="form-control" placeholder="Nama Website" type="text" name="nama_perusahaan" value="{{ $item->nama_website }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Alamat Website (URL)</label>
                                        <div class="input-group input-group-merge">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-globe-americas"></i></span>
                                            </div>
                                            <input class="form-control" placeholder="URL" type="url" name="url" value="{{ $item->url }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Email</label>
                                        <div class="input-group input-group-merge">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            </div>
                                            <input class="form-control" placeholder="Email address" type="email" name="email" value="{{ $item->email }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Alamat</label>
                                        <div class="input-group input-group-merge">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-map-marker"></i></span>
                                            </div>
                                            <input class="form-control" placeholder="Nama Perusahaan" type="text" name="alamat" value="{{ $item->alamat }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">No. Telepon</label>
                                        <div class="input-group input-group-merge">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            </div>
                                            <input class="form-control" placeholder="" type="text" name="telepon" value="{{ $item->no_telp }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Facebook</label>
                                        <div class="input-group input-group-merge">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fab fa-facebook"></i></span>
                                            </div>
                                            <input class="form-control" placeholder="" type="text" name="facebook" value="{{ $item->facebook }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Instagram</label>
                                        <div class="input-group input-group-merge">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fab fa-instagram"></i></span>
                                            </div>
                                            <input class="form-control" placeholder="" type="text" name="instagram" value="{{ $item->instagram }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Youtube</label>
                                        <div class="input-group input-group-merge">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fab fa-youtube"></i></span>
                                            </div>
                                            <input class="form-control" placeholder="" type="text" name="youtube" value="{{ $item->youtube }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Tag Line</label>
                                        <input class="form-control" type="text" name="tag_line" placeholder=""  value="{{ $item->moto }}" >
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Deskripsi</label>
                                        <input class="form-control" type="text" name="deskripsi" placeholder=""  value="{{ $item->meta_deskripsi }}" >
                                    </div>
                                </div>
                                
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Keyword</label>
                                        <input class="form-control" type="text" name="keyword" placeholder=""  value="{{ $item->meta_keyword }}" >
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Profil</label>
                                        <textarea class="form-control" id="editor" name="profil" placeholder="">{{ $item->profil }}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Logo</label>
                                        <input type="file" name="logo"  class="form-control" accept="image/gif,image/jpeg,image/jpg,image/png">
                                    </div>
                                    <div class="col-sm-2">
                                        <img src="{{ asset('assets/img/') }}/<?=$item->logo?>" width="150">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Favicon</label>
                                        <input type="file" name="favicon"  class="form-control" accept="image/png">
                                    </div>
                                    <div class="col-sm-2">
                                        <img src="{{ asset('assets/img/') }}/<?=$item->favicon?>" width="32">
                                    </div>
                                </div>                  
                        </div>
                        <br>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success bg-gradient-success btn-md"> Simpan </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection