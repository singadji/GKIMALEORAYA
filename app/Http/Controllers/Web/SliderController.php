<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Http;

use GuzzleHttp\Client;

use Illuminate\Support\Facades\DB;

use Carbon\Carbon;


class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Slider::get();

        return view('admin.slider.slider')->with('slider', $data); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.slider.frmSlider');
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
        $gambarName_img = 'slider' . $request->judul . strtolower($gambar_img->getClientOriginalName());

        $request->gambar->move(public_path('images/banner'), $gambarName_img);

        $uuid = Str::uuid();
        $slider = new Slider;
        $slider->uuid       = $uuid;
        $slider->judul      = $request->judul;
        $slider->keterangan = $request->keterangan;
        $slider->judul_link = $request->judul_link;
        $slider->link       = $request->link;
        $slider->gambar     = $gambarName_img;
        $slider->publish    = $request->publish;

        $slider->save();

        return redirect()->route('admin-slider.index')
                       ->with('success','Slider berhasil ditambah.');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slider $slider, $uuid)
    {
        $data = Slider::where('uuid', $uuid)->first();

        return view('admin.slider.frmSlider')->with('slider', $data); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slider $slider, $uuid)
    {
        $slider = Slider::where('uuid', $uuid)->first();

        $slider->judul      = $request->judul;
        $slider->keterangan = $request->keterangan;
        $slider->judul_link = $request->judul_link;
        $slider->link       = $request->link;
        $slider->publish    = $request->publish;
        
        if($request->file('gambar') != ''){

            if($slider->gambar != ''){
                unlink(public_path('images/banner/').$slider->gambar);
            }

            $gambar_img     = $request->file('gambar');
            $gambarName_img = 'slider' . $request->judul . strtolower($gambar_img->getClientOriginalName());

            $request->gambar->move(public_path('images/banner'), $gambarName_img);
        
            $slider->gambar     = $gambarName_img;
        }   

        $slider->save();
       
        return redirect()->route('admin-slider.index')
                       ->with('success','Slider berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,$uuid)
    {   
        $slider = Slider::where('uuid', '=', $request->uuid)->first();

        if($slider != null){
            $slider->delete();
            
            unlink(public_path('images/banner/').$slider->gambar);

            return redirect()->route('admin-slider.index')
                        ->with('success','Slider berhasil dihapus.');
        }
        return redirect('admin-slider')
                        ->with('warning','Data tidak ada.');
    }

    public function publish($uuid)
    {
        $slider = Slider::where('uuid', $uuid)->first();

        $slider->publish = 'Y';

        $slider->save();
       
        return redirect()->route('admin-slider.index')
                       ->with('success','Slider berhasil dipublish.');
    }

    public function notpublish($uuid)
    {
        $slider = Slider::where('uuid', $uuid)->first();

        $slider->publish = 'T';

        $slider->save();
       
        return redirect()->route('admin-slider.index')
                       ->with('success','Slider berhasil diunpublish.');
    }
}
