<?php

namespace App\Services;

use App\Services\Interfaces\SpreadsheetService;
use Storage;

class SpreadsheetServiceImpl implements SpreadsheetService
{
    // tipe format spreadsheet
    const ALLOWEDFORMAT = [
        \PhpOffice\PhpSpreadsheet\IOFactory::READER_XLS,
        \PhpOffice\PhpSpreadsheet\IOFactory::READER_XLSX,
        \PhpOffice\PhpSpreadsheet\IOFactory::READER_CSV,
    ];

    public function read(string $pathFile, string $storageDriver = 'local'): \PhpOffice\PhpSpreadsheet\Spreadsheet
    {
        if (!Storage::disk($storageDriver)->exists($pathFile)) {
            throw new \Exception('file not found');
        }

        $pathFile = Storage::disk($storageDriver)->path($pathFile);

        try {
            /**  Identify the type of $inputFileName  **/
            $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($pathFile, self::ALLOWEDFORMAT);

            /** Load $inputFileName to a Spreadsheet Object  **/
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);

            /**  Advise the Reader that we only want to load cell data  **/
            $reader->setReadDataOnly(true);

            $reader->setLoadAllSheets();

            /**  Load $inputFileName to a Spreadsheet Object  **/
            $spreadsheet = $reader->load($pathFile);

            return $spreadsheet;
        } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
            throw $e;
        }
    }
}