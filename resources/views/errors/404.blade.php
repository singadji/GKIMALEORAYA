@extends('menu.template')
@section('halaman')
    <div class="page-header min-vh-100 d-flex align-items-center justify-content-center" 
         style="background-image: url('{{ asset('img/404.svg') }}'); 
                background-repeat: no-repeat; 
                background-position: center; 
                background-size: cover; 
                background-color: #fff;">
                
        <div class="container text-center">
            <h1 class="display-1 text-bolder text-primary">404</h1>
            <p class="">Oops! The page you're looking for doesn't exist :(.</p>
            <a href="{{ url('./home') }}" class="btn btn-primary mt-4">Return to Homepage</a>
        </div>
    </div>

@endsection