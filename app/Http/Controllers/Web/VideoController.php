<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Http\Requests\VideoRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

use App\Models\Video;


use Carbon\Carbon;

use Alert;


class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title  = 'Hapus Data!';
        $text   = "Data akan dihapus, Anda Yakin?";
        $btn    = '<a href="' . route('web.video.create') . '" class="btn btn-info bg-gradient-info btn-sm mt-3 ms-auto">Video Baru</a>';
        $page   = 'Content Management';
        $judul  = 'Video';
        $subjudul = 'Administrasi Video';
        $tombol = $btn; 

        confirmDelete($title, $text);

        $video   = Video::get();

        return view('web.video.index',[
            'item' => $video,
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
        $btn    = '<a href="' .route('web.video.index') . '" class="btn btn-secondary bg-gradient-secondary btn-sm mt-3 ms-auto">Kembali</a>';
        $page   = 'Content Management';
        $judul  = 'Video';
        $subjudul = 'Video Baru';
        $tombol = $btn;
        $aksi = '' .route('web.video.store').'';

        return view('web.video.form',[
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
    public function store(VideoRequest $request)
    {
        $video = new Video;

        if($request->publish != ''){
            $publish = '1';
        }else{
            $publish = '0';
        }
        
        
        $video->judul_video = $request->judul_video;
        $video->link_youtube = $request->link_youtube;
        $video->publish    = $publish;
            
        $video->save();

        return redirect()->route('web.video.index')->with('success', 'Berhasil menambahkan data.');
    }

    /**
     * Display the specified resource.
     */
    public function show($video)
    {
        
    }

    public function edit($video)
    {
        $item =  Video::where('id_video', $video)->firstOrFail();
        
        $btn    = '<a href="' .route('web.video.index') . '" class="btn btn-secondary bg-gradient-secondary btn-sm mt-3 ms-auto">Kembali</a>';
        $page   = 'Content Management';
        $judul  = 'Video & Kegiatan';
        $subjudul = 'Update Video & Kegiatan';
        $tombol = $btn; 

        $aksi = '' .route('web.video.update', $item->id_video).'';

        $kategori = KategoriVideo::get();

        return view('web.video.form', compact('video'),[
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
    public function update(VideoRequest $request, $id)
    {
        $video = Video::where('id_video', $id)->firstOrFail();

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
            $cekgbr = public_path().'images/video/'.$video->gambar;
                                
            if(file_exists($cekgbr)) {                    
                unlink($cekgbr);
            }
            
            $gambarName = $request->gambar->getClientOriginalName();  
            $request->gambar->move(public_path('images/video'), $gambarName);

            $video->gambar     = $gambarName;
        }
        $video->judul      = $request->judul_video;
        $video->isi        = $request->isi_video;
        $video->publish    = $publish;
        $video->isslider   = $isslider;
        $video->slug       = Str::slug($request->judul_video, '-');
        $video->updated_at = Carbon::now();
            
        $video->save();

        return redirect()->route('web.video.index')->with('success', 'Berhasil mengubah data.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $video = Video::where('id_video', $id)->firstOrFail();
            $video->delete();

            return redirect('web/video')->with(['success' => 'Data berhasil dihapus.']);

        } catch (\Exception $e) {
            return redirect('web/video')->with('error', 'Gagal, data tidak dapat dihapus.');
        }            
    }

    public function publish($id)
    {
        DB::table('videos')->where('id_video', $id)->update([
            'publish'  => '1'
        ]);

        return redirect('web/video')->with(['success' => 'Video berhasil diupdate.']);
        
    }
    
    public function notpublish($id)
    {
        DB::table('videos')->where('id_video', $id)->update([
            'publish'  => '0'
        ]);

        return redirect('web/video')->with(['success' => 'Video berhasil diupdate.']);
    }
   
}
