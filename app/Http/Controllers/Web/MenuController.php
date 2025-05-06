<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Http\Requests\MenuRequest;
use Yajra\DataTables\Facades\DataTables;

use App\Models\Menu;
use App\Models\Modul;
use App\Models\Gambar;

use Carbon\Carbon;

use Alert;


class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title  = 'Hapus Data!';
        $text   = "Data akan dihapus, Anda Yakin?";
        $btn    = '<a href="' . route('web.menu.create') . '" class="btn btn-info bg-gradient-info btn-sm mt-3 ms-auto">Menu Baru</a>';
        $page   = 'Content Management';
        $judul  = 'Menu';
        $subjudul = 'Administrasi Menu';
        $tombol = $btn; 

        confirmDelete($title, $text);

        $menu   = Menu::select('*')
                    ->orderby('posisi', 'ASC')
                    ->get();

        return view('web.menu.index',[
            'item' => $menu,
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
        $btn    = '<a href="' .route('web.menu.index') . '" class="btn btn-secondary bg-gradient-secondary btn-sm mt-3 ms-auto">Kembali</a>';
        $page   = 'Content Management';
        $judul  = 'Menu';
        $subjudul = 'Menu Baru';
        $tombol = $btn;
        $aksi = '' .route('web.menu.store').'';

        $parent = Menu::where('link_menu', '#')
            ->orderby('posisi', 'ASC')
            ->get();

        return view('web.menu.form',[
            'btn'    => $btn,
            'page'  => $page,
            'judul'  => $judul,
            'subjudul'  => $subjudul,
            'tombol'  => $tombol, 
            'parent' => $parent,
            'aksi' => $aksi,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MenuRequest $request)
    {
        $menu = new Menu;

        $gambar     = $request->file('images');
        $dokumen    = $request->file('dokumen');
        $video      = $request->file('video');

        if($request->aktif != ''){
            $aktif = 'Y';
        }else{
            $aktif = 'T';
        }
        
        if($gambar){
            $imageName = $request->images->getClientOriginalName();  
            $request->images->move(public_path('images/menu'), $imageName);
            
            $menu->nama_menu    = $request->nama_menu;
            $menu->link_menu    = $request->link_menu;
            $menu->id_parent    = $request->parent;
            $menu->isi_menu     = $request->isi_menu;
            $menu->gambar       = $imageName;
            $menu->slug         = Str::slug($request->nama_menu, '-');
            $menu->posisi       = $request->posisi;
            $menu->publish      = $aktif;
            $menu->created_at   = Carbon::now();
        }
        elseif($dokumen){
            $dokumenName = $request->dokumen->getClientOriginalName();  
            $request->dokumen->move(public_path('files'), $dokumenName);
            
            $menu->nama_menu    = $request->nama_menu;
            $menu->link_menu    = $request->link_menu;
            $menu->slug         = Str::slug($request->nama_menu, '-');
            $menu->id_parent    = $request->parent;
            $menu->isi_menu     = $request->isi_menu;
            $menu->dokumen      = $dokumenName;
            $menu->dokumen_cap  = $request->dokumen_cap;
            $menu->posisi       = $request->posisi;
            $menu->publish       = $aktif;
            $menu->created_at   = Carbon::now();
        }
        elseif($video){
            $videoName = $request->video->getClientOriginalName();  
            $request->video->move(public_path('videos'), $videoName);

            $menu->nama_menu    = $request->nama_menu;
            $menu->slug         = Str::slug($request->nama_menu, '-');
            $menu->link_menu    = $request->link_menu;
            $menu->id_parent    = $request->parent;
            $menu->isi_menu     = $request->isi_menu;
            $menu->video        = $videoName;
            $menu->video_cap    = $request->video_cap;
            $menu->posisi       = $request->posisi;
            $menu->publish       = $aktif;
            $menu->created_at   = Carbon::now();

        }
        else{
            $menu->slug         = Str::slug($request->nama_menu, '-');
            $menu->nama_menu    = $request->nama_menu;
            $menu->link_menu    = $request->link_menu;
            $menu->id_parent    = $request->parent;
            $menu->isi_menu     = $request->isi_menu;
            $menu->posisi       = $request->posisi;
            $menu->publish      = $aktif;
            $menu->created_at   = Carbon::now();
        }

        $menu->save();

        return redirect()->route('web.menu.index')->with('success', 'Berhasil menambahkan data.');
    }

    /**
     * Display the specified resource.
     */
    public function show($menu)
    {
        
    }

    public function edit($menu)
    {
        $item =  Menu::where('id', $menu)->firstOrFail();
        
        $btn    = '<a href="' .route('web.menu.index') . '" class="btn btn-secondary bg-gradient-secondary btn-sm mt-3 ms-auto">Kembali</a>';
        $page   = 'Content Management';
        $judul  = 'Menu';
        $subjudul = 'Update Menu';
        $tombol = $btn; 

        $aksi = '' .route('web.menu.update', $item->id).'';

        $parent = Menu::where('link_menu', '#')
            ->orderby('posisi', 'ASC')
            ->get();

        return view('web.menu.form', compact('menu'),[
            'btn'       => $btn,
            'page'      => $page,
            'judul'     => $judul,
            'subjudul'  => $subjudul,
            'tombol'    => $tombol, 
            'parent'    => $parent,
            'item'      => $item,
            'aksi'      => $aksi,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $menu = Menu::where('id', $id)->firstOrFail();

        if($request->aktif != ''){
            $aktif = 'Y';
        }else{
            $aktif = 'T';
        }
        
        $gambar     = $request->file('images');
        $dokumen    = $request->file('dokumen');
        $video      = $request->file('video');
        
        if($gambar){
            $cekgbr = public_path().'images/menu/'.$menu->gambar;
                                
                if(file_exists($cekgbr)) {
                                
                    unlink($cekgbr);
                }

            $imageName = $request->images->getClientOriginalName();  
            $request->images->move(public_path('images/menu'), $imageName);
            
            $menu->nama_menu    = $request->nama_menu;
            $menu->link_menu    = $request->link_menu;
            $menu->slug         = Str::slug($request->nama_menu, '-');
            $menu->id_parent    = $request->parent;
            $menu->isi_menu     = $request->isi_menu;
            $menu->gambar       = $imageName;
            $menu->posisi       = $request->posisi;
            $menu->publish      = $aktif;
            $menu->updated_at   = Carbon::now();
        }
        elseif($dokumen){
            $cekdok = public_path().'files/'.$menu->dokumen;
                                
                if(file_exists($cekdok)) {
                                
                    unlink($cekdok);
                }

            $dokumenName = $request->dokumen->getClientOriginalName();  
            $request->dokumen->move(public_path('files'), $dokumenName);
            
            $menu->nama_menu    = $request->nama_menu;
            $menu->link_menu    = $request->link_menu;
            $menu->slug         = Str::slug($request->nama_menu, '-');
            $menu->id_parent    = $request->parent;
            $menu->isi_menu     = $request->isi_menu;
            $menu->dokumen      = $dokumenName;
            $menu->dokumen_cap  = $request->dokumen_cap;
            $menu->posisi       = $request->posisi;
            $menu->publish       = $aktif;
            $menu->updated_at   = Carbon::now();
        }
        elseif($video){
            $cekvid = public_path().'files/'.$menu->video;
                                
                if(file_exists($cekvid)) {
                                
                    unlink($cekvid);
                }

            $videoName = $request->video->getClientOriginalName();  
            $request->video->move(public_path('videos'), $videoName);

            $menu->nama_menu    = $request->nama_menu;
            $menu->link_menu    = $request->link_menu;
            $menu->id_parent    = $request->parent;
            $menu->slug         = Str::slug($request->nama_menu, '-');
            $menu->isi_menu     = $request->isi_menu;
            $menu->video        = $videoName;
            $menu->video_cap    = $request->video_cap;
            $menu->posisi       = $request->posisi;
            $menu->publish       = $aktif;
            $menu->updated_at   = Carbon::now();

        }
        else{
            $menu->nama_menu    = $request->nama_menu;            
            $menu->slug         = Str::slug($request->nama_menu, '-');
            $menu->link_menu    = $request->link_menu;
            $menu->id_parent    = $request->parent;
            $menu->isi_menu     = $request->isi_menu;
            $menu->posisi       = $request->posisi;
            $menu->publish      = $aktif;
            $menu->updated_at   = Carbon::now();
        }

        $menu->save();

        return redirect()->route('web.menu.index')->with('success', 'Berhasil mengubah data.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $menu = menu::where('id', $id)->firstOrFail();
            $menu->delete();

            if($menu->gambar != ""){
                unlink(public_path().'/images/menu/'.$menu->gambar);    
            }
    
            if($menu->dokumen != ""){
                unlink(public_path().'/files/'.$menu->dokumen);
            }
    
            if($menu->video != ""){
                unlink(public_path().'/videos/'.$menu->video);
            }
    
            return redirect('web/menu')->with(['success' => 'Data berhasil dihapus.']);
        } catch (\Exception $e) {
            return redirect('web/menu')->with('error', 'Gagal, data tidak dapat dihapus.');
        }            
    }

    public function publish($id)
    {
        DB::table('menus')->where('id', $id)->update([
            'publish'  => 'Y'
        ]);

        return redirect('web/menu')->with(['success' => 'Menu berhasil diupdate.']);
        
    }
    
    public function notpublish($id)
    {
        DB::table('menus')->where('id', $id)->update([
            'publish'  => 'T'
        ]);

        return redirect('web/menu')->with(['success' => 'Menu berhasil diupdate.']);
    }

   
}
