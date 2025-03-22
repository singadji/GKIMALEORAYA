@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Contact Management'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
					<div class="card-header pb-0 p-3">
                        <div class="row">
                            <div class="col-6 d-flex align-items-center">
                                <h6 class="mb-0">Message from Guest</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-center text-xxs font-weight-bolder opacity-7">Nama</th>
                                        <th class="text-uppercase text-secondary text-center text-xxs font-weight-bolder opacity-7">Telepon/WA</th>
                                        <th class="text-uppercase text-secondary text-center text-xxs font-weight-bolder opacity-7 ps-2">Email</th>
                                        <th class="text-center text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">Subject</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
									@foreach($kontak as $kontak)
                                    <tr>
										<td class="align-middle text-center text-sm font-weight-bold">
                                            {{$kontak->name}}
                                        </td>
										<td class="align-middle text-center text-sm font-weight-bold">
                                            {{$kontak->telepon}}
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            {{$kontak->email}}
                                        </td>
                                        <td class="align-middle text-center text-sm">
											{{$kontak->subject}}
                                        </td>
                                        <td class="align-middle">
                                        <a class="btn btn-link text-success px-3 mb-0" data-bs-toggle="modal" data-bs-target="#exampleModal{{$kontak->id}}"><i
                                            class="ni ni-align-left-2 text-success me-2" aria-hidden="true"></i>Detail</a>

                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal{{$kontak->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Detail Pesan</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6 form-group">
                                                        <input type="text" name="name" class="form-control" value="{{$kontak->name}}"  placeholder="Nama" disabled>
                                                        </div>
                                                        <div class="col-md-6 form-group mt-3 mt-md-0">
                                                        <input type="text" class="form-control" name="telepon" placeholder="Telephone / WA" value="{{$kontak->telepon}}" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <input type="email" class="form-control" name="email" placeholder="Email" value="{{$kontak->email}}" disabled>
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <input type="text" class="form-control" name="subject" placeholder="Subject" value="{{$kontak->subject}}" disabled>
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <input type="text" multiline rows="10" class="form-control" name="message" placeholder="Message" value="{{$kontak->message}}" disabled >
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                                </div>
                                            </div>
                                            </div>

										<a class="btn btn-link text-danger text-gradient px-3 mb-0 delete-confirm" href="{{ asset('admin-kontak/delete/'.$kontak->id) }}">
                                            <i class="far fa-trash-alt me-2"></i>Delete</a>
                                        </td>
                                    </tr>
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
