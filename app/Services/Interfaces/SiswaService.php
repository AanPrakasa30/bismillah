<?php

namespace App\Services\Interfaces;

interface SiswaService
{
    /**
     * Summary of createSiswasBySpreadsheetTemp
     * 
     * mengolah data siswa dan menyimpannya ke database, dengan return sebuah `reports`.
     * 
     * `created`, berhasil disimpan, `error` gagal disimpan
     * @param int $folderTemp
     * @return array
     */
    function createSiswasBySpreadsheetTemp(int $folderTemp): array;
}