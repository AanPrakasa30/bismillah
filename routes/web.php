<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
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

        Route::prefix("master")->group(function () {
            Route::prefix("/siswa")->group(function () {
                Route::get("/", [SiswaController::class, 'index'])->name("master.siswa.index");
                Route::get("/create", [SiswaController::class, 'create'])->name("master.siswa.create");
                Route::post("/create", [SiswaController::class, 'createPost']);

                Route::get("/upload", [SiswaController::class, "upload"])->name("master.siswa.upload");
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