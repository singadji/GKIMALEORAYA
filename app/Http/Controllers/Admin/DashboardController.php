<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Identitas;
use App\Models\Jemaat;
use App\Models\KKJemaat;

use Image;
use PDF;

class DashboardController extends Controller
{


    // Index
    public function index()
    {
        $aktif = Jemaat::where('status_aktif', 'Aktif')->count();
        $atestasi = Jemaat::where('status_aktif', 'Atestasi')->count();
        $kk = Jemaat::where('status_aktif', 'Aktif')->whereHas('kkJemaat')->count();
        
        return view('admin.dashboard.dashboard', compact('kk', 'aktif', 'atestasi'));
    }
}
