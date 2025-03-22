<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Models\ContactUS;
use App\Models\Modul;

use Carbon\Carbon;

class KontakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kontak   = ContactUS::get();

        return view('admin.kontak.kontak',['kontak' => $kontak]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Il
     * luminate\Http\Response
     */
    public function delete(Request $request, $id)
    {
        $kontak = ContactUS::select('*')
            ->where('id', $id)
            ->first();

        DB::table('contactus')->where('id', $id)->delete();

        return redirect('admin-kontak')->with(['sukses' => 'Data berhasil dihapus.']);
    }
}
