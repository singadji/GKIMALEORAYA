<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\bankunit;
use App\Models\master_sampah;
use App\Models\transaksisampahunit;
use App\Models\transaksisampahunitrequest;
use App\Models\user;

use App\Helpers\FunctionHelper;

use Illuminate\Support\Facades\DB;

use Alert;
use Charts;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
       
        
        return view('admin/menu.menu', [
            
        ]);
    }
    
}
