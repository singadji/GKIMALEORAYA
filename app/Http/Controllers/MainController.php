<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Berita;
use App\Models\Foto;
use App\Models\Menu;
use App\Models\IdentitasWeb;
use App\Models\Slider;
use App\Models\Album;

use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class MainController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        

        return view('menu.main');
    }
}
