<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Master\KelasController;
use App\Http\Controllers\Master\SiswaController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginPost']);
});

// auth path
Route::middleware(['auth'])->group(function () {
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::prefix('profile')->group(function () {
            Route::get('/', [UserProfileController::class, 'index'])->name('profile.index');
            Route::post('/', [UserProfileController::class, 'update']);
        });

        Route::prefix("absen")->group(function () {
            Route::get("/upload", [AbsensiController::class, 'upload'])->name("absen.upload");
            Route::post("/upload", [AbsensiController::class, 'uploadPost']);
        });

        Route::prefix("master")->group(function () {
            Route::prefix("/siswa")->group(function () {
                Route::get("/", [SiswaController::class, 'index'])->name("master.siswa.index");
                Route::get("/create", [SiswaController::class, 'create'])->name("master.siswa.create");
                Route::post("/create", [SiswaController::class, 'createPost']);

                Route::get("/upload", [SiswaController::class, "upload"])->name("master.siswa.upload");
                Route::post("/upload", [SiswaController::class, "uploadPost"]);

                Route::get("/{nis}", [SiswaController::class, 'detail'])->name("master.siswa.detail");
            });

            Route::prefix("kelas")->group(function () {
                Route::get("/", [KelasController::class, "index"])->name("master.kelas.index");
                Route::post("/", [KelasController::class, "createPost"]);

                Route::get("/{id}/edit", [KelasController::class, "edit"])->name("master.kelas.edit");
                Route::post("/{id}/edit", [KelasController::class, "editPost"]);

                Route::get("/{id}/delete", [KelasController::class, "delete"])->name("master.kelas.delete");
            });
        });
    });

    // file path
    Route::prefix("file")->group(function () {
        Route::post("upload", function (\App\Services\Interfaces\FileService $fileService, \Illuminate\Http\Request $request) {
            $upload = $fileService->uploadTemp($request);

            return !$upload ? response()->json(status: 400, data: [
                'status' => 'error',
                'message' => 'file failed to upload'
            ]) : $upload;
        })->name("file.upload");

        Route::delete("revert", function (\Illuminate\Http\Request $request, \App\Services\Interfaces\FileService $fileService) {
            return $fileService->revertTemp($request);
        })->name("file.revert");
    });
});

Route::get("/test", function (\App\Services\Interfaces\FileService $fileService) {

    dd($fileService->getTempPathFile(2118601676));

    // $spreadsheet = $spreadsheetService->read('temp/test-siswa.xlsx');

    // $worksheet = $spreadsheet->getActiveSheet();

    // // dd($spreadsheet, $worksheet->getHighestRow(), $worksheet->getHighestRowAndColumn());

    // try {
    //     $spreadsheetService->validateColumnNames($worksheet, 'A', 'D', [
    //         'NO',
    //         'NIS',
    //         'NAMA',
    //         'KELAMIN'
    //     ]);

    //     dd($spreadsheetService->exportsDataCellInto2DArray($worksheet, 'A', 'D'));

    // } catch (\App\Exceptions\SpreadsheetException $spreadsheetException) {
    //     dd('ini exce cost', $spreadsheetException->getMessage());
    // } catch (\Throwable $th) {
    //     //throw $th;
    //     dd('ini Throwable', $th);
    // }
});