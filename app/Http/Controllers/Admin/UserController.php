<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

use App\Models\User;

use Alert;

use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index(Request $request, $id)
    {

        if($_SERVER["REQUEST_METHOD"] == "POST") {
            
            if(!empty($request->password)){
                request()->validate([
                    'password'          => ['required', 'min:8'],
                    'confirm_password'  => 'required|same:password',
                ], [
                    'password.required' => 'Password harus diisi.',
                    'password.min'      => 'Password minimal 8 karakter.',
                    'confirm_password.same' => 'Password tidak sama.'
                ]);
            }
            
            $user = User::where('id', $id)->firstOrFail();
            $user->password = Hash::make($request->password);
            $user->save();

            return redirect('admin.home')->with('success', 'Password berhasil diupdate, silahkan logout dan login kembali.');

          
        }

        $item =  User::where('id', $id)->firstOrFail();
        
        $btn    = '<a href="' .asset('admin/home') . '" class="btn btn-secondary bg-gradient-secondary btn-sm mt-3 ms-auto">Batal</a>';
        $page   = 'Content Management';
        $judul  = 'User';
        $subjudul = 'Update Password';
        $tombol = $btn; 

        $aksi = '' .route('web.manajemen-user.update', $item->id).'';

        return view('admin.user.form', compact('id'),[
            'btn'       => $btn,
            'page'      => $page,
            'judul'     => $judul,
            'subjudul'  => $subjudul,
            'tombol'    => $tombol, 
            'item'      => $item,
            'aksi'      => $aksi,
        ]);
    }

    
}
