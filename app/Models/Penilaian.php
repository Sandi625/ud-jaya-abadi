<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;

protected $fillable = ['guide_id', 'id_pesanan'];


    // Relasi dengan `DetailPenilaian`
    public function detailPenilaians()
    {
        return $this->hasMany(DetailPenilaian::class);
    }

    public function guide()
    {
        return $this->belongsTo(Guide::class, 'guide_id');
    }

    public function detail_penilaians()
    {
        return $this->hasMany(DetailPenilaian::class, 'penilaian_id');
    }


    // Penilaian.php
public function detailPelanggan()
{
    return $this->hasMany(DetailPenilaian::class)->where('sumber', 'pelanggan');
}

public function detailAdmin()
{
    return $this->hasMany(DetailPenilaian::class)->where('sumber', 'admin');
}

public function pesanan()
{
    return $this->belongsTo(Pesanan::class, 'id_pesanan'); // sesuaikan jika nama foreign key berbeda
}

}












