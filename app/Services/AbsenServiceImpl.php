<?php

namespace App\Services;

use App\Models\AbsenData;
use App\Models\Master\Siswa;
use App\Services\Interfaces\AbsenService;
use App\Services\Interfaces\FileService;
use App\Services\Interfaces\SpreadsheetService;
use Illuminate\Support\Facades\DB;

class AbsenServiceImpl implements AbsenService
{
    private $fileService;
    private $spService;

    public function __construct(FileService $fileService, SpreadsheetService $spreadsheetService)
    {
        $this->fileService = $fileService;
        $this->spService   = $spreadsheetService;
    }

    public function createAbsenSiswaBySpreadsheet(int $folderTemp): array
    {
        // define range file cols
        $columnRange = [
            'first' => 'A',
            'last' => 'H'
        ];

        $pathTemp = $this->fileService->getTempPathFile($folderTemp);

        $worksheet = $this->spService->read($pathTemp)->getActiveSheet();

        // validate file, data header
        $this->spService->validateColumnNames($worksheet, $columnRange['first'], $columnRange['last'], [
            'NO', // 1
            'NIS', // 2
            'NAMA', // 3
            'KELAS', // 4
            'TAHUN_ANGKATAN', // 5
            'TANGGAL', // 6
            'TIPE', // 7
            'KETERANGAN' // 8
        ]);

        // export data worksheet
        $worksheetDatas = $this->spService->exportsDataCellInto2DArray($worksheet, $columnRange['first'], $columnRange['last']);
        array_shift($worksheetDatas); // delete header cols

        // cleaning null baris
        $datas = array_filter($worksheetDatas, function ($subArray) {
            return array_filter($subArray) !== []; // Cek apakah ada nilai non-null di sub-array
        });

        try {
            DB::beginTransaction();

            $reports = [];
            $userId  = auth()->user()->id;

            foreach ($datas as $key => $siswaDatas) {
                if (
                    !in_array(null, $siswaDatas) && is_numeric(trim($siswaDatas['2']))
                    && is_numeric(trim($siswaDatas['5']))
                    && is_numeric($siswaDatas['6'])
                ) {

                    $siswaDatas['6'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($siswaDatas['6']);

                    if (Siswa::where('NIS', $siswaDatas['2'])->exists()) {
                        $absen = AbsenData::firstOrCreate([
                            'NIS' => $siswaDatas['2'],
                            // 'tahun_angkatan' => $siswaDatas['5'],
                            'tanggal' => $siswaDatas['6'],
                            // 'tipe' => $siswaDatas['7']
                        ], [
                            'NIS' => $siswaDatas['2'],
                            'name' => $siswaDatas['3'],
                            'kelas' => $siswaDatas['4'],
                            'tahun_angkatan' => $siswaDatas['5'],
                            'tanggal' => $siswaDatas['6'],
                            'tipe' => $siswaDatas['7'],
                            'keterangan' => $siswaDatas['8'],
                            'user_id' => $userId
                        ]);

                        if ($absen->wasRecentlyCreated) {
                            $reports['create'][] = $siswaDatas;
                        } else {
                            $reports['error']['duplicate'][] = $siswaDatas;
                        }
                    } else {
                        $reports['error']['unknow'][] = $siswaDatas;
                    }
                } else {
                    $reports['error']['syntax'][] = $siswaDatas;
                }
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            throw $th;
        }

        // delete temp file and data
        $this->fileService->deleteTempData($folderTemp);

        return $reports;
    }
}