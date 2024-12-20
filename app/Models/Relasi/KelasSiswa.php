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

    public function siswa()
    {
        return $this->belongsTo(\App\Models\Master\Siswa::class, "siswa_id");
    }
}
