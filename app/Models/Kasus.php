<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kasus extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function siswa()
    {
        return $this->belongsTo(Master\Siswa::class, 'siswa_id');
    }
}
