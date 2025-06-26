<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan (opsional jika tabel menggunakan nama default)
    protected $table = 'galeris';

    // Menentukan kolom yang bisa diisi (mass assignable)
    protected $fillable = [
        'judul',
        'deskripsi',
        'videolokal',
        'videoyoutube',
        'foto',
    ];

    // Menentukan kolom yang tidak boleh diisi (protected untuk mencegah mass assignment)
    protected $guarded = [];

    // Menentukan apakah kolom timestamps harus diaktifkan atau tidak
    public $timestamps = true;
}
