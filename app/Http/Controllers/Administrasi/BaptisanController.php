<?php

namespace App\Http\Controllers\Administrasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Jemaat;
use App\Models\KKJemaat;
use App\Models\HubunganKeluarga;
use Carbon\Carbon;

use Alert;


class BaptisanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title  = 'Hapus Data!';
        $text   = "Data akan dihapus, Anda Yakin?";
        $btn    = '';
        $page   = 'Administrasi';
        $judul  = 'Data Jemaat';
        $subjudul = 'Data Anggota Calon Sidi';
        $tombol = $btn;
        $Hjudul = strtoupper($subjudul);

        $tanggal_akhir = date('Y') . '-12-31';

        $item = Jemaat::with(['kkJemaat', 'hubunganKeluarga.kkJemaat'])
              ->whereNull('tanggal_sidi')
            ->whereNotNull('tanggal_baptis')
            ->whereIn('status_aktif', ['Bukan Anggota'])
            ->where('tanggal_lahir', '!=', '1900-01-01')
            ->where('tanggal_baptis', '!=', '1900-01-01')
            ->get();

        return view('administrasi.baptisan.index', compact(
            'item',
            'btn',
            'page',
            'judul',
            'subjudul',
            'tombol',
            'Hjudul',
        ));
    }
   
}