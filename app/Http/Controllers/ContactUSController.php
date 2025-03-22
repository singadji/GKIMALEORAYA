<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\ContactUS;

use App\Models\identitas;

class ContactUSController extends Controller
{
   /***
    * Show the application dashboard.
    *
    * @return \Illuminate\Http\Response
    */
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
        
               ContactUS::create($request->all());
        
               return back()->with('success', 'Thanks for contacting us!');
        }
    
        $page = array(
            "header_img" => "hero-bg1.png",
            "nama_menu"  => "Kontak Kami",
        );

        $identitas = identitas::first();

       return view('contactUS', ['page'=>$page, 'identitas'=>$identitas, ]);
   }
}