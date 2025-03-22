
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
                                <label class="form-control-label" for="">Nama Menu</label>
                                <input class="form-control" type="text" name="nama_menu" placeholder="mis: Beranda" @if(isset($item)) value="{{ $item->nama_menu }}" @else value="{{ old('nama_menu') }}" @endif required>
                            </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="">Parent</label>
                                    <select class="form-control select2-hidden-accessible" data-toggle="select" data-select2-id="1" tabindex="-1" aria-hidden="true" name="parent" required>
                                        <option value="0" class="">-</option>
                                            @foreach($parent as $parent)
                                                <option value="{{$parent->id_menu}}" @if((isset($item)) && ($item->id_parent == $parent->id_menu)) selected="selected" @endif>{{$parent->nama_menu}}</option>
                                            @endforeach
                                        </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="form-control-label">Link</label>
                                    <input type="text" name="link_menu" class="form-control" id="" maxlength="100" size="100" placeholder="jika file: public/files/namafile atau menu-1" @if(isset($item)) value="{{ $item->link_menu }}" @else value="{{ old('link_menu') }}" @endif>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="form-control-label">Posisi</label>
                                    <input type="number" name="posisi" class="form-control" id="" maxlength="100" size="100" placeholder="Urutan menu" @if(isset($item)) value="{{ $item->posisi }}" @else value="{{ old('posisi') }}" @endif required>
                                </div>
                            </div>
                            
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="" class="form-control-label">Isi Menu</label>
                                    <textarea style="height: 600px" id="editor" name="isi_menu" class="form-control ckeditor"> @if(isset($item)) {{ $item->isi_menu }} @else {{ old('isi_menu') }} @endif</textarea>
                                </div>
                            </div>
                                        
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" class="form-control-label">Gambar</label>
                                    <input type="file" name="images" class="form-control" accept="image/gif,image/jpeg,image/jpg,image/png"> 
                                    @if(isset($item))
                                        @if($item->gambar)
                                            <img src="{{ asset('images/menu/'.$item->gambar) }}" alt="" style="width:100%; max-width: 200px;">
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" class="form-control-label">Video</label>
                                    <input type="file" name="video" class="form-control" accept="video/mp4, video/mov">
                                    @if(isset($item))
                                        @if($item->video)
                                            {{ $item->video }}
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" class="form-control-label">File</label>
                                    <input type="file" name="dokumen" class="form-control" accept="application/msword, application/pdf">
                                    @if(isset($item))
                                        @if($item->dokumen)
                                            {{ $item->dokumen }}
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" class="form-control-label">Link Youtube</label>
                                    <input class="form-control" type="text" name="link_youtube" placeholder="Link embaded youtube" @if(isset($item)) value="{{ $item->link_youtube }}" @else value="{{ old('link_youtube') }}" @endif>&nbsp;
                                    
                                </div>
                            </div>
                            
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="" class="form-control-label">Aktif</label>
                                    <div class="form-check">
                                    <label class="custom-toggle">
                                        <input type="checkbox" name="aktif" id="" value="Y"<?php if(isset($item)&& $item->publish == 'Y') echo 'checked';?>>
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
        @include('layouts.footers.auth.footer')
    </div>
@endsection