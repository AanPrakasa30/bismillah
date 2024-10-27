<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KonselingKel extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function kelompoks()
    {
        return $this->belongsToMany(Master\Siswa::class, 'konseling_kelompok')
            ->using(Relasi\KonselingKelompok::class);
    }
}
