<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\IdentitasWeb;


class WebController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $identitas = identitas::select('*')->first();

        if($_SERVER["REQUEST_METHOD"] == "POST") {
		
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

            DB::table('identitas')->where('id','1')->update([
                    'nama_perusahaan'   => $request->nama_perusahaan,
                    'url'               => $request->url,
                    'email'             => $request->email,
                    'alamat'            => $request->alamat,
                    'no_telp'           => $request->telepon,
                    'facebook'          => $request->facebook,
                    'meta_deskripsi'    => $request->deskripsi,
                    'profil'            => $request->profil,
                    'meta_keyword'      => $request->keyword,
                    'logo'              => $imageName,
                    'instagram'         => $request->instagram,
                    'youtube'           => $request->youtube,
                ]);
            }
            else{
                DB::table('identitas')->where('id','1')->update([
                    'nama_perusahaan'   => $request->nama_perusahaan,
                    'url'               => $request->url,
                    'email'             => $request->email,
                    'alamat'            => $request->alamat,
                    'maps'              => $request->maps,
                    'no_telp'           => $request->telepon,
                    'facebook'          => $request->facebook,
                    'meta_deskripsi'    => $request->deskripsi,
                    'meta_keyword'      => $request->keyword,
                    'profil'            => $request->profil,
                    'instagram'         => $request->instagram,
                    'youtube'           => $request->youtube,
                ]);

            }
        
            return redirect('admin-identitasweb')->with(['sukses' => 'Data berhasil disimpan.']);
        
        }

        return view('admin/identitas/identitas', ['identitas' => $identitas]);
    }

    /**
     * Show the form for creating a new resource. 
     *
     * @return \Illuminate\Http\Response
     */

}
