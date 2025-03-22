@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@php
    $btn = '';
@endphp

{{-- Pass the $btn variable to the topnav --}}
@include('layouts.navbars.auth.topnav', [
        $btn    = '',
        $page   = 'Dashboard',
        $judul  = 'Content Management',
        $subjudul = '',
        $tombol = $btn,
])

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

<div class="main-content" id="panel">
  <div class="header bg-primary pb-6">
  
  <div class="container-fluid">
    <div class="header-body">
          
      <!-- Card stats -->
      @if(\Auth::user()->role == 'Administrator')
        
      <div class="row">
        <div class="col-xl-3 col-md-6">
          <div class="card card-stats">
            <!-- Card body -->
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0"></h5>
                  <span class="h2 font-weight-bold mb-0"></span>
                </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                    <i class=""></i>
                  </div>
                </div>
              </div>
              <p class="mt-3 mb-0 text-sm">
                <span class="text-nowrap"></span>
              </p>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-md-6">
          <div class="card card-stats">
            <!-- Card body -->
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0"></h5>
                  <span class="h2 font-weight-bold mb-0"></span>
                </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                    <i class=""></i>
                  </div>
                </div>
              </div>
              <p class="mt-3 mb-0 text-sm">
                <span class="text-nowrap"></span>
              </p>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-md-6">
          <div class="card card-stats">
            <!-- Card body -->
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0"></h5>
                  <span class="h2 font-weight-bold mb-0"></span>
                </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                    <i class=""></i>
                  </div>
                </div>
              </div>
              <p class="mt-3 mb-0 text-sm">
                <span class="text-nowrap"></span>
              </p>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-md-6">
          <div class="card card-stats">
            <!-- Card body -->
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0"></h5>
                  <span class="h2 font-weight-bold mb-0"></span>
                </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                    <i class=""></i>
                  </div>
                </div>
              </div>
              <p class="mt-3 mb-0 text-sm">
                <span class="text-nowrap"></span>
              </p>
            </div>
          </div>
        </div>
      </div>
      @endif
    </div>
  </div>
</div>

<!-- Page content -->
<div class="container-fluid mt--6">
  <div class="row">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-body">
          
        </div>
      </div>
    </div>
  </div>
    @include('layouts.footers.auth.footer')
</div>
@endsection
