
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
                <h3>Aktivasi Fitur MFA</h3>
            </div>
            <br>
            <div class="">
                <div id="alert">
                    @include('includes.alert')
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="card-body row">
                    <div class="col-md-2">{!! $QRImage !!}</div> 
                    <div class="col-md-4">
                        Scan QR code di samping ini menggunakan aplikasi Google Authenticator atau aplikasi serupa.
                        <form action="{{ route('mfa.verify') }}" method="POST">
                            @csrf
                            <br>
                            <div class="form-group">
                                <label for="otp">Masukkan kode OTP dari HP Anda:</label>
                                <input type="text" name="otp" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Verifikasi</button>
                        </form>
                    </div> 
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection