<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Guide;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotifGuideController extends Controller
{

public function guidesWithPesanan()
{
    $guides = Guide::whereHas('pesanans')
        ->with(['notifikasis' => function($query) {
            $query->latest('tanggal_kirim')->limit(1);
        }])
        ->get();

    // Loop dan set status tampilan otomatis
    foreach ($guides as $guide) {
        $notif = $guide->notifikasis->first();
        if ($notif) {
            if ($notif->status === 'notif belum terkirim') {
                $notif->status_display = 'notif pending masih di proses';
            } else {
                $notif->status_display = $notif->status;
            }
        } else {
            $notif = new \stdClass();
            $notif->status_display = '-';
            $notif->tanggal_kirim = null;
            $notif->isi = '-';
        }
        // Supaya mudah akses di blade, simpan ke properti khusus
        $guide->latest_notif = $notif;
    }

    return view('notifguide.index', compact('guides'));
}

public function show($id)
{
    $guide = Guide::with(['notifikasis' => function ($query) {
        $query->latest('tanggal_kirim')->limit(1);
    }])->findOrFail($id);

    // Siapkan notifikasi terbaru
    $notif = $guide->notifikasis->first();

    if ($notif) {
        $notif->status_display = $notif->status === 'notif belum terkirim'
            ? 'notif pending masih di proses'
            : $notif->status;
    } else {
        $notif = new \stdClass();
        $notif->status_display = '-';
        $notif->tanggal_kirim = null;
        $notif->isi = '-';
    }

    $guide->latest_notif = $notif;

    return view('notifguide.show', compact('guide'));
}





// public function sendNotifToGuide($id)
// {
//     $guide = Guide::findOrFail($id);

//     // Ganti "0" di awal nomor jadi "62" untuk format internasional
//     $phone = preg_replace('/^0/', '62', $guide->nomer_hp);

//     // Kirim pesan via Fonnte
//         $response = Http::withHeaders([
//             'Authorization' => 'HbHggEjszXST3WxTchcd' // Ganti dengan API key dari Fonnte
//         ])->post('https://api.fonnte.com/send', [
//             'target' => $phone,
//             'message' => "Haloo {$guide->nama_guide}, Anda terpilih untuk melakukan guiding.\nSilakan login untuk melihat detailnya:\nhttp://localhost:8000/login",
//         ]);


//     if ($response->successful()) {
//         return back()->with('success', 'Pesan berhasil dikirim via Fonnte!');
//     } else {
//         return back()->with('error', 'Gagal kirim pesan: ' . $response->body());
//     }
// }
}
