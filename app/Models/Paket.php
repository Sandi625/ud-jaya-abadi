<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    use HasFactory;

    protected $table = 'pakets'; // Nama tabel dalam database

    protected $primaryKey = 'id'; // Primary key

    public $timestamps = true; // Menggunakan created_at & updated_at

    protected $fillable = [
        'nama_paket',
        'deskripsi_paket',
        'harga',
        'durasi',
        'destinasi',
        'include',
        'exclude',
        'itinerary',
        'information_trip',
        'foto'
    ];

}
