<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\popup;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Http;

use GuzzleHttp\Client;

use Illuminate\Support\Facades\DB;

use Carbon\Carbon;


class PopupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = popup::get();

        return view('admin.popup.popup')->with('popup', $data); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.popup.frmPopup');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validasi = Validator::make($request->all(),[
            'publish'   =>'required',
            'gambar'    =>'required|image|mimes:jpeg,png,jpg|max:8024',
        ]);

        if($validasi->fails()) {
            return redirect()->back()->withErrors($validasi)->withInput($request->input());
        }

        $gambar_img     = $request->file('gambar');
        $gambarName_img = 'popup' . $request->judul . strtolower($gambar_img->getClientOriginalName());

        $request->gambar->move(public_path('images/banner'), $gambarName_img);

        $uuid = Str::uuid();
        $popup = new popup;
        $popup->uuid       = $uuid;
        $popup->judul      = $request->judul;
        $popup->keterangan = $request->keterangan;
        $popup->judul_link = $request->judul_link;
        $popup->link       = $request->link;
        $popup->gambar     = $gambarName_img;
        $popup->publish    = $request->publish;

        $popup->save();

        return redirect()->route('admin-popup.index')
                       ->with('success','Gambar popup berhasil ditambah.');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(popup $popup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(popup $popup, $uuid)
    {
        $data = popup::where('uuid', $uuid)->first();

        return view('admin.popup.frmPopup')->with('popup', $data); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, popup $popup, $uuid)
    {
        $popup = popup::where('uuid', $uuid)->first();

        $popup->judul      = $request->judul;
        $popup->keterangan = $request->keterangan;
        $popup->judul_link = $request->judul_link;
        $popup->link       = $request->link;
        $popup->publish    = $request->publish;
        
        if($request->file('gambar') != ''){

            if($popup->gambar != ''){
                unlink(public_path('images/banner/').$popup->gambar);
            }

            $gambar_img     = $request->file('gambar');
            $gambarName_img = 'popup' . $request->judul . strtolower($gambar_img->getClientOriginalName());

            $request->gambar->move(public_path('images/banner'), $gambarName_img);
        
            $popup->gambar     = $gambarName_img;
        }   

        $popup->save();
       
        return redirect()->route('admin-popup.index')
                       ->with('success','popup berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,$uuid)
    {   
        $popup = popup::where('uuid', '=', $request->uuid)->first();

        if($popup != null){
            $popup->delete();
            
            unlink(public_path('images/banner/').$popup->gambar);

            return redirect()->route('admin-popup.index')
                        ->with('success','popup berhasil dihapus.');
        }
        return redirect('admin-popup')
                        ->with('warning','Data tidak ada.');
    }

    public function publish($uuid)
    {
        $popup = popup::where('uuid', $uuid)->first();

        $popup->publish = 'Y';

        $popup->save();
       
        return redirect()->route('admin-popup.index')
                       ->with('success','popup berhasil dipublish.');
    }

    public function notpublish($uuid)
    {
        $popup = popup::where('uuid', $uuid)->first();

        $popup->publish = 'T';

        $popup->save();
       
        return redirect()->route('admin-popup.index')
                       ->with('success','popup berhasil diunpublish.');
    }
}
