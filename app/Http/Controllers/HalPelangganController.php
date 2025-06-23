<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HalPelangganController extends Controller
{
      public function showPackages()
    {
        $pakets = Paket::all();
        return view('halamanpelanggan.dashboardpelanggan', compact('pakets'));
    }
}
