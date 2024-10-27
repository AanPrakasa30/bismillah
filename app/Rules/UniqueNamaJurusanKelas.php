<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueNamaJurusanKelas implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $jurusan = request()->input('jurusan');

        if (\App\Models\Master\Kelas::where(['nama' => $value, 'jurusan' => $jurusan])->exists()) {
            $fail('Kombinasi nama dan jurusan sudah ada.');
        }
    }
}
