<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Pesanan; // Make sure to import the Pesanan model

class HalguideController extends Controller
{

public function index()
{
    $user = Auth::user();
    $guide = Guide::where('user_id', $user->id)->first();

    if (!$guide) {
        \Log::info('Guide tidak ditemukan untuk user id: ' . $user->id);
        return view('halamanguide.index', ['pesanans' => collect()]);
    }

    \Log::info('Guide ditemukan, ID: ' . $guide->id);

$pesanans = Pesanan::with(['guide', 'kriterias', 'paket']) // SUKSES
        ->where('id_guide', $guide->id)
        ->where('status', 1) // <-- tambahkan ini jika hanya ingin status tertentu
        ->get();

    \Log::info('Jumlah pesanan ditemukan: ' . $pesanans->count());

    return view('halamanguide.index', compact('pesanans'));
}










public function showguide($id)
{
    $pesanan = Pesanan::with(['guide', 'paket', 'kriterias'])->findOrFail($id);
    return view('halamanguide.show', compact('pesanan'));
}





}
