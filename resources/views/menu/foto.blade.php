@extends('menu.template')
	@section('halaman')
	<div class="page-title" data-aos="fade">
      <div class="container">
        <h1>{{$title}}</h1>
      </div>
    </div>
	<section id="portfolio" class="portfolio section">
      <div class="container">
        <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">
          <ul class="portfolio-filters isotope-filters" data-aos="fade-up" data-aos-delay="100">
            <li data-filter="*" class="filter-active">All</li>
			@foreach($album as $album)
            	<li data-filter=".filter-{{$album->slug}}">{{$album->nama_album}}</li>
			@endforeach
          </ul><!-- End Portfolio Filters -->
          <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">
			@foreach($foto as $fotos)
            <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-{{$fotos->slug}}">
              <div class="portfolio-content h-100">
                <img src="{{asset('images/foto/'.$fotos->foto)}}" class="img-fluid" alt="">
                <div class="portfolio-info">
                  <a href="{{asset('images/foto/'.$fotos->foto)}}" title="{{$fotos->judul_foto}}" data-gallery="portfolio-gallery-{{$fotos->slug}}" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                </div>
              </div>
            </div><!-- End Portfolio Item -->
			@endforeach
          </div><!-- End Portfolio Container -->
        </div>
      </div>
    </section><!-- /Portfolio Section -->
@endsection