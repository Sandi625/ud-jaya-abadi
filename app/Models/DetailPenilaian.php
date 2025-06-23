<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPenilaian extends Model
{
    use HasFactory;

    protected $fillable = [
        'penilaian_id',
        'subkriteria_id',
        'nilai',
        'detail_pesanan_id', // tambahkan jika kamu menambahkan kolom ini
        'sumber',

    ];

    // Relasi dengan `Penilaian`
    public function penilaian()
    {
        return $this->belongsTo(Penilaian::class);
    }

    // Relasi dengan `Subkriteria`
    public function subkriteria()
    {
        return $this->belongsTo(Subkriteria::class);
    }

    //  public function detailPesanan()
    // {
    //     return $this->belongsTo(DetailPesanan::class, 'detail_pesanan_id');
    // }





}
