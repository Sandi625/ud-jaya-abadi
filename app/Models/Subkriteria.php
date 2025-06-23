<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subkriteria extends Model
{
    use HasFactory;

    protected $fillable = [
        'kriteria_id',
        'nama',
        'deskripsi',
        'profil_standar',
        'is_core_factor',
    ];

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }

    // public function detailPenilaians()
    // {
    //     return $this->hasMany(DetailPenilaian::class);
    // }



}
