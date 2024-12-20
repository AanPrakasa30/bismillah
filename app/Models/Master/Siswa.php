<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Siswa extends Model
{
    use HasFactory;

    const KELAMIN = [
        'PRIA',
        'WANITA'
    ];

    protected $guarded = [
        'id'
    ];

    // relasi
    public function kelas(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Master\Kelas::class, 'kelas_siswa')
            ->using(\App\Models\Relasi\KelasSiswa::class)
            ->orderByDesc('tahun')
            ->withPivot('tahun', 'id');
    }
}
