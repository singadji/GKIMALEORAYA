<?php 
namespace App\Exports;

use Illuminate\Http\Request;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View; 

use Maatwebsite\Excel\Concerns\FromView;

use App\Models\MasterKomoditas;
use App\Models\MasterJKomoditas;
use App\Models\MasterPasar;
use App\Models\HargaPanganDetail;
use App\Helpers\FunctionHelper;
use App\Models\HargaPangan;

use App\Services\RekapitulasiService;

use App\Exports\HargapanganExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
    
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
 
class HargaPanganExport implements FromView
    {
        public function view():View
        {
            $request = (object) collect([
                'tahun' => request()->tahun,
                'bulan' => request()->bulan,
            ])->all();
            
            $pasar = MasterPasar::get();
            $jumlahPasar = MasterPasar::count();
            $bulan = FunctionHelper::bulan();
            $tahun = HargaPangan::select('tahun')->distinct()->get();

           
            $dataRataHargaPerKomoditas = RekapitulasiService::getDataRataHargaPerKomoditas($request);
            $dataRataHargaPerKomoditasSekarang = RekapitulasiService::getDataRataHargaPerKomoditasSekarang($request);
            $dataRekap = RekapitulasiService::getRekapData($request, $dataRataHargaPerKomoditas, $dataRataHargaPerKomoditasSekarang);

            return view('pangan.harga-pangan.export')
                    ->with('pasar', $pasar)
                    ->with('tahun', $tahun)
                    ->with('bulan', $bulan)
                    ->with('jp', $jumlahPasar)
                    ->with('dataRekap', $dataRekap)
                    ->with('request', $request);
        } 
    }
