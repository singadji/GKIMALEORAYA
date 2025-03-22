@extends('menu.template')

@section('halaman')

  <div class="page-title" data-aos="fade">
    <div class="container">
      <h1>{{{$news->judul}}}</h1>
    </div>
  </div>
  
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <section id="blog-posts" class="blog-posts section">
          <div class="container" data-aos="fade-in" data-aos-delay="100">
            <div class="row gy-4">
              <div class="col-lg-12">
                <article>
  		            <div class="post-img">
                    <img src="{{asset('images/artikel/'.$news->gambar)}}" alt="" width="100%" class="img-fluid">
                  </div>
                  <div class="meta-top" style="font-size:10pt">
                    <ul>
                      <li class="d-flex align-items-center"><i class="bi bi-person"></i>{{$news->name}}</li>
                      <li class="d-flex align-items-center"><i class="bi bi-calendar"></i></time>{{date("d-m-Y",strtotime($news->tanggal))}}</li>
                      <li class="d-flex align-items-center"><i class="bi bi-eye"></i>{{ $news->baca }}</li>
                    </ul>
                  </div>
                  <div class="content">
                    <p>
                        {!! $news->isi !!}
                    </p>
                  </div>
                </article>
              </div>
  	        </div>
          </div>
        </section>
      </div>
      <hr>
      <section id="services" class="services section">
          <div class="container section-title" data-aos="fade-up">
          <h2 class="font-weight-normal mb-3 mt-3 line-height-3"><strong class="">Berita</strong> Lainnya </h2>
            </div>
            <div class="container">
              <div class="row gy-4">
              @foreach($lain as $beritas)
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
@endsection
