<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\Guide;
use App\Models\Notifikasi;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendNotifGuideJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    public function __construct(public int $guideId) {}

public function handle(): void
{
    $guide = Guide::findOrFail($this->guideId);
    $phone = preg_replace('/^0/', '62', $guide->nomer_hp);

    Carbon::setLocale('id');
    $waktu = Carbon::now()->translatedFormat('d F Y H:i');
    $pesan = "Haloo {$guide->nama_guide}, Anda telah terpilih menjadi guide pada tanggal {$waktu} WIB. Silakan login untuk melihat detail pelanggan dan jadwal guiding:\nhttp://localhost:8000/login\n\nTerima kasih 🙏";

    $notifikasi = Notifikasi::create([
        'guide_id' => $guide->id,
        'isi' => $pesan,
        'tanggal_kirim' => now(),
        'status' => 'notif pending masih di proses',
    ]);

    Log::info("Mengirim notifikasi ke nomor: {$phone} dengan pesan: {$pesan}");

    try {
        $res = Http::withHeaders([
            // 'Authorization' => 'HbHggEjszXST3WxTchcd'
        ])->post('https://api.fonnte.com/send', [
            'target' => $phone,
            'message' => $pesan,
        ]);

        if ($res->successful()) {
            $notifikasi->update(['status' => 'notif sudah terkirim']);
            Log::info("Notifikasi berhasil terkirim ke nomor {$phone}");
        } else {
            $notifikasi->update(['status' => 'notif belum terkirim']);
            Log::error("Notifikasi gagal terkirim ke nomor {$phone}. Response: " . $res->body());
        }
    } catch (\Exception $e) {
        $notifikasi->update(['status' => 'notif gagal: ' . $e->getMessage()]);
        Log::error("Exception saat kirim notifikasi ke nomor {$phone}: " . $e->getMessage());
    }
}

}
