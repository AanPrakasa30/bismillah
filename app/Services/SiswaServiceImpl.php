<?php

namespace App\Services;

use App\Models\Master\Siswa;
use App\Services\Interfaces\FileService;
use App\Services\Interfaces\SiswaService;
use App\Services\Interfaces\SpreadsheetService;
use Illuminate\Support\Facades\DB;

class SiswaServiceImpl implements SiswaService
{
    private $fileService;
    private $spService;

    public function __construct(FileService $fileService, SpreadsheetService $spreadsheetService)
    {
        $this->fileService = $fileService;
        $this->spService   = $spreadsheetService;
    }

    public function createSiswasBySpreadsheetTemp(int $folderTemp): array
    {
        // define range file cols
        $columnRange = [
            'first' => 'A',
            'last' => 'D'
        ];

        $pathTemp = $this->fileService->getTempPathFile($folderTemp);

        $worksheet = $this->spService->read($pathTemp)->getActiveSheet();

        // validate file, data header
        $this->spService->validateColumnNames($worksheet, $columnRange['first'], $columnRange['last'], [
            'NO',
            'NIS',
            'NAMA',
            'KELAMIN'
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
            foreach ($datas as $key => $siswaDatas) {
                if (in_array(trim($siswaDatas['4']), Siswa::KELAMIN) && !in_array(null, $siswaDatas) && is_numeric(trim($siswaDatas['2']))) {
                    $siswa = Siswa::firstOrCreate(['NIS' => trim($siswaDatas['2'])], [
                        'NIS' => trim($siswaDatas['2']),
                        'nama' => trim($siswaDatas['3']),
                        'kelamin' => trim($siswaDatas['4'])
                    ]);

                    if ($siswa->wasRecentlyCreated) {
                        $reports['create'][] = $siswaDatas;
                    } else {
                        $reports['error']['duplicate'][] = $siswaDatas;
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

    public function registerKelasSiswaBySpreadsheetTemp(int $folderTemp, \App\Models\Master\Kelas $kelas, int $tahun): array
    {
        // define range file cols
        $columnRange = [
            'first' => 'A',
            'last' => 'D'
        ];

        $pathTemp = $this->fileService->getTempPathFile($folderTemp);

        $worksheet = $this->spService->read($pathTemp)->getActiveSheet();

        // validate file, data header
        $this->spService->validateColumnNames($worksheet, $columnRange['first'], $columnRange['last'], [
            'NO', // 1
            'NIS', // 2
            'NAMA', // 3
            'KELAMIN' // 4
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
            foreach ($datas as $key => $siswaDatas) {
                $siswa = Siswa::with("kelas")->where('NIS', (int) $siswaDatas['2'])->first();

                if ($siswa) {
                    if ($siswa->kelas->count() >= 1) {
                        foreach ($siswa->kelas as $siswaKelas) {
                            if ($siswaKelas->pivot->tahun == $tahun or ($siswaKelas->jurusan == $kelas->jurusan && $siswaKelas->nama == $kelas->nama && $siswaKelas->pivot->tahun == $tahun)) {
                                $reports['error']['duplicate'][] = $siswaDatas;
                            } else {
                                \App\Models\Relasi\KelasSiswa::create([
                                    "siswa_id" => $siswa->id,
                                    "kelas_id" => $kelas->id,
                                    "tahun" => $tahun
                                ]);

                                $reports['create'][] = $siswaDatas;
                            }
                        }
                    } else {
                        \App\Models\Relasi\KelasSiswa::create([
                            "siswa_id" => $siswa->id,
                            "kelas_id" => $kelas->id,
                            "tahun" => $tahun
                        ]);

                        $reports['create'][] = $siswaDatas;
                    }
                } else {
                    $reports['error']['unknow'][] = $siswaDatas;
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
