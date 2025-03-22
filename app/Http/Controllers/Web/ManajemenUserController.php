<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Http\Requests\UserRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;

use App\Models\User;


use Carbon\Carbon;

use Alert;


class ManajemenUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title  = 'Hapus Data!';
        $text   = "Data akan dihapus, Anda Yakin?";
        $btn    = '<a href="' . route('web.manajemen-user.create') . '" class="btn btn-info bg-gradient-info btn-sm mt-3 ms-auto">User Baru</a>';
        $page   = 'Content Management';
        $judul  = 'User';
        $subjudul = 'Administrasi User';
        $tombol = $btn; 

        confirmDelete($title, $text);

        $user   = User::get();

        return view('web.user.index',[
            'item' => $user,
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
        $btn    = '<a href="' .route('web.manajemen-user.index') . '" class="btn btn-secondary bg-gradient-secondary btn-sm mt-3 ms-auto">Kembali</a>';
        $page   = 'Content Management';
        $judul  = 'User';
        $subjudul = 'User Baru';
        $tombol = $btn;
        $aksi = '' .route('web.manajemen-user.store').'';

        return view('web.user.form',[
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
    public function store(UserRequest $request)
    {
        $user = new User;

        if($request->publish != ''){
            $publish = 'Y';
        }else{
            $publish = 'N';
        }

        if($request->role == 'Pangan')
        {
            $roleid = '1';
        }elseif($request->role == 'Pertanian'){
            $roleid = '2';
        }else{
            $roleid = '0';
        }
        
        
        $user->name     = $request->nama;
        $user->email    = $request->email;
        $user->password = Hash::make($request->password);
        $user->aktif    = $publish;
        $user->role     = $request->role;
        $user->role_id  = $roleid;
        $user->image    = '08_03_05_2021_05_25_Administrator.jpg';
            
        $user->save();

        return redirect()->route('web.manajemen-user.index')->with('success', 'Berhasil menambahkan user.');
    }

    /**
     * Display the specified resource.
     */
    public function show($user)
    {
        
    }

    public function edit($user)
    {
        $item =  User::where('id', $user)->firstOrFail();
        
        $btn    = '<a href="' .route('web.manajemen-user.index') . '" class="btn btn-secondary bg-gradient-secondary btn-sm mt-3 ms-auto">Kembali</a>';
        $page   = 'Content Management';
        $judul  = 'User';
        $subjudul = 'Update User';
        $tombol = $btn; 

        $aksi = '' .route('web.manajemen-user.update', $item->id).'';

        return view('web.user.form', compact('user'),[
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
     */
    public function update(Request $request, $id)
    {
        $user = User::where('id', $id)->firstOrFail();

        if($request->publish != ''){
            $publish = 'Y';
        }else{
            $publish = 'N';
        }

        if($request->role == 'Pangan')
        {
            $roleid = '1';
        }elseif($request->role == 'Pertanian'){
            $roleid = '2';
        }else{
            $roleid = '0';
        }
        
        
        $user->name     = $request->nama;
        $user->email    = $request->email;
        if($request->password != ''){
            $user->password = Hash::make($request->password);
        }
        $user->aktif    = $publish;
        $user->role     = $request->role;
        $user->role_id  = $roleid;
        $user->image    = '08_03_05_2021_05_25_Administrator.jpg';
            
        $user->save();


        return redirect()->route('web.manajemen-user.index')->with('success', 'Berhasil mengubah data.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $user = User::where('id', $id)->firstOrFail();
            $user->delete();

            return redirect('web/manajemen-user')->with(['success' => 'User berhasil dihapus.']);

        } catch (\Exception $e) {
            return redirect('web/manajemen-user')->with('error', 'Gagal, user tidak dapat dihapus.');
        }            
    }

    public function publish($id)
    {
        DB::table('users')->where('id', $id)->update([
            'aktif'  => 'Y'
        ]);

        return redirect('web/manajemen-user')->with(['success' => 'User berhasil diupdate.']);
        
    }
    
    public function notpublish($id)
    {
        DB::table('users')->where('id', $id)->update([
            'aktif'  => 'N'
        ]);

        return redirect('web/manajemen-user')->with(['success' => 'User berhasil diupdate.']);
    }
   
}
