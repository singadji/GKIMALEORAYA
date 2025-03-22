<?php

namespace App\Http\Controllers\Administrasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Http\Requests\JemaatRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;

use App\Models\Jemaat;
use App\Models\KKJemaat;
use App\Models\HubunganKeluarga;


use Carbon\Carbon;

use Alert;


class JemaatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title  = 'Hapus Data!';
        $text   = "Data akan dihapus, Anda Yakin?";
        $btn    = '<a href="' . route('administrasi.data-jemaat.create') . '" class="btn btn-info bg-gradient-info btn-sm mt-3 ms-auto">Jemaat Baru</a>';
        $page   = 'Administrasi';
        $judul  = 'Data Jemaat';
        $subjudul = 'Administrasi Jemaat';
        $tombol = $btn; 

        confirmDelete($title, $text);

        $item   = Jemaat::with(['kkJemaat', 'hubunganKeluarga.kkJemaat'])->orderBy('nia')->get();

        return view('administrasi.jemaat.index',[
            'item' => $item,
            'btn'    => $btn,
            'page'  => $page,
            'judul'  => $judul,
            'subjudul'  => $subjudul,
            'tombol'  => $tombol,
            compact('item')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $btn    = '<a href="' .route('administrasi.jemaat.index') . '" class="btn btn-secondary bg-gradient-secondary btn-sm mt-3 ms-auto">Kembali</a>';
        $page   = 'Content Management';
        $judul  = 'Jemaat';
        $subjudul = 'Jemaat Baru';
        $tombol = $btn;
        $aksi = '' .route('administrasi.jemaat.store').'';

        return view('administrasi.jemaat.form',[
            'btn'    => $btn,
            'page'  => $page,
            'judul'  => $judul,
            'subjudul'  => $subjudul,
            'tombol'  => $tombol, 
            'aksi' => $aksi,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JemaatRequest $request)
    {
        $Jemaat = new Jemaat;

        if($request->publish != ''){
            $publish = 'Y';
        }else{
            $publish = 'N';
        }

        if($request->role == 'Pangan')
        {
            $roleid = '1';
        }elseif($request->role == 'Pertanian'){
            $roleid = '2';
        }else{
            $roleid = '0';
        }
        
        
        $Jemaat->name     = $request->nama;
        $Jemaat->email    = $request->email;
        $Jemaat->password = Hash::make($request->password);
        $Jemaat->aktif    = $publish;
        $Jemaat->role     = $request->role;
        $Jemaat->role_id  = $roleid;
        $Jemaat->image    = '08_03_05_2021_05_25_Administrator.jpg';
            
        $Jemaat->save();

        return redirect()->route('administrasi.data-jemaat.index')->with('success', 'Berhasil menambahkan data-jemaat.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $title  = 'Hapus Data!';
        $text   = "Data akan dihapus, Anda Yakin?";
        $btn    = '<a href="' .route('administrasi.data-jemaat.index') . '" class="btn btn-secondary bg-gradient-secondary btn-sm mt-3 ms-auto">Kembali</a>';
        $page   = 'Administrasi';
        $judul  = 'Data Jemaat';
        $subjudul = 'Administrasi Jemaat';
        $tombol = $btn; 

        // Ambil data jemaat berdasarkan ID
        //$jemaat = Jemaat::with(['kkJemaat', 'hubunganKeluarga'])->findOrFail($id);
        $jemaat = Jemaat::where('id_jemaat', $id)->first();
        
        $kk = KkJemaat::where('id_jemaat', $jemaat->id_jemaat)->first();
        if($kk){
            $dtkk = $kk;
        }else{
            echo $dtkk = HubunganKeluarga::where('id_jemaat', $id)->with('kkjemaat', 'jemaat.kkjemaat')->first();
        }
        // Ambil data kepala keluarga (KK) berdasarkan ID KK yang sama
        $kepalaKeluarga = KkJemaat::where('id_kk_jemaat', $jemaat->id_kk_jemaat)->first();

        // Ambil semua anggota keluarga berdasarkan ID KK
        $anggotaKeluarga = HubunganKeluarga::where('id_kk_jemaat', $jemaat->id_kk_jemaat)->with('jemaat')->get();

        return view('administrasi.jemaat.detail', compact('kepalaKeluarga', 'anggotaKeluarga', 'jemaat'),[
            'btn'    => $btn,
            'page'  => $page,
            'judul'  => $judul,
            'subjudul'  => $subjudul,
            'tombol'  => $tombol, 
        ]);
    }

    public function edit($Jemaat)
    {
        $item =  Jemaat::where('id', $Jemaat)->firstOrFail();
        
        $btn    = '<a href="' .route('administrasi.data-jemaat.index') . '" class="btn btn-secondary bg-gradient-secondary btn-sm mt-3 ms-auto">Kembali</a>';
        $page   = 'Content Management';
        $judul  = 'Jemaat';
        $subjudul = 'Update Jemaat';
        $tombol = $btn; 

        $aksi = '' .route('administrasi.data-jemaat.update', $item->id).'';

        return view('administrasi.data-jemaat.form', compact('jemaat'),[
            'btn'       => $btn,
            'page'      => $page,
            'judul'     => $judul,
            'subjudul'  => $subjudul,
            'tombol'    => $tombol, 
            'item'      => $item,
            'aksi'      => $aksi,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $Jemaat = Jemaat::where('id', $id)->firstOrFail();

        if($request->publish != ''){
            $publish = 'Y';
        }else{
            $publish = 'N';
        }

        if($request->role == 'Pangan')
        {
            $roleid = '1';
        }elseif($request->role == 'Pertanian'){
            $roleid = '2';
        }else{
            $roleid = '0';
        }
        
        
        $Jemaat->name     = $request->nama;
        $Jemaat->email    = $request->email;
        if($request->password != ''){
            $Jemaat->password = Hash::make($request->password);
        }
        $Jemaat->aktif    = $publish;
        $Jemaat->role     = $request->role;
        $Jemaat->role_id  = $roleid;
        $Jemaat->image    = '08_03_05_2021_05_25_Administrator.jpg';
            
        $Jemaat->save();


        return redirect()->route('administrasi.data-jemaat.index')->with('success', 'Berhasil mengubah data.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $Jemaat = Jemaat::where('id', $id)->firstOrFail();
            $Jemaat->delete();

            return redirect('web/data-jemaat')->with(['success' => 'Jemaat berhasil dihapus.']);

        } catch (\Exception $e) {
            return redirect('web/data-jemaat')->with('error', 'Gagal, Jemaat tidak dapat dihapus.');
        }            
    }

    public function publish($id)
    {
        DB::table('Jemaats')->where('id', $id)->update([
            'aktif'  => 'Y'
        ]);

        return redirect('web/data-jemaat')->with(['success' => 'Jemaat berhasil diupdate.']);
        
    }
    
    public function notpublish($id)
    {
        DB::table('Jemaats')->where('id', $id)->update([
            'aktif'  => 'N'
        ]);

        return redirect('web/data-jemaat')->with(['success' => 'Jemaat berhasil diupdate.']);
    }
   
}
