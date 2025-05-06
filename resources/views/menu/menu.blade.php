@extends('menu.template')

@section('halaman')

@include('includes.header')

    <section id="about" class="section about">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">
          <div class="col-lg-6 order-1 order-lg-2">
            <img src="assets/img/about.jpg" class="img-fluid" alt="">
          </div>
          <div class="col-lg-6 order-2 order-lg-1 content">
            <h3>{{ $page->nama_menu }}</h3>
            <p>
              {!! $page->isi_menu !!}
            </p>
          </div>
        </div>
      </div>
    </section><!-- /About Section -->
@endsection