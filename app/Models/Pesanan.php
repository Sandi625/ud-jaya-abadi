<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama', 'email', 'nomor_telp', 'id_paket', 'id_guide',
        'tanggal_pesan', 'tanggal_keberangkatan', 'jumlah_peserta',
        'order_id', 'negara', 'bahasa', 'riwayat_medis',
        'paspor', 'special_request', 'status',
        'user_id',
        'kebutuhan_guide',
    ];

    // Relasi ke Paket
    public function paket()
    {
        return $this->belongsTo(Paket::class, 'id_paket');
    }

    // Relasi ke Guide
    public function guide()
    {
        return $this->belongsTo(Guide::class, 'id_guide');
    }


    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke DetailPesanan (pivot table antara Pesanan dan Kriteria)
    // public function detailPesanan()
    // {
    //     return $this->hasMany(DetailPesanan::class, 'pesanan_id');
    // }

    // Relasi ke Kriteria melalui DetailPesanan
    public function kriterias()
{
    return $this->belongsToMany(Kriteria::class, 'detail_pesanan', 'pesanan_id', 'kriteria_id')
        ->withPivot('guide_id')
        ->withTimestamps();
}


public function detailPesanans()
{
    return $this->hasMany(DetailPesanan::class, 'pesanan_id');
}


public function reviews()
{
    return $this->hasMany(Review::class, 'pesanan_id');
}

// di Penilaian.php
public function pesanan()
{
    return $this->belongsTo(Pesanan::class, 'id_pesanan');
}

// di Pesanan.php (misal)
public function penilaians()
{
    return $this->hasMany(Penilaian::class, 'id_pesanan');
}
































}

