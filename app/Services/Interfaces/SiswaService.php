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

    /**
     * Summary of registerKelasSiswaBySpreadsheetTemp
     * 
     * mendaftarkan siswa yang sudah terdaftar berdasarkan tahun angkatan dan nama kelas terdata menggunakan spreadsheet. return berupa sebuah `reports`.
     * @param int $folderTemp
     * 
     * @param int $tahun
     * @return array
     */
    function registerKelasSiswaBySpreadsheetTemp(int $folderTemp, \App\Models\Master\Kelas $kelas, int $tahun): array;
}