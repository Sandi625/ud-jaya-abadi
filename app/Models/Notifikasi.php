<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'guide_id',
        'isi',
        'tanggal_kirim',
        'status',
    ];

    protected $casts = [
        'tanggal_kirim' => 'datetime',
    ];

    public function guide()
    {
        return $this->belongsTo(Guide::class);
    }
}
