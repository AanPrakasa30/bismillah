<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function siswa()
    {
        return $this->belongsToMany(\App\Models\Master\Siswa::class, 'kelas_siswa', 'kelas_id', 'siswa_id')
            ->using(\App\Models\Relasi\KelasSiswa::class)
            ->orderByDesc('tahun')
            ->withPivot('tahun');
    }
}
