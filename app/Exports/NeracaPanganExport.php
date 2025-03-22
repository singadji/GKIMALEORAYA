<?php 
namespace App\Exports;

use Illuminate\Http\Request;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View; 

use Maatwebsite\Excel\Concerns\FromView;

use App\Helpers\FunctionHelper;

use App\Exports\NeracaPanganExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\MasterNbKomoditas;
use App\Models\NeracaPangan;

use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
 
class NeracaPanganExport implements FromView
    {
        public function view():View
        {
            $request = (object) collect([
                'tahun' => request()->tahun,
                'bulan' => request()->bulan,
            ])->all();
            
            $neraca = NeracaPangan::select('*')
                 ->select(array('*', DB::raw('neraca_pangans.*, neraca_pangans.ketersediaan - neraca_pangans.konsumsi as neraca, neraca_pangans.id as id_np')))
                    ->join('master_nb_komoditas', 'neraca_pangans.id_komoditas', '=', 'master_nb_komoditas.id_komoditas')
                    ->where('bulan', '=', $request->bulan)
                    ->where('tahun', '=', $request->tahun)
                    ->get($request);

            $bulan = FunctionHelper::bulan();
            $tahun = NeracaPangan::select('tahun')->distinct()->get();
            $komoditas = MasterNbKomoditas::get();

            return view('pangan.neraca-pangan.export')
                ->with('neraca', $neraca)
                ->with('tahun', $tahun)
                ->with('bulan', $bulan)
                ->with('request', $request)
                ->with('komoditas', $komoditas);
        }  
   }
