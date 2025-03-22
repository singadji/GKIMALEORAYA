
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
                <h3>Administrasi Video</h3>
            </div>
            <br>
            <div class="">
                <div id="alert">
                    @include('includes.alert')
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-4">
                    <table style="line-height: 1.3; width:100%;color:#333333;" class="table align-items-center mb-2 table-hover data-table nowrap" id="dataTable">
                        <thead>
                            <tr>
                                <th class="text-uppercase font-weight-bolder">#</th>
                                <th class="text-uppercase font-weight-bolder">Judul Video</th>
                                <th class="text-uppercase font-weight-bolder ps-2">Video</th>
                                <th class="text-uppercase text-center font-weight-bolder">Link Youtube</th>
                                <th class="text-uppercase text-center font-weight-bolder">Publish</th>
                                <th class=""></th>
                            </tr>
                        </thead>
                        <tbody>
                        @php $no = 1; @endphp
                            @foreach($item as $item)
                            <tr>
                                <td class="align-middle text-left">{{$no}}.</td>
                                <td class="align-middle text-left">{{$item->judul_video}}</td>
                                <td class="align-middle text-left"><iframe src="{!!$item->link_youtube!!}" frameborder="0" allowfullscreen></iframe></td>
                                <td class="align-middle text-center">{{$item->link_youtube}}</td>
                                <td class="align-middle text-center">
                                    @if($item->publish == 1)
                                        <a href="{{ asset('web/video/notpublish/'.$item->id_video) }}" data-confirm-update="Data akan disembunyikan, yakin?" class="icon icon-shape icon-sm bg-gradient-success text-white shadow text-center border-radius-sm">
                                        <i class="fas fa-check"></i>
                                        </a>
                                        @endif
                                        
                                        @if($item->publish == 0)
                                        <a href="{{ asset('web/video/publish/'.$item->id_video) }}" data-confirm-update="Data akan ditampilkan, yakin?" class="icon icon-shape icon-sm bg-gradient-danger text-white shadow text-center border-radius-sm">
                                        <i class="fas fa-times"></i>
                                        </a>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <a class="btn btn-link text-dark px-1 mb-0" href="{{route('web.video.edit', $item->id_video)}}">
                                        <i class="fas fa-pencil-alt text-dark me-1" aria-hidden="true"></i>
                                    </a>
                                    <a class="btn btn-link text-danger text-gradient px-1 mb-0" data-confirm-delete="true" href="{{route('web.video.destroy', $item->id_video)}}">
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