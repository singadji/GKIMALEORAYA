@extends('template')

@section('halaman')

<main id="main">
<section class="breadcrumbs">
<br />
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Kontak Kami</h2>
        </div>

      </div>
    </section><!-- End Contact Section -->

    <!-- ======= Contact Section ======= -->
    <div class="map-section">
      <iframe style="border:0; width: 100%; height: 350px;" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15926.742007849154!2d128.181131!3d-3.6589410000000004!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2d6ce8c91be99a41%3A0xf2f29b4736791b0e!2sPoliteknik%20Negeri%20Ambon!5e0!3m2!1sid!2sid!4v1706324409648!5m2!1sid!2sid" frameborder="0" allowfullscreen></iframe>
    </div>

    <section id="contact" class="contact">
      <div class="container">

        <div class="row justify-content-center" data-aos="fade-up">

          <div class="col-lg-10">

            <div class="info-wrap">
            <div class="row">
              <div class="col-md-12">
                <div class="info-box">
                  <i class="bx bx-map"></i>
                  <h3>Alamat PPID Politeknik Negeri Ambon</h3>
                  <p>{{$identitas->alamat}}</p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="info-box">
                  <i class="bx bx-envelope"></i>
                  <h3>Email</h3>
                  <p>{{$identitas->email}}</p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="info-box">
                  <i class="bx bx-phone-call"></i>
                  <h3>Telepon</h3>
                  <p>{{$identitas->no_telp}}</p>
                </div>
              </div>
            </div>
            </div>

          </div>

        </div>

        <div class="row mt-5 justify-content-center" data-aos="fade-up">
          <div class="col-lg-10">
            <div class="info-wrap">
              @if ($message = Session::get('success'))
                          <div class="alert alert-success  alert-dismissible">
                              <button type="button" class="close" data-dismiss="alert">x</button>  
                              <strong>{{ $message }}</strong>
                          </div>
                      @endif
              <form action="" method="POST" role="form" class="php-email-form">
              @csrf
                <div class="row">
                  <div class="col-md-6 form-group">
                    <input type="text" name="name" class="form-control" id="name" placeholder="Nama" required>
                  </div>
                  <div class="col-md-6 form-group mt-3 mt-md-0">
                    <input type="text" class="form-control" name="telepon" id="telepon" placeholder="No. Telepon/HP" required>
                  </div>
                </div>
                <div class="form-group mt-3">
                  <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
                </div>
                <div class="form-group mt-3">
                  <input type="text" class="form-control" name="subject" id="subject" placeholder="Topik" required>
                </div>
                <div class="form-group mt-3">
                  <textarea class="form-control" name="message" rows="5" placeholder="Pesan" required></textarea>
                </div>
                <div class="my-3">
                  <div class="loading">Loading</div>
                  <div class="error-message"></div>
                  <div class="sent-message">Your message has been sent. Thank you!</div>
                </div>
                <div class="text-center"><button type="submit">Kirim</button></div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section><!-- End Contact Section -->
</main>

@endsection