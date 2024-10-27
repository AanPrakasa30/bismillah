<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeVisitController;
use App\Http\Controllers\KasusController;
use App\Http\Controllers\KonselingController;
use App\Http\Controllers\KonselingKelController;
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

        Route::prefix("kasus")->group(function () {
            Route::get("/", [KasusController::class, "index"])->name("kasus.index");
            Route::get("create", [KasusController::class, 'create'])->name("kasus.create");
            Route::post("create", [KasusController::class, 'createPost']);
            Route::get("/{id}/delete", [KasusController::class, 'delete'])->name("kasus.delete");
        });

        Route::prefix("visit")->group(function () {
            Route::get("/", [HomeVisitController::class, "index"])->name("visit.index");
            Route::get("/create", [HomeVisitController::class, "create"])->name("visit.create");
            Route::post("/create", [HomeVisitController::class, "createPost"]);
            Route::get("/{id}/delete", [HomeVisitController::class, "delete"])->name("visit.delete");
        });

        Route::prefix("konseling-kelompok")->group(function () {
            Route::get("/", [KonselingKelController::class, "index"])->name("konseling-kel.index");
            Route::get("/create", [KonselingKelController::class, "create"])->name("konseling-kel.create");
            Route::post("/create", [KonselingKelController::class, "createPost"]);
            Route::get("/{id}/detail", [KonselingKelController::class, "detail"])->name("konseling-kel.detail");
            Route::post("/{id}/detail", [KonselingKelController::class, "detailPost"]);
            Route::get("/{id}/delete", [KonselingKelController::class, "delete"])->name("konseling-kel.delete");
        });

        Route::prefix("konseling")->group(function () {
            Route::get("/", [KonselingController::class, "index"])->name("konseling.index");
            Route::get("/create", [KonselingController::class, "create"])->name("konseling.create");
            Route::post("/create", [KonselingController::class, "createPost"]);
            Route::get("/{id}/detail", [KonselingController::class, "detail"])->name("konseling.detail");
            Route::post("/{id}/detail", [KonselingController::class, "detailPost"]);
            Route::get("/{id}/delete", [KonselingController::class, "delete"])->name("konseling.delete");
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