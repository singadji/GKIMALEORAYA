<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Http\Requests\KategoriArtikelRequest;
use Yajra\DataTables\Facades\DataTables;

use App\Models\KategoriArtikel;


use Carbon\Carbon;

use Alert;


class KategoriArtikelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $btn    = '<a href="' .route('admin-kategoriartikel.index') . '" class="btn btn-secondary bg-gradient-secondary btn-sm mt-3 ms-auto">Kembali</a>';
        $page   = 'Content Management';
        $judul  = 'Kategori Artikel';
        $subjudul = 'Kategori Artikel Baru';
        $tombol = $btn;
        $aksi = '' .route('admin-kategoriartikel.store').'';

        $kategori = KategoriArtikel::get();

        return view('admin.kategoriartikel.form',[
            'btn'    => $btn,
            'page'  => $page,
            'judul'  => $judul,
            'subjudul'  => $subjudul,
            'tombol'  => $tombol, 
            'kategori' => $kategori,
            'aksi' => $aksi,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $artikel = new KategoriArtikel;
        
        $artikel->nama_kategori    = $request->nama_kategori;
        
        $artikel->save();

        return redirect()->route('admin-artikel.create')->with('success', 'Berhasil menambahkan data.');
    }

    /**
     * Display the specified resource.
     */
    public function show($artikel)
    {
        
    }

    public function edit($artikel)
    {
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
               
    }

   
}
