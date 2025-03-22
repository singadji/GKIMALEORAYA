
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
                <h3>Administrasi Menu</h3>
            </div>
            <br>
            <div class="">
                <div id="alert">
                    @include('includes.alert')
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-4">
                <table data-excluded-columns="0,1,2,3,4,5,6" style="line-height: 1.3; width:100%;color:#333333;" class="display table align-items-center mb-2 table-hover data-table nowrap" id="dataTable">
                        <thead>
                            <tr>
                                <th class="">#</th>
                                <th class="">Menu</th>
                                <th class="">Parent</th>
                                <th class="">Position</th>
                                <th class="">Link</th>
                                <th class="">Publish</th>
                                <th class=""></th>
                            </tr>
                            <tr style="background-color:#fff">
                                <td class="text-center"></td>
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
                                <td class="align-middle text-left">{{$item->nama_menu}} - ({{$item->id_menu}})</td>
                                <td class="align-middle text-center">{{$item->id_parent}}</td>
                                <td class="align-middle text-center">{{ $item->posisi}}</td>
                                <td class="align-middle text-left">{{ $item->link_menu }}</td>
                                <td class="align-middle text-center">
                                    @if($item->publish == "Y")
                                        <a href="{{ asset('web/menu/notpublish/'.$item->id_menu) }}" data-confirm-update="Data akan disembunyikan, yakin?" class="icon icon-shape icon-sm bg-gradient-success text-white shadow text-center border-radius-sm">
                                        <i class="fas fa-check"></i>
                                        </a>
                                        @endif
                                        
                                        @if($item->publish == "T")
                                        <a href="{{ asset('web/menu/publish/'.$item->id_menu) }}" data-confirm-update="Data akan ditampilkan, yakin?" class="icon icon-shape icon-sm bg-gradient-danger text-white shadow text-center border-radius-sm">
                                        <i class="fas fa-times"></i>
                                        </a>
                                    @endif
                                </td>
                                <td class="align-middle text-center">
                                    <a class="btn btn-link text-dark px-1 mb-0" href="{{route('web.menu.edit', $item->id_menu)}}">
                                        <i class="fas fa-pencil-alt text-dark me-1" aria-hidden="true"></i>
                                    </a>
                                    <a class="btn btn-link text-danger text-gradient px-1 mb-0" data-confirm-delete="true" href="{{route('web.menu.destroy', $item->id_menu)}}">
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