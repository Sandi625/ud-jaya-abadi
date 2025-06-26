<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'guide_id', // tambahkan ini
        'pesanan_id', // tambahkan ini
        'name',
        'email',
        'rating',
        'isi_testimoni',
        'photo',
        'status',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => 'boolean',
        'created_by' => 'integer',
        'updated_by' => 'integer',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        // Add any attributes you want to hide from serialization.
    ];

    /**
     * The attributes that should be appended to model arrays.
     *
     * @var array<int, string>
     */
    protected $appends = [
        // Add any attributes you want to append to model arrays.
    ];

     public function guide()
    {
        return $this->belongsTo(Guide::class, 'guide_id');
    }
    public function pesanan()
{
    return $this->belongsTo(Pesanan::class, 'pesanan_id');
}


}
