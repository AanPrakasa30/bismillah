<?php

namespace App\Services\Interfaces;

interface SpreadsheetService
{

    /**
     * Summary of read
     * 
     * membaca file excel yang ada menjadi spreadsheet object
     * @param string $pathFile
     * @param string $storageDriver
     * @return \PhpOffice\PhpSpreadsheet\Spreadsheet
     */
    function read(string $pathFile, string $storageDriver = 'local'): \PhpOffice\PhpSpreadsheet\Spreadsheet;


    /**
     * Summary of validateColumn
     * 
     * memvalidasi header cel yang ada, pastikan harus urut, dari kiri ke kanan
     * @param string $firstColumnIndex
     * @param string $lastColumnIndex
     * @param array $colHeaderAllowed
     * @return bool
     */
    function validateColumnNames(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $activeSpreadsheet, string $firstColumnIndex, string $lastColumnIndex, array $allowedNames): bool;

}