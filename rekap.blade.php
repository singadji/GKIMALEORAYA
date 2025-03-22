<?php use Carbon\Carbon; 

setlocale(LC_ALL, 'IND');

?>
<style>
    #table-4 th {
        background-color: #92278f;
        color: #fff;
        text-align: center;
        border: 0.25px solid #a1439e;
        border-bottom-width: 0.25px;
        border-bottom-style: solid;
        border-bottom-color: rgb(161, 67, 158);
        font-weight: normal;
        font-size: 14px;
        font-variant-caps: all-petite-caps;
        border-collapse: collapse;
        vertical-align: middle;
    }
</style>

@extends('layouts.app')

@section('halaman_login')

@if(Auth::check())
    @if (Auth::user()->role == 'admin')

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    <ol class="breadcrumb bc-3" >
		<li>
			<a href="home"><i class="entypo-home"></i>Beranda</a>
		</li>
		<li>
			<a href="#">Tumpukan Sampah</a>
		</li>
	</ol>
	
	<hr>
	
	<h2>Rekap Tumpukan Sampah</h2>
	
	<hr />
     <div class="form-group row">
        <div class="col-sm-1">
            <label for="nama">Bulan:</label>
        </div>
        <div class="col-sm-3">
            <select id="filter-bulan" class="filter form-control">
                <option value="0">-pilih bulan-</option>
                @foreach($listBulan as $key => $bln)
                    <option value="{{$key}}">{{$bln}}</option>
                @endforeach
            </select>
		</div>

        <div class="col-sm-1">
            <label for="nama">Jenis Sampah:</label>
        </div>
        <div class="col-sm-3">
        <select id="filter-jenis" class="filter form-control">
                <option value="0">-pilih jenis sampah-</option>
                @foreach($jenis_sampah as $mastersampah)
                    <option value="{{$mastersampah->nama_jenis_sampah}}">{{$mastersampah->nama_jenis_sampah}}</option>
                @endforeach
            </select>
		</div>
    </div>
 	<div style="overflow-x:auto; overflow-y:auto;"  id="DW">
        <div class="col-md-12">
			<table style="line-height:2; width:100%;color:#333333; font-size:10pt" class="table-bordered table-hover data-table table-striped tablesorter"  id="table-4">
				<thead>
					<tr>
						<th>No.</th>
                        <th hidden>bulan</th>
						<th>Tanggal</th>
						<th>Jenis Sampah</th>
						<th>Jumlah Tumpukan</th>
					</tr>
				</thead>
				<tbody>
					<?php $no=1;?>
					@foreach($data as $data)
					<tr>
						<td>{{$no}}.</td>
                        <td class="bulan" hidden data-bulan="{{$data->bulan}}">{{$data->bulan}}</td>
						<td>{{Carbon::parse($data->tanggal_jemput)->formatLocalized("%d %B %Y")}}</td>
						<td class="jenis" data-jenis="{{$data->nama_jenis_sampah}}">{{$data->nama_jenis_sampah}}</td>
						<td>{{$data->jumlah}} Kg</td>
					</tr>
					<?php $no++;?>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>

    <script type="text/javascript">
        jQuery( document ).ready( function( $ ) {
            var $table4 = jQuery( "#table-4" );
            
            $table4.DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'excelHtml5',
                    'pdfHtml5'
                ]
            } );
        } );		
    </script>

<script>
		$('.filter').change(function(){

		filter_function();
		});

		$('table tbody tr').show(); 
		function filter_function(){
		$('table tbody tr').hide(); 
		var bulanFlag = 0;
		var bulanValue = $('#filter-bulan').val();
		var jenisFlag = 0;
		var jenisValue = $('#filter-jenis').val();
		
        $('table tr').each(function() {  
		
		if(bulanValue == 0){
		bulanFlag = 1;
		}
		else if(bulanValue == $(this).find('td.bulan').data('bulan')){
			bulanFlag = 1;
		}
		else{
			bulanFlag = 0;
		}
		if(jenisValue == 0){  
		jenisFlag = 1;
		}
		else if(jenisValue == $(this).find('td.jenis').data('jenis')){ 
			jenisFlag = 1;      
		}
		else{
			jenisFlag = 0;
		}
		if(bulanFlag && jenisFlag){
		$(this).show();
		}
		});
    }
	</script>
           
        @else
        <script>
            window.location.reload(history.back());
        </script>
    @endif
@endif

@endsection