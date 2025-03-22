<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Http\Requests\FotoRequest;
use App\Http\Requests\AlbumRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

use App\Models\Foto;
use App\Models\Album;


use Carbon\Carbon;

use Alert;

class FotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title  = 'Hapus Data!';
        $text   = "Data akan dihapus, Anda Yakin?";
        $btn    = '<a href="' . route('web.album-foto.create') . '" class="btn btn-info bg-gradient-info btn-sm mt-3 ms-auto">Album Foto Baru</a>';
        $page   = 'Content Management';
        $judul  = 'Album Foto';
        $subjudul = 'Administrasi Album Foto';
        $tombol = $btn; 

        confirmDelete($title, $text);

        $album  = Album::get();

        $fotos   = foto::join('albums', 'albums.id_album', '=', 'fotos.id_album')
                    ->orderby('albums.nama_album')
                    ->get();

        //administrasi foto
        
        return view('web.foto.index')
            ->with('foto', $fotos)
            ->with('btn', $btn)
            ->with('page', $page)
            ->with('judul', $judul)
            ->with('subjudul', $subjudul)
            ->with('tombol', $tombol)
            ->with('item', $album)
        ;
    }

    public function simpan(Request $request)
    {
       
        request()->validate([
            'foto' => 'file|required|image|mimes:jpeg,png,jpg|max:8024',
        ]);
        $gambar     = $request->file('foto');
                    
        if(!empty($gambar)) {
        
            $imageName = $request->foto->getClientOriginalName();   
                 
            $request->foto->move(public_path('images/foto'), $imageName);
            $foto = new Foto;
            $foto->id_album   = $request->id;
            $foto->judul_foto = $request->judul_foto;
            $foto->foto       = $imageName;
                
            $foto->save();
            return redirect('web/album-foto')
                ->with('success','Foto berhasil disimpan.');
            }
    
    }

    public function create()
    {
        $btn    = '<a href="./" class="btn btn-secondary bg-gradient-secondary btn-sm mt-3 ms-auto">Kembali</a>';
        $page   = 'Content Management';
        $judul  = 'Amlbum Foto';
        $subjudul = 'Album Baru';
        $tombol = $btn;
        $aksi = '' .route('web.album-foto.store').'';

        return view('web.foto.form',[
            'btn'    => $btn,
            'page'  => $page,
            'judul'  => $judul,
            'subjudul'  => $subjudul,
            'tombol'  => $tombol, 
            'aksi' => $aksi,
            'stat' => 'ins',
        ]);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AlbumRequest $request)
    {
        if($request->publish != ''){
            $publish = '1';
        }else{
            $publish = '0';
        }
        
            $album = new Album;
            $album->nama_album = $request->nama_album;
            $album->keterangan = $request->keterangan;
            $album->publish = $publish;
            $album->slug = Str::slug($request->nama_album, '-');
            $album->save();

            $idAlbum = DB::table('albums')->get()->last()->id_album;

            $foto = [];
            
            foreach($request->file('foto') as $key => $fto)
            {
        
                $file_name = time().rand(1,99).'.'.$fto->extension();  

                $fto->move(public_path('images/foto'), $file_name);
                
                $f = new foto;
                $f->id_album = $idAlbum;
                $f->judul_foto = $request->nama_album.'-'.$file_name;
                $f->foto = $file_name;
                $f->save();

            }

            return redirect('web/album-foto')->with(['success' => 'Data berhasil disimpan.']);

    }

    public function edit($album)
    {
        $item =  Album::where('id_album', $album)->firstOrFail();
        
        $btn    = '<a href="' .route('web.album-foto.index') . '" class="btn btn-secondary bg-gradient-secondary btn-sm mt-3 ms-auto">Kembali</a>';
        $page   = 'Content Management';
        $judul  = 'Album Foto';
        $subjudul = 'Update Album Foto';
        $tombol = $btn; 

        $aksi = '' .route('web.album-foto.update', $item->id_album).'';

        return view('web.foto.form', compact('album'),[
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
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $album = Album::where('id_album', $id)->firstOrFail();
 
        if($request->publish != ''){
            $publish = '1';
        }else{
            $publish = '0';
        }

        $album->nama_album = $request->nama_album;
        $album->keterangan = $request->keterangan;
        $album->publish    = $publish;
        $album->slug = Str::slug($request->nama_album, '-');

        $album->save();
        
        return redirect()->route('web.album-foto.index')->with('success', 'Berhasil mengubah data.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $id)
    {
        $foto = Foto::where('id_foto', $id)
                    ->first();

        DB::table('fotos')->where('id_foto', $id)->delete();
        
        unlink(public_path().'/images/foto/'.$foto->foto);

        return redirect('web/album-foto')
            ->with('success','Foto berhasil dihapus.');
    }


    public function destroy(Request $request, $id)
    {
        $album = Album::where('id_album', $id)->first();

        $jmlfoto = Foto::select('*')
                    ->where('id_album', $album->id)
                    ->count();

        $foto = Foto::select('*')
                    ->where('id_album', $album->id_album)
                    ->get();
        
        foreach($foto as $fotoD){
        
            unlink(public_path().'/images/foto/'.$fotoD->foto);
        }

        DB::table('fotos')->where('id_album', $album->id_album)->delete();
        DB::table('albums')->where('id_album', $id)->delete();
        
        return redirect('web/album-foto')->with(['success' => 'Album berhasil dihapus.']);
    }

 public function publish($id)
    {
        DB::table('albums')->where('id_album', $id)->update([
            'publish'  => '1'
        ]);

        return redirect('web/album-foto')->with(['success' => 'Berita berhasil diupdate.']);
        
    }
    
    public function notpublish($id)
    {
        DB::table('albums')->where('id_album', $id)->update([
            'publish'  => '0'
        ]);

        return redirect('web/album-foto')->with(['success' => 'Berita berhasil diupdate.']);
    }

    /**
     * Display the specified resource.
     */
    public function show($artikel)
    {
        
    }


}
