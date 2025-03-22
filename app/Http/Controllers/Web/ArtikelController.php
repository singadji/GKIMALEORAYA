<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Http\Requests\ArtikelRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

use App\Models\Berita;
use App\Models\KategoriBerita;


use Carbon\Carbon;

use Alert;


class ArtikelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $title  = 'Hapus Data!';
        $text   = "Data akan dihapus, Anda Yakin?";
        $btn    = '<a href="' . route('web.berita-kegiatan.create') . '" class="btn btn-info bg-gradient-info btn-sm mt-3 ms-auto">Berata & Kegiatan Baru</a>';
        $page   = 'Content Management';
        $judul  = 'Berita & Kegiatan';
        $subjudul = 'Administrasi Berita & Kegiatan';
        $tombol = $btn; 

        confirmDelete($title, $text);

        $artikel   = Berita::getAll();

        return view('web.artikel.index',[
            'item' => $artikel,
            'btn'    => $btn,
            'page'  => $page,
            'judul'  => $judul,
            'subjudul'  => $subjudul,
            'tombol'  => $tombol,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $btn    = '<a href="' .route('web.berita-kegiatan.index') . '" class="btn btn-secondary bg-gradient-secondary btn-sm mt-3 ms-auto">Kembali</a>';
        $page   = 'Content Management';
        $judul  = 'Berita & Kegiatan';
        $subjudul = 'Berita & Kegiatan Baru';
        $tombol = $btn;
        $aksi = '' .route('web.berita-kegiatan.store').'';

        $kategori = KategoriBerita::get();
        
        return view('web.artikel.form',[
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
    public function store(ArtikelRequest $request)
    {
        $artikel = new Berita;

        $gambar     = $request->file('gambar');
        $penulis    = Auth::user()->id;
        
        if($request->publish != ''){
            $publish = '1';
        }else{
            $publish = '0';
        }
        if($request->isslider != ''){
            $isslider = '1';
        }else{
            $isslider = '0';
        }

        if($gambar){
            $gambarName = $request->gambar->getClientOriginalName();  
            $request->gambar->move(public_path('images/artikel'), $gambarName);
            
            $artikel->gambar     = $gambarName;
        }
        //else{
        //    $gambarName = '';
        //}
        
        $artikel->id_user    = $penulis;
        $artikel->id_kategori= $request->kategori;
        $artikel->judul      = $request->judul_artikel;
        $artikel->isi        = $request->isi_artikel;
        $artikel->slug       = Str::slug($request->judul_artikel, '-');
        //$artikel->gambar     = $gambarName;
        $artikel->publish    = $publish;
        $artikel->isslider   = $isslider;
        $artikel->tanggal    = Carbon::now();
        $artikel->waktu      = Carbon::now();
        $artikel->created_at = Carbon::now();
            
        $artikel->save();

        return redirect()->route('web.berita-kegiatan.index')->with('success', 'Berhasil menambahkan data.');
    }

    /**
     * Display the specified resource.
     */
    public function show($artikel)
    {
        
    }

    public function edit($artikel)
    {
        $item =  Berita::where('id_berita', $artikel)->firstOrFail();
        
        $btn    = '<a href="' .route('web.berita-kegiatan.index') . '" class="btn btn-secondary bg-gradient-secondary btn-sm mt-3 ms-auto">Kembali</a>';
        $page   = 'Content Management';
        $judul  = 'Berita & Kegiatan';
        $subjudul = 'Update Berita & Kegiatan';
        $tombol = $btn; 

        $aksi = '' .route('web.berita-kegiatan.update', $item->id_berita).'';

        $kategori = KategoriBerita::get();

        return view('web.artikel.form', compact('artikel'),[
            'btn'       => $btn,
            'page'      => $page,
            'judul'     => $judul,
            'subjudul'  => $subjudul,
            'tombol'    => $tombol, 
            'kategori'  => $kategori,
            'item'      => $item,
            'aksi'      => $aksi,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ArtikelRequest $request, $id)
    {
        $artikel = Berita::where('id_berita', $id)->firstOrFail();

        $gambar     = $request->file('gambar');
        
        if($request->publish != ''){
            $publish = '1';
        }else{
            $publish = '0';
        }
        if($request->isslider != ''){
            $isslider = '1';
        }else{
            $isslider = '0';
        }

        if($request->file('gambar')){
            $cekgbr = public_path().'images/artikel/'.$artikel->gambar;
                                
            if(file_exists($cekgbr)) {                    
                unlink($cekgbr);
            }
            
            $gambarName = $request->gambar->getClientOriginalName();  
            $request->gambar->move(public_path('images/artikel'), $gambarName);

            $artikel->gambar     = $gambarName;
        }
        $artikel->judul      = $request->judul_artikel;
        $artikel->isi        = $request->isi_artikel;
        $artikel->publish    = $publish;
        $artikel->isslider   = $isslider;
        $artikel->slug       = Str::slug($request->judul_artikel, '-');
        $artikel->updated_at = Carbon::now();
            
        $artikel->save();

        return redirect()->route('web.berita-kegiatan.index')->with('success', 'Berhasil mengubah data.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $artikel = Berita::where('id_berita', $id)->firstOrFail();
            $artikel->delete();

            if($artikel->gambar != ''){
                unlink(public_path().'/images/artikel/'.$artikel->gambar);

                return redirect('web/berita-kegiatan')->with(['success' => 'Data berhasil dihapus.']);
            }
        } catch (\Exception $e) {
            return redirect('web/berita-kegiatan')->with('error', 'Gagal, data tidak dapat dihapus.');
        }            
    }

    public function publish($id)
    {
        DB::table('beritas')->where('id_berita', $id)->update([
            'publish'  => '1'
        ]);

        return redirect('web/berita-kegiatan')->with(['success' => 'Artikel berhasil diupdate.']);
        
    }
    
    public function notpublish($id)
    {
        DB::table('beritas')->where('id_berita', $id)->update([
            'publish'  => '0'
        ]);

        return redirect('web/berita-kegiatan')->with(['success' => 'Artikel berhasil diupdate.']);
    }
    
    public function isslider($id)
    {
        DB::table('beritas')->where('id_berita', $id)->update([
            'isslider'  => '1'
        ]);

        return redirect('web/berita-kegiatan')->with(['success' => 'Artikel berhasil diupdate.']);
        
    }
    
    public function noslider($id)
    {
        DB::table('beritas')->where('id_berita', $id)->update([
            'isslider'  => '0'
        ]);

        return redirect('web/berita-kegiatan')->with(['success' => 'Artikel berhasil diupdate.']);
    }

   
}
