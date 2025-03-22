<?php
namespace App\Http\Controllers;
use App\Models\MasterKabupaten;
use App\Models\MasterKecamatan;
use App\Models\MasterKelurahan;

use Illuminate\Http\Request;
 
class WilayahController extends Controller
{
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