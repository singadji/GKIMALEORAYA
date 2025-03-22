<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
  

  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  <!-- Icons -->
  <link rel="stylesheet" href="{{ asset('argon/css/nucleo.css') }}" type="text/css">
  <link rel="stylesheet" href="{{ asset('argon/css/all.min.css') }}" type="text/css">
  <link rel="stylesheet" href="{{ asset('argon/css/fontawesome.min.css') }}" type="text/css">

  <link href="{{asset('argon/css/docs-soft.css') }}" rel="stylesheet" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">

<link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
<link href="{{ asset('assets/css/theme.css') }}" rel="stylesheet">

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>


<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<link rel="stylesheet" href="{{ asset('argon/plugins/custom/datatables/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('argon/plugins/custom/datatables/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('argon/plugins/custom/datatables/select.bootstrap4.min.css') }}">

<link rel="stylesheet" href="{{ asset('argon/plugins/custom/datatables/select2.min.css') }}">

  <link id="pagestyle" href="{{ asset('argon/css/argon-dashboard.css') }}" rel="stylesheet" />
</head>
<body>
    <main class="main-content main-content-bg mt-0">
        <div class="page-header min-vh-100" style="background-color:#92278f;">
            <span class="mask bg-gradient-dark opacity-6">
            @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
            </span>
            <div class="container">
                <div class="row mt-lg-n10 mt-md-n11 mt-n10 justify-content-center">
                    <div class="col-xl-5 col-lg-7 col-md-7 mx-auto">
                        <div class="card mt-5">
                            <div class="card-header pb-0 text-start">
                                <img src="{{ asset('assets/img/logo.png') }}" class="" alt="main_logo" width="100%" />
                                <p></p>
                                <br>
                                <h3 class="font-weight-bolder">Verifikasi OTP
                                </h3>
                                <p class="mb-0">Demi keamanan silahkan gunakan OTP pada perangkat HP Anda.</p>
                            </div>
                            <div class="card-body">
                                <form role="form" method="POST" action="{{ route('mfa.verify.post') }}">
                                    @csrf
                                    @method('post')
                                    <div class="flex flex-col mb-3">
                                    <label for="otp">Masukkan kode OTP:</label>
                                        <input type="texst" name="otp" class="form-control form-control-lg" id="otp" placeholder="OTP"></div>
                                    
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Verifikasi</button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                <p class="mb-4 text-sm mx-auto">
                                  
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
