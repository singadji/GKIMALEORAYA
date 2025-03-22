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
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-control-label" for="">Judul</label>
                                <input class="form-control" type="text" name="judul_video" placeholder="" 
                                @if(isset($item)) value="{{ $item->judul_video }}" 
                                @else value="{{ old('judul_video') }}" @endif required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-control-label" for="">Link Youtube</label>
                                <input class="form-control" type="text" name="link_youtube" placeholder="" 
                                @if(isset($item)) value="{{ $item->link_youtube }}" 
                                @else value="{{ old('link_youtube') }}" @endif required>
                            </div>
                        </div>
                            <div class="col-md-4">
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
