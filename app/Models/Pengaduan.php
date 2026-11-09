<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    protected $fillable = [
        'nama',
        'deskripsi',
        'status',
        'ruangan',
        'category_id',
        'siswa_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
