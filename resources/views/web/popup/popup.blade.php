@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Image Popup Management'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
					<div class="card-header pb-0 p-3">
					@if ($message = Session::get('success'))
						<div class="alert alert-success alert-dismissible text-light" role="alert">
							<button type="button " class="close" data-dismiss="alert">×</button>  
						{{ $message }}
						</div>
					@endif
						<div class="row">
                            <div class="col-6 d-flex align-items-center">
                                <h6 class="mb-0">Image Popup</h6>
                            </div>
                            <div class="col-6 text-end">
							<a href="{{ route('admin-popup.create') }}" class="btn bg-gradient-primary btn-sm mb-0">Add New Popup</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 table-hover data-table nowrap" id="datatable">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-center text-xxs font-weight-bolder opacity-7">
                                            No.</th>
                                        <th class="text-uppercase text-secondary text-left text-xxs font-weight-bolder opacity-7">
                                            Judul</th>
                                        <th class="text-uppercase text-secondary text-center text-xxs font-weight-bolder opacity-7 ps-2">
                                            Gambar</th>
                                        <th class="text-center text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                            Publish</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no=1; ?>
									@foreach($popup as $popup)
                                    <tr>
										<td class="align-middle text-center text-sm font-weight-bold">
                                            {{$no}}.
                                        </td>
										<td class="align-middle text-left text-sm font-weight-bold">
                                            {{$popup->judul}}
                                        </td>
                                        <td class="align-middle text-center text-sm">
											<a href="#" data-toggle="modal" data-target="#modal-{{$popup->uuid}}">
												<img class="border-radius-lg shadow-sm height-100 w-auto" src="{{asset('images/banner/'.$popup->gambar)}}" alt="" style="width:50%; width: 60px;">
											</a>
											<div class="modal top fade" id="modal-{{$popup->uuid}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="trfalseue" data-mdb-backdrop="true" data-mdb-keyboard="true">
											<div class="modal-dialog modal-lg">
												<div class="modal-content" >
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
													</div>
													<div class="modal-body">
													<h4 class="modal-title"> popup: {{$popup->judul}}</h4>
													<br/>
													<hr/>
													<img class="border-radius-lg shadow-sm height-100 w-auto" src="{{asset('images/banner/'.$popup->gambar)}}" alt="" style="width:50%; width: 60px;">
													<hr>
													<div class="modal-footer">
													</div>
												</div>
											</div>
											</div>
                                        </td>
                                        <td class="align-middle text-center">
											@if($popup->publish == "Y")
												<a href="{{ asset('admin-popup/notpublish/'. $popup->uuid) }}" class="icon icon-shape icon-sm bg-gradient-success shadow text-center border-radius-sm notpublish-confirm">
												<i class="fas fa-check opacity-10"></i>
												</a>
												@endif
												
												@if($popup->publish == "T")
												<a href="{{ asset('admin-popup/publish/'. $popup->uuid) }}" class="icon icon-shape icon-sm bg-gradient-danger shadow text-center border-radius-sm publish-confirm">
												<i class="fas fa-times opacity-10"></i>
												</a>
											@endif
                                        </td>
                                        <td class="align-middle">
											<form id="form" name="" action="{{ route('admin-popup.destroy', $popup->uuid) }}" class="delete-form" method="post">
												<a class="btn btn-link text-dark text-xs text-gradient px-3 mb-0 " href="{{ route('admin-popup.edit',$popup->uuid) }}"><i class="fas fa-pencil-alt text-dark me-2"></i></a>
												@csrf
                                                <input type="hidden" name="uuid" value="{{$popup->uuid}}"> 
												<button type="button" class="btn btn-link text-danger text-xs text-gradient px-3 mb-0 delete-button"><i class="far fa-trash-alt me-2"></i></button>
												@method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                    <?php $no++; ?>
									@endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>	
        @include('layouts.footers.auth.footer')
    </div>
	
@endsection
