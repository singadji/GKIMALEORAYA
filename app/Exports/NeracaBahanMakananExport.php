<?php 
namespace App\Exports;

use Illuminate\Http\Request;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View; 

use Maatwebsite\Excel\Concerns\FromView;

use App\Helpers\FunctionHelper;

use App\Exports\NeracaBahanMakananExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\MasterNbKomoditas;
use App\Models\NeracaBahanMakanan;

use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
 
class NeracaBahanMakananExport implements FromView
    {
        public function view():View
        {
            $request = (object) collect([
                'tahun1' => request()->awal,
                'tahun2' => request()->akhir,
            ])->all();

            //$tahun1 = $request->input('awal');
            //$tahun2 = $request->input('akhir');
    
        $tahun = NeracaBahanMakanan::select('tahun')
            ->distinct()
            ->orderBy('tahun')
            ->get();


        $tahunRange = range($tahun1, $tahun2);
        
        // Fetch data and pre-structure it
        $neraca = NeracaBahanMakanan::with('komoditas')->get()->groupBy(['id_komoditas', 'tahun']);
        $komoditas = MasterNbmKomoditas::all();

        // Calculate totals for years
        $total = NeracaBahanMakanan::select('tahun', DB::raw('SUM(energi) AS j_energi, SUM(protein) AS j_protein, SUM(lemak) AS j_lemak'))
            ->whereBetween('tahun', [$tahun1, $tahun2])
            ->groupBy('tahun')
            ->get()
            ->keyBy('tahun');

        $total_nabati = NeracaBahanMakanan::select('tahun', 'kelompok', DB::raw('SUM(energi) AS j_energi, SUM(protein) AS j_protein, SUM(lemak) AS j_lemak'))
            ->join('master_nbm_komoditas', 'neraca_bahan_makanans.id_komoditas', '=', 'master_nbm_komoditas.id_komoditas')
            ->whereBetween('tahun', [$tahun1, $tahun2])
            ->groupBy('tahun', 'kelompok')
            ->get()
            ->groupBy(['tahun', 'kelompok']);

        $kelompok = MasterNbmKomoditas::select('kelompok')->distinct()->get();

        // Pass all relevant data to the view
        return view('pangan.neraca-bahan-makanan.export', compact(
                'neraca', 'komoditas', 'tahunRange', 'tahun1', 'tahun2', 'total', 'total_nabati', 'kelompok'))
            ->with('request', $request)
            ->with('tahun', $tahun)
            ;
        }  
   }
