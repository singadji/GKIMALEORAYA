@extends('menu.template')

@section('halaman')

<div class="page-title" data-aos="fade">
      <div class="container">
        <h1>{{$title}}</h1>
      </div>
    </div>

	<section class="about" data-aos="fade-up">
	<div data-ref="mixitup-target" class="container">
		<div class="row lightbox" data-ref="mixitup-container">
			@foreach($video as $videos)
			<div class="col-lg-6 pb-5">
				<div class="appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="0">
					<div class="thumb-info thumb-info-no-zoom thumb-info-custom mb-5 text-center">
						<div class="thumb-info-side-image-wrapper p-0">
							<div class="embed-responsive-borders">
								<div class="embed-responsive embed-responsive-16by9">
									<iframe src="{!! $videos->link_youtube !!}" width="100%" height="400px"></iframe>
								</div>
							</div>
						</div>
						<h5 class="mb-0">{{$videos->judul_video}}</h5S>		
					</div>
				</div>
			</div>
			@endforeach
		</div>
	</div>
	</section>

	
@endsection