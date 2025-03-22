<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Http\Requests\IdentitasWebRequest;
use Yajra\DataTables\Facades\DataTables;

use App\Models\IdentitasWeb;

use Carbon\Carbon;

use Alert;


class IdentitasWebController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $item =  IdentitasWeb::firstOrFail();

        //$title  = 'Hapus Data!';
        //$text   = "Data akan dihapus, Anda Yakin?";
        $btn    = '';
        $page   = 'Content Management';
        $judul  = 'Identitas Web';
        $subjudul = 'Update Identitas Web';
        $tombol = $btn; 
        
        $aksi = '' .url('web/identitas-web', $item->slug).'';

        $identitas = IdentitasWeb::select('*')->first();

        if ($request->isMethod('post')) {
		
            request()->validate([
                'nama_perusahaan'   => 'required',
                'url'               => 'required',
                'email'             => 'required',
                'alamat'            => 'required',
                'telepon'           => 'required',
                'facebook'          => 'required',
                'deskripsi'         => 'required',
                'keyword'           => 'required',
                'logo'              => 'file|image|mimes:jpeg,png,jpg|max:8024',
                'favicon'           => 'file|image|mimes:png|max:8024',
            ]);

            $logo                  = $request->file('logo');

        if(!empty($logo)) {
            
            $imageName = time().'.'.$request->logo->extension();  
     
            $request->logo->move(public_path('img/logo'), $imageName);

            DB::table('identitaswebs')->where('id','1')->update([
                    'nama_website'   => $request->nama_perusahaan,
                    'url'               => $request->url,
                    'email'             => $request->email,
                    'alamat'            => $request->alamat,
                    'no_telp'           => $request->telepon,
                    'facebook'          => $request->facebook,
                    'meta_deskripsi'    => $request->deskripsi,
                    //'profil'            => $request->profil,
                    'meta_keyword'      => $request->keyword,
                    'logo'              => $imageName,
                    'instagram'         => $request->instagram,
                    'youtube'           => $request->youtube,
                ]);
            }
            else{
                DB::table('identitaswebs')->where('id','1')->update([
                    'nama_website'   => $request->nama_perusahaan,
                    'url'               => $request->url,
                    'email'             => $request->email,
                    'alamat'            => $request->alamat,
                    'maps'              => $request->maps,
                    'no_telp'           => $request->telepon,
                    'facebook'          => $request->facebook,
                    'meta_deskripsi'    => $request->deskripsi,
                    'meta_keyword'      => $request->keyword,
                    //'profil'            => $request->profil,
                    'instagram'         => $request->instagram,
                    'youtube'           => $request->youtube,
                ]);

            }
        
            return redirect('web/identitas-web')->with('success', 'Berhasil mengubah data.');
        
        }

        return view('web.identitas.index',[
            'item' => $item,
            'btn'    => $btn,
            'page'  => $page,
            'judul'  => $judul,
            'subjudul'  => $subjudul,
            'tombol'  => $tombol,
            'aksi' => $aksi,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(IdentitasWebRequest $request)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

    public function publish($id)
    {
       //
        
    }
    
    public function notpublish($id)
    {
       //
    }

   
}
