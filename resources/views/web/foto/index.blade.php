
@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')

@include('layouts.navbars.auth.topnav')

    @section('alert-error')

        @if (Session::has('errors'))
            <div class="col-md-12">
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
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
            <br>
            <div class="">
                <div id="alert">
                    @include('includes.alert')
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-4">
                    <table data-excluded-columns="0,1,2,3,4" style="line-height: 1.3; width:100%;color:#333333;" class="display table align-items-center mb-2 table-hover data-table nowrap" id="dataTable">
                        <thead>
                            <tr>
                                <th class="text-uppercase font-weight-bolder">#</th>
                                <th class="text-uppercase font-weight-bolder">Judul</th>
                                <th class="text-uppercase font-weight-bolder ps-2">Foto</th>
                                <th class="text-uppercase text-center font-weight-bolder">Publish</th>
                                <th class=""></th>
                            </tr>
                            <tr style="background-color:#fff">
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                            </tr>
                        </thead>
                        <tbody>
                        @php $no = 1; @endphp
                            @foreach($item as $item)
                            <tr>
                                <td class="align-middle text-left">{{$no}}.</td>
                                <td class="align-middle text-left">{{$item->nama_album}}</td>
                                <td class="align-middle text-center">
                                    <a href="#" data-toggle="modal" data-target="#modal-{{$item->id_album}}" class="btn btn-primary bg-gradient-primary btn-md">
                                        <i class="ni ni-album-2"></i>
                                    </a>
                                    <!-- Modal -->
                                    <div class="modal fade" id="modal-{{$item->id_album}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-xl" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Koleksi {{$item->nama_album}}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form role="form" class="form-horizontal form-groups-bordered" method="POST" enctype="multipart/form-data" action="{{route('web.album-foto.simpan')}}">
                                                @csrf
                                                <div class="col-sm-12">
                                                <label>Gunakan ini untuk menambah koleksi foto pada {{$item->nama_album}}.</label>
                                                    <input type="file" name="foto" class="form-control" accept="image/gif,image/jpeg,image/jpg,image/png">
                                                </div>
                                                <br>
                                                <div class="col-sm-12">
                                                    <input type="text" name="judul_foto" placeholder="Judul Foto" class="form-control">
                                                    <input type="hidden" name="id" value="{{$item->id_album}}">
                                                </div>
                                                <br>
                                                <div class="col-sm-12">
                                                    <button class="btn btn-success bg-gradient-success btn-block" type="submit">Tambah Foto Baru</button>
                                                </div>
                                            </form>

                                            <hr>
								            <div class="table-responsive">
											    <table class="table table-bordered table-hover data-table table-striped tablesorter" id="dataTable" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                        <th>No.</th>
                                                        <th>Judul Foto</th>
                                                        <th>Foto</th>
                                                        <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    
                                                    <tbody>
                                                        @php
                                                        $no = 1
                                                        @endphp
                                                        @foreach($foto as $galery)
                                                            @if($galery->id_album == $item->id_album)
                                                
                                                        <tr>
                                                            <td width="20px">{{$no}}</td>
                                                            <td>{{$galery->judul_foto}}</td>
                                                            <td><img src="{{asset ('images/foto/'.$galery->foto)}}" width="150px"></td>
                                                            <td width="80px" align="center">
                                                                <a href="{{ asset('web/album-foto/delete/'.$galery->id_foto) }}" class="btn btn-danger btn-sm btn-icon icon-left"  data-confirm-delete="true">
                                                                    <i class="entypo-trash"></i>Hapus
                                                                </a>
                                                            </td>
                                                        
                                                        </tr>
                                                        @php
                                                            $no++
                                                        @endphp
                                                        @endif
                                                        @endforeach
                                                    </tbody>
											    </table>
										    </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                        </div>
                                        </div>
                                    </div>
                                    </div>

                                </td>
                                <td class="align-middle text-center">
                                    @if($item->publish == '1')
                                        <a href="{{ asset('web/album-foto/notpublish/'.$item->id_album) }}" data-confirm-update="Data akan disembunyikan, yakin?" class="icon icon-shape icon-sm bg-gradient-success text-white shadow text-center border-radius-sm">
                                        <i class="fas fa-check"></i>
                                        </a>
                                        @endif
                                        
                                        @if($item->publish == '0')
                                        <a href="{{ asset('web/album-foto/publish/'.$item->id_album) }}" data-confirm-update="Data akan ditampilkan, yakin?" class="icon icon-shape icon-sm bg-gradient-danger text-white shadow text-center border-radius-sm">
                                        <i class="fas fa-times"></i>
                                        </a>
                                    @endif
                                </td>
                               
                                <td class="align-middle text-center">
                                    <a class="btn btn-link text-dark px-1 mb-0" href="{{route('web.album-foto.edit', $item->id_album)}}">
                                        <i class="fas fa-pencil-alt text-dark me-1" aria-hidden="true"></i>
                                    </a>
                                    <a class="btn btn-link text-danger text-gradient px-1 mb-0" data-confirm-delete="true" href="{{route('web.album-foto.destroy', $item->id_album)}}">
                                        <i class="far fa-trash-alt me-1"></i>
                                    </a>
                                </td>
                            </tr>
                            @php $no++; @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection