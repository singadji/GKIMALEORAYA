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
                <form role="form" method="POST" action="" enctype="multipart/form-data">
                @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label" for="">Nama Lengkap</label>
                                <input class="form-control" type="text" name="nama" placeholder="" 
                                @if(isset($item)) value="{{ $item->name }}" 
                                @else value="{{ old('nama') }}" @endif required disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label" for="">Email</label>
                                <input class="form-control" type="email" name="email" placeholder="" 
                                @if(isset($item)) value="{{ $item->email }}" 
                                @else value="{{ old('email') }}" @endif required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label" for="">Password <font style="color:red; font-size:9pt">(minimal 8 karakter, terdiri dari angka dan huruf kapital)</font></label>
                                <input class="form-control" type="password" name="password" id="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" placeholder="" 
                                @if(isset($item)) value="" 
                                @else value="{{ old('password') }}" @endif>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label" for="">Konfirmasi Password</label>
                                <input class="form-control" type="password" id="confirm_password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" name="confirm_password" placeholder="" 
                                @if(isset($item)) value="" 
                                @else value="{{ old('password1') }}" @endif>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label" for="">Role</label>
                                <select class="form-control select2-hidden-accessible" data-toggle="select" name="role" @if(isset($item)) disabled @endif>
                                    <option @if(isset($item) && $item->role == 'Administrator') selected @endif value="Administrator">Administrator </option>
                                    <option @if(isset($item) && $item->role == 'Pangan') selected @endif value="Pangan">Pangan</option>
                                    <option @if(isset($item) && $item->role == 'Pertanian') selected @endif value="Pertanian">Pertanian</option>
								</select>
                            </div>
                        </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="" class="form-control-label">Publish</label>
                                    <div class="form-check">
                                    <label class="custom-toggle">
                                        <input type="checkbox" name="publish" id="" value="Y" @if(isset($item) && $item->aktif == 'Y') checked @endif disabled>
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
<script>
var password = document.getElementById("password")
  , confirm_password = document.getElementById("confirm_password");

function validatePassword(){
  if(password.value != confirm_password.value) {
    confirm_password.setCustomValidity("Password tidak sama.");
  } else {
    confirm_password.setCustomValidity('');
  }
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;
</script>

@endsection
