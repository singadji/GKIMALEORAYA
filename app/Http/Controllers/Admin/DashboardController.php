<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Identitas;

use Image;
use PDF;

class DashboardController extends Controller
{


    // Index
    public function index()
    {
        return view('admin.dashboard.dashboard');
    }
}
