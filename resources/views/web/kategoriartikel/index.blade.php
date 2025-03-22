@extends('layouts.app')

@section('halaman_login')
@if(Auth::check())
@if (Auth::user()->type == 'admin')
	<ol class="breadcrumb bc-3" >
		<li>
			<a href="./home"><i class="entypo-home"></i>Beranda</a>
		</li>
		<li>
			<a href="#">Manajemen Web</a>
		</li>
		<li class="active">
			<strong>Kategori Berita</strong>
		</li>
	</ol>
	
	<hr>
	
	<h2>Administrasi Kategori Berita</h2>
		
	<br />
	
	<a href="{{ asset('admin-kategoriberita/insert') }}" class="btn btn-primary btn-icon icon-left">
		<i class="entypo-plus"></i>Tambah Kategori Berita
	</a>
	
	<br /><br>
	<div style="overflow-x:auto; overflow-y:auto;"  id="DW">
	<table style="line-height:1.3; width:100%;color:#333333; font-size:9pt" class="table-bordered table-hover data-table table-striped tablesorter" id="dataTable" cellspacing="0">
		<thead>
        	<tr>
        		<th>No.</th>
        		<th>Kategori Berita</th>
                <th width="20%">Aksi</th>
        	</tr>
        </thead>
                  
        <tbody>
					  
                   <?php
						$no = 1;
						foreach($kategori as $kategori) {
					?>
                    <tr>
                      <td width="20px"><?=$no.'.'?></td>
                      <td>{{$kategori->nama_kategori}}</td>	
                      <td align="center">
                     		<a href="{{ asset('admin-kategoriberita/update/'.$kategori->nama_kategori) }}" class="btn btn-info btn-sm btn-icon icon-left">
							 <i class="entypo-pencil"></i>Edit
                  			</a>
                     		<!-- <a href="{{ asset('admin-kategoriberita/delete/'.$kategori->nama_kategori) }}" class="btn btn-danger btn-sm btn-icon icon-left delete-confirm">
                   		 		<i class="entypo-trash"></i>Hapus
                  			</a> -->
							 
                      </td>
                     
                    </tr>
                    <?php 
							$no++;
						}?>
                    
                  </tbody>
									  </table>
					</div>
					

@else
        <script>
            window.location.reload(history.back());
        </script>
    @endif
@endif

	
@endsection