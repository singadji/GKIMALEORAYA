@extends('layouts.app')

@section('content')
    <main class="main-content main-content-bg mt-0">
        <div class="page-header min-vh-100" style="background-image: ./images/backg.png'); background-color:#009EFF;">
            <span class="mask bg-gradient-dark opacity-6"></span>
            <div class="container">
                <div class="row mt-lg-n10 mt-md-n11 mt-n10 justify-content-center">
                    <div class="col-xl-5 col-lg-7 col-md-7 mx-auto">
                        <div class="card mt-5">
                            <div class="card-header pb-0 text-start">
                                <img src="{{ asset('assets/img/logo.png') }}" class="" alt="main_logo" width="100%" />
                                <p></p>
                                <br>
                                <h3 class="font-weight-bolder">Selamat Datang</h3>
                                <p class="mb-0">Masukan email dan password untuk sign in. </p>
                            </div>
                            <div class="card-body">
                                <form role="form" method="POST" action="{{ route('login') }}">
                                    @csrf
                                    @method('post')
                                    <div class="flex flex-col mb-3">
                                        <input type="email" name="email" class="form-control form-control-md" value="{{ old('email')}}" placeholder="email" aria-label="Email"> @error('email') <p class="text-danger text-xs pt-1"> {{$message}} </p>@enderror </div>
                                    <div class="flex flex-col mb-3">
                                        <input type="password" name="password" class="form-control form-control-md" aria-label="Password" placeholder="password">
                                        @error('password') <p class="text-danger text-xs pt-1"> {{$message}} </p>@enderror
                                    </div>
                                
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Sign in</button>
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
@endsection