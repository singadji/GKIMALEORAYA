@extends('menu.template')

@section('halaman')

  <div class="page-title" data-aos="fade">
      <div class="container">
        <h1>{{$page->nama_menu}}</h1>
      </div>
  </div>

  <section id="pricing" class="pricing section">
    <div class="container" data-aos="zoom-in" data-aos-delay="100">
      <div class="row g-4">
        <div class="col-lg-12">
          <div class="pricing-item">
          	<div class="post-image ml-0">
							<img src="{{ asset('images/menu/'.$page->gambar) }}"  width="1200px" class="img-fluid img-thumbnail img-thumbnail-no-borders rounded-0" alt=""  />
						</div>
					
						<div class="post-content ml-0">
							<p>{!! $page->isi_menu !!}</p>
						</div>
					</div>
        </div><!-- End Pricing Item -->
      </div>
    </div>
  </section>

@endsection