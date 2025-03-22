@extends('menu.template')

@section('halaman')

	<div class="page-title" data-aos="fade">
      <div class="container">
        <h1><strong class="">Berita</strong> dan  <strong class="">Kegiatan</strong></h1>
        <p>Berita dan Kegiatan Dinas Pertanian Kabupaten Tangerang</p>
      </div>
    </div>

	<div class="container">
      <div class="row">
        <div class="col-lg-12">
          <!-- Blog Posts Section -->
          <section id="blog-posts" class="blog-posts section">
            <div class="container" data-aos="fade-in" data-aos-delay="100">
              <div class="row gy-4">
			  @foreach($berita as $beritas)
                <div class="col-lg-12">
                  <article>
					<a href="{{asset('berita-kegiatan/'.$beritas->id_berita)}}">
                    <div class="post-img">
                      <img src="{{asset('images/artikel/'.$beritas->gambar)}}" alt="" width="100%" class="img-fluid">
                    </div>
                    <h2 class="title">
                      {{$beritas->judul}}
                    </h2>
					</a>
                    <div class="meta-top" style="font-size:10pt">
                      <ul>
                        <li class="d-flex align-items-center"><i class="bi bi-person"></i>{{$beritas->name}}</li>
                        <li class="d-flex align-items-center"><i class="bi bi-calendar"></i></time>{{date("d-m-Y",strtotime($beritas->tanggal))}}</li>
                        <li class="d-flex align-items-center"><i class="bi bi-eye"></i>{{ $beritas->baca }}</li>
                      </ul>
                    </div>

                    <div class="content">
                      <p>
					  <?=substr(strip_tags($beritas->isi), 0, 200)?>[...]
                      </p>
                    </div>
                  </article>
                </div>
				@endforeach
              </div><!-- End blog posts list -->
            </div>
          </section><!-- /Blog Posts Section -->
          <section id="blog-pagination" class="blog-pagination section">
            <div class="container">
              <div class="d-flex justify-content-center">
			  <div class="col pagination float-right">
				<p style="text-align: right; text-right: inter-word;">	{{ $berita->links(('pagination::bootstrap-4')) }}</p>
			</div>
              </div>
            </div>
          </section><!-- /Blog Pagination Section -->
        </div>
        <hr>
        </section>

        <section id="services" class="services section">
          <div class="container section-title" data-aos="fade-up">
          <h2 class="font-weight-normal mb-3 mt-3 line-height-3"><strong class="">Berita</strong> Lainnya </h2>
            </div>
            <div class="container">
              <div class="row gy-4">
              @foreach($beritabaru as $beritas)
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                  <div class="service-item  position-relative">
                    <div class="image">
                      <i class=""><img src="{{asset('images/artikel/'.$beritas->gambar)}}" class="img-fluid hover-effect-2 mb-3" alt="" /></i>
                    </div>
                    <a href="{{asset('berita-kegiatan/'.$beritas->id_berita)}}" class="stretched-link">
                      <h3>{{$beritas->judul}}</h3>
                    </a>
                    <div class="meta-top" style="font-size:10pt;color:#777">
                      <span><i class="bi bi-person"></i> {{$beritas->name}} </span> | 
              <span><i class="bi bi-calendar "></i> {{date("d-m-Y",strtotime($beritas->tanggal))}}</span> | 
              <span><i class="bi bi-folder"></i> {{$beritas->nama_kategori}}</span> |
              <span><i class="bi bi-eye"></i> {{ $beritas->baca }}</span>
              </div>
                  </div>
                </div>
              @endforeach
              </div>
            </div>
          </section>
            
          </div>
        </div>
      </div>
    </div>

@endsection
