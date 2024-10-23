<?php

namespace App\Services\Interfaces;

interface SpreadsheetService
{
    function read(string $pathFile, string $storageDriver = 'local'): \PhpOffice\PhpSpreadsheet\Spreadsheet;
}