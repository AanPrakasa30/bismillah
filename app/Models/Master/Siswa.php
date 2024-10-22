<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Siswa extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    // relasi
    public function kelas(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Master\Kelas::class, 'kelas_siswa')
            ->using(\App\Models\Relasi\KelasSiswa::class)
            ->withPivot('angkatan_id');
    }

    public function angkatan(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Master\Angkatan::class, 'kelas_siswa')
            ->using(\App\Models\Relasi\KelasSiswa::class)
            ->withPivot('kelas_id');
    }

    public function gabung(): HasMany
    {
        return $this->hasMany(\App\Models\Relasi\KelasSiswa::class, 'siswa_id');
    }
}
