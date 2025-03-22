@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Photo slider Management'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4 card-header">
				@if ($errors->any())
                <div class="alert alert-danger" style="color:#fff; font-size:10pt">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form role="form" method="POST" @if(isset($slider)) action="{{ route('admin-slider.update', $slider->uuid) }}" @else action="{{ route('admin-slider.store') }}" @endif enctype="multipart/form-data">
                        @csrf
                        @if(isset($slider))
                        @method('PUT')
                        @endif
					<div class=" pb-0 p-3">
                        <div class="row">
                            <div class="d-flex align-items-center">
                                <h6 class="mb-0">Add New Image Slider</h6>
								<button type="submit" class="btn bg-gradient-success shadow  btn-sm ms-auto">Save</button>&nbsp;
                                <a class="btn bg-gradient-secondary shadow  btn-sm" href="{{ URL::previous() }}">Batal</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Judul Slider (<font style="color:red;"><em>Boleh dikosongkan</em></font>)</label>
                                        <input class="form-control" type="text" name="judul" placeholder="mis: Kegiatan Siswa" @if(isset($slider)) value="{{ $slider->judul }}" @else value="{{ old('judul') }}" @endif >
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Foto (<font style="color:red;"><em>Ekstensi yang diperbolehkan .png | .jpg | .jpeg</em></font>)</label>
                                        <input type="file" name="gambar" id="chooseFile" accept="image/gif,image/jpeg,image/jpg,image/png" class="form-control" />
                                        <?php
                                            if(isset($slider)) {
                                                if($slider->gambar){
                                                ?>
                                                <img src="{{asset('images/banner/'.$slider->gambar)}}" alt="" style="width:100%; max-width: 100px;">
                                            <?php
                                                }
                                            }
                                        ?> 
                                    </div>
                                </div>
								<style>
									.imgGallery img {
									padding: 8px;
									max-width: 100px;
									}
								</style>
								<div class="imgGallery">

								</div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Judul Link</label>
                                        <input class="form-control" type="text" name="judul_link" placeholder="mis: Ajukan Permohonan" @if(isset($slider)) value="{{ $slider->link }}" @else value="{{ old('link') }}" @endif >
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Link slider</label>
                                        <input class="form-control" type="text" name="link" placeholder="mis: ./permohonan-informasi" @if(isset($slider)) value="{{ $slider->link }}" @else value="{{ old('link') }}" @endif >
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Keterangan slider</label>
                                        <input class="form-control" type="text" name="keterangan" placeholder="mis: Kegiatan Siswa" @if(isset($slider)) value="{{ $slider->keterangan }}" @else value="{{ old('keterangan') }}" @endif >
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Publish</label>
                                        <div class="form-check">
                                        <label class="custom-control-label">
                                            <input class="form-check-input" required type="radio" name="publish" checked id="" value="Y"<?php if(isset($slider)&& $slider->publish == 'Y') echo 'checked';?>>YA
                                        </label>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <label class="custom-control-label">
                                            <input class="form-check-input" required type="radio" name="publish" id="" value="T" <?php if(isset($slider)&& $slider->publish == 'T') echo 'checked';?> >TIDAK
                                        </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
				</form>

				<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

	<script>
		$(function () {
			// Multiple images preview with JavaScript
			var multiImgPreview = function (input, imgPreviewPlaceholder) {

			if (input.files) {
				var filesAmount = input.files.length;

				for (i = 0; i < filesAmount; i++) {
				var reader = new FileReader();

				reader.onload = function (event) {
					$($.parseHTML('<img>')).attr('src', event.target.result).appendTo(imgPreviewPlaceholder);
				}

				reader.readAsDataURL(input.files[i]);
				}
			}

			};

			$('#chooseFile').on('change', function () {
			multiImgPreview(this, 'div.imgGallery');
			});
		});
	</script>

				</div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>

@endsection
