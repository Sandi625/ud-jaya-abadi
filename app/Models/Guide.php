<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{
    protected $table = 'guides';
    protected $primaryKey = 'id'; // Pastikan primary key sesuai

    public $timestamps = true; // Jika menggunakan timestamps

    protected $fillable = [
        'nama_guide', 'salary', 'kriteria_id', 'deskripsi_guide',
        'nomer_hp', 'status', 'alamat', 'email', 'foto', 'bahasa', 'user_id', // <- HARUS ADA
    ];

    public function penilaians()
    {
        return $this->hasMany(Penilaian::class, 'guide_id');
    }


    public function user()
{
    return $this->belongsTo(User::class);
}

// public function reviews()
// {
//     return $this->hasMany(Review::class, 'guide_id');
// }



    // Relasi ke Kriteria
    // public function kriteria()
    // {
    //     return $this->belongsTo(Kriteria::class);
    // }






    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id');  // assuming kriteria_id is a column on guides table
    }




  // app/Models/Guide.php
public function pesanans()
{
    return $this->hasMany(Pesanan::class, 'id_guide');
}





public function kriteriaUnggulan()
{
    return $this->belongsTo(Kriteria::class, 'kriteria_id')->where('is_unggulan', true);  // assuming 'is_unggulan' is a column
}

//   public function kriteria()
//     {
//         return $this->belongsToMany(Kriteria::class,'guide_id', 'kriteria_id');
//     }

// app/Models/Guide.php
public function notifikasis()
{
    return $this->hasMany(Notifikasi::class, 'guide_id');
}






}

