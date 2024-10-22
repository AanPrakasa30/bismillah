<?php

namespace App\Models\Relasi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class KelasSiswa extends Pivot
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];
}
