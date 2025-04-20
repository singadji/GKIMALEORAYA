@extends('template')

@section('halaman')

<main id="main">
  <section class="breadcrumbs">
    <br />
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2>{{$page->judul_menu}}</h2>
        </div>

      </div>
    </section>
    <section class="about" data-aos="fade-up">
      <div class="container">
        <div class="row">
          <article class="entry">
            @if($page->dokumen != '' && $page->gambar != '')
            <div class="col-lg-col-lg-12 pt-1 pt-lg-0">
                <h3>{{$page->gambar_cap}}</h3>
                <img class="img-fluid w-100 text-center mb-4" src="{{ asset('images/menu/'.$page->gambar) }}" alt="">
              </div>
              <div class="row"><br></div>
              <div class="col-lg-12 pt-1 pt-lg-0">
              <h3>{{$page->dokumen_cap}}</h3>
              <p><iframe src="{{ asset('files/'.$page->dokumen) }}" align="top" height="620" width="100%" frameborder="0" scrolling="auto"></iframe></p>
            </div>
            @elseif($page->dokumen != '')
              <div class="col-lg-12 pt-1 pt-lg-0">
              <h3>{{$page->dokumen_cap}}</h3>
                <p><iframe src="{{ asset('files/'.$page->dokumen) }}" align="top" height="620" width="100%" frameborder="0" scrolling="auto"></iframe></p>
              </div>
            @elseif($page->gambar != '')
              <div class="col-lg-col-lg-12 pt-1 pt-lg-0">
                <img class="img-fluid w-100 text-center mb-4" src="{{ asset('images/menu/'.$page->gambar) }}" alt="">
              </div>
              <div class="col-lg-12 pt-1 pt-lg-0">
              <p>{!! $page['isi_menu'] !!}</p>
            </div>
            
            @else
            <div class="col-lg-12 pt-1 pt-lg-0">
              <p>{!! $page['isi_menu'] !!}</p>
            </div>
            @endif
          </article>
        </div>

      </div>
    </section>
</main>
@endsection