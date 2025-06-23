<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    use HasFactory;

    protected $table = 'detail_pesanan';

    protected $fillable = [
        'pesanan_id',
        'kriteria_id',
        'guide_id',
        'prioritas', // ✅ ditambahkan
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id');
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id');
    }

    public function guide()
    {
        return $this->belongsTo(Guide::class, 'guide_id');
    }

    public function detailPenilaians()
{
    return $this->hasMany(DetailPenilaian::class, 'detail_pesanan_id');
}

// DetailPenilaian.php
public function scopeFromAdmin($query)
{
    return $query->where('sumber', 'admin');
}

public function scopeFromCustomer($query)
{
    return $query->where('sumber', 'pelanggan');
}

public function subkriteria()
{
    return $this->belongsTo(Subkriteria::class, 'subkriteria_id');
}

public function penilaian()
{
    return $this->belongsTo(Penilaian::class, 'id_penilaian'); // sesuaikan
}






}


