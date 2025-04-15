<?php
namespace App\Http\Controllers\Master;
use App\Http\Controllers\Controller;
use App\Models\MasterKabupaten;
use App\Models\MasterKecamatan;
use App\Models\MasterKelurahan;
use App\Models\GroupWilayah;

use Illuminate\Http\Request;
 
class WilayahController extends Controller
{
    public function index()
    {
        $title  = 'Hapus Data!';
        $text   = "Data akan dihapus, Anda Yakin?";
        $btn    = '<a href="#" class="btn btn-warning bg-gradient-warning btn-sm mt-3 ms-auto dropdown" id="navbar-default_dropdown_1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Upload Excel</a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbar-default_dropdown_1">
                        <a class="dropdown-item" href="'. route('download.template.excel.import', ['filename' => 'Template_Data_Jemaat.xlsx']) .'">Download Template</a>
                        <form action="'.route('administrasi.data-jemaat.import').'" method="POST" enctype="multipart/form-data" id="formImport">
                            '. csrf_field() .'
                            <input type="file" name="file" id="file" class="form-control" style="display: none;" accept=".xlsx,.xls" required>
                            <a href="#" class="dropdown-item" id="importLink">Upload</a>
                        </form>
                    </div>
                    <a href="' . route('administrasi.data-jemaat.create') . '" class="btn btn-info bg-gradient-info btn-sm mt-3 ms-auto">Jemaat Baru</a>';
        $page   = 'Administrasi';
        $judul  = 'Data Jemaat';
        $subjudul = 'Administrasi Jemaat';
        $tombol = $btn; 

        confirmDelete($title, $text);

        $item   = GroupWilayah::get();

        return view('master.wilayah.index',compact('item', 'btn', 'page', 'judul', 'subjudul', 'tombol'));
    }
    
    public function getKabupaten(){
        $kabupaten = MasterKabupaten::all();
        return response()->json($kabupaten);
    }
    public function getKecamatan(Request $request){
        $kecamatan = MasterKecamatan::where("id_kota_kabupaten","3603")->pluck('id_kecamatan','kecamatan');
        return response()->json($kecamatan);
    }
    public function getKelurahan($id){
        $kelurahan = MasterKelurahan::where("id_kecamatan",$id)->pluck('kelurahan','id_kelurahan');
        return response()->json($kelurahan);
    }
  
}