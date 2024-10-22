<?php

namespace App\Models\Relasi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class KelasSiswa extends Pivot
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Master\Kelas::class, 'kelas_id');
    }

    public function angkatan(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Master\Angkatan::class, 'angkatan_id');
    }
}
