<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Menu;
use App\Models\Foto;
use App\Models\Album;
use App\Models\Berita;
use App\Models\Video;
use App\Models\Identitas;
use App\Models\ContactUS;

use App\Http\Controllers\Controller;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;

class PageController extends Controller 
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function detail($slug)
    {
        $page = menu::where('link_menu',$slug)->first();

        if($page){
            return view('menu.menu')
                ->with('page', $page);
        }else{
            return abort(404);
        }
    }

    public function foto()
    {
        $page = menu::select('*')
                ->where('link_menu','foto')
                ->first();

        $album  = Album::where('publish',1)->get();
        $foto   = Foto::join('albums', 'albums.id_album', '=', 'fotos.id_album')
                    ->where('publish', 1)
                    ->orderby('albums.id_album')
                    //->paginate(6);
                    ->get();
        
        return view('menu.foto')
            ->with('album', $album)
            ->with('foto', $foto)
            ->with('title', 'Foto Dokumentasi Kegiatan');
    }

    public function video()
    {
        $video  = video::where('publish','Y')->paginate(6);
        return view('menu.video')
            ->with('video', $video)
            ->with('title', 'Video Dokumentasi Kegiatan');
    }

    public function news()
    {
        $berita = Berita::getArt();
        $beritaT= Berita::getArtB();

		return view('menu.berita')
            ->with('berita', $berita)
            ->with('beritabaru', $beritaT)
             ->with('title', 'Berita');

    }

    public function baca($id)
    {
        $berita = Berita::join('users', 'beritas.id_user', '=', 'users.id')
            ->where('id_berita',$id)
            ->first();
        $baca = $berita->baca + 1;

        $beritaL = $beritaT= Berita::getArtB();

        DB::table('beritas')->where('id_berita', $id)->update([
            'baca'  => $baca,
        ]);

     	return view('menu.bacaberita')
            ->with('news', $berita)
            ->with('lain', $beritaL) 
            ->with('link', 'Berita');
    }

    public function contactUS(Request $request)
    {
        if($_SERVER["REQUEST_METHOD"] == "POST"){

            $this->validate($request, [
                'name'      => 'required',
                'email'     => 'required|email',
                'telepon'   => 'required',
                'subject'   => 'required',
                'message'   => 'required'
                ]);

                $identitas = identitas::first();
        
               ContactUS::create($request->all());
        
               return view('contactUS', ['identitas'=>$identitas, ])->with('success', 'Terima kasih telah menghubungi kami!');
        }
    
        $identitas = identitas::first();

        return view('contactUS', ['identitas'=>$identitas, ]);
    }

    
}
