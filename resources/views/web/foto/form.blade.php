@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')

@include('layouts.navbars.auth.topnav')

@section('alert-error')
    @if (Session::has('errors'))
        <div class="col-md-12">
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
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
<div class="container-fluid mt--6">
    <div class="card mb-10">
        <div class="card-header mb-0">
            <h3>{{$subjudul}}</h3>
        </div>
        <div class="">
            <div id="alert">
                @if ($errors->any())
                    <div class="alert alert-danger" style="color:#fff; font-size:10pt">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
        <div class="">
                <div id="alert">
                    @include('includes.alert')
                </div>
            </div>
        <div class="card-body px-0 pt-0 pb-2">
            <div class="card-body">
                <form role="form" method="POST" action="{{ $aksi }}" enctype="multipart/form-data">
                @csrf
                @if(isset($item))
                    @method('PUT')
                @endif
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label" for="">Nama Album</label>
                                <input class="form-control" type="text" name="nama_album" placeholder="mis: Rapat Kerja" 
                                @if(isset($item)) value="{{ $item->nama_album }}" 
                                @else value="{{ old('nama_album') }}" @endif required>
                            </div>
                        </div>

                      
					    <div class="col-lg-12">
                                  <div class="form-group">
                                      <label for="example-text-input" class="form-control-label">Keterangan</label>
                                      <textarea style="height: 100px" id="" name="keterangan" required class="form-control"> @if(isset($item)) {{ $item->keterangan }} @else {{ old('keterangan') }} @endif</textarea>
                                  </div>
                              </div>
                              @if(!isset($item))
                              <div class="col-lg-6">
                             	<div class="form-group">
								<label  class="form-control-label">Foto</label>
								<div class="nopadding edit custom-file">
									<input type="file" name="foto[]" lang="id" required="required" id="chooseFile" accept="image/gif,image/jpeg,image/jpg,image/png" multiple class="custom-file-input" />
                                    <label class="custom-file-label" for="customFileLang"></label>
									<p style="color: red"><em>Ekstensi yang diperbolehkan .png | .jpg | .jpeg - Boleh lebih dari 1 gambar</em></p>
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
							  </div>
                              @endif      
                          <div class="col-lg-2">
                              <div class="form-group">
                                  <label for="" class="form-control-label">Publish</label>
                                  <div class="form-check">
                                  <label class="custom-toggle">
                                      <input type="checkbox" name="publish" id="" value="1" @if(isset($item) && $item->publish == '1') checked @endif>
                                      <span class="custom-toggle-slider rounded-circle" data-label-off="Tidak" data-label-on="Ya"></span>
                                  </label>
                                  </div>
                              </div>
                          </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success bg-gradient-success btn-md"> Simpan </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth.footer')
</div>

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

@endsection
