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
        $Jaktif = Jemaat::where('status_aktif', 'Aktif')->count();
        $Jatestasi = Jemaat::where('status_aktif', 'Atestasi')->count();
        $Jkk = Jemaat::where('status_aktif', 'Aktif')->whereHas('kkJemaat')->count();
        $baptisan = Jemaat::with(['kkJemaat', 'hubunganKeluarga.kkJemaat'])
               ->whereNull('tanggal_sidi')
               ->whereNotNull('tanggal_baptis')
               ->whereIn('status_aktif', ['Aktif', 'Pasif', 'Bukan Anggota'])
               ->where('tanggal_lahir', '!=', '1900-01-01')
               ->count();
        
        return view('admin.dashboard.dashboard', compact('Jkk', 'Jaktif', 'Jatestasi', 'baptisan'));
    }

    public function detail($detail)
    {
        if($detail == 'atestasi')
        {
            $item = Jemaat::where('status_aktif', 'Atestasi')->get();
            $Hjudul = "<h1>Data Jemaat Atestasi</h1><hr>";
        }
        if($detail == 'aktif')
        {
            $Hjudul = "<h1>Data Jemaat Aktif</h1><hr>";
            $item = Jemaat::where('status_aktif', 'Aktif')->get();
        }
        if($detail == 'kepala-keluarga')
        {
            $Hjudul = "<h1>Data Kepala Keluarga</h1><hr>";
            $item = Jemaat::where('status_aktif', 'Aktif')->whereHas('kkJemaat')->get();
        }
        
        $Jaktif = Jemaat::where('status_aktif', 'Aktif')->count();
        $Jatestasi = Jemaat::where('status_aktif', 'Atestasi')->count();
        $Jkk = Jemaat::where('status_aktif', 'Aktif')->whereHas('kkJemaat')->count();
        $baptisan = Jemaat::with(['kkJemaat', 'hubunganKeluarga.kkJemaat'])
               ->whereNull('tanggal_sidi')
               ->whereNotNull('tanggal_baptis')
               ->whereIn('status_aktif', ['Aktif', 'Pasif', 'Bukan Anggota'])
               ->where('status_aktif', '!=', 'Meninggal Dunia')
               ->where('tanggal_lahir', '!=', '1900-01-01')
               ->count();

        $Hjudul = strtoupper($Hjudul);

        return view('admin.dashboard.dashboard', compact('Jkk', 'Jaktif', 'Jatestasi', 'item', 'Hjudul', 'baptisan'));
    }
}
