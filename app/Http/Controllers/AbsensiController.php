<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index()
    {

    }

    public function create()
    {
        // liat contohnya di siswa controller create
    }

    public function createPost(Request $request)
    {
        // membuat absens/izin satu persatu
        // liat contohnya di siswa controller create
    }

    public function upload()
    {
        // jika ada hasil reports sebelumnya
        $reports = session(auth()->user()->id . "-absen-siswa") ?? null;

        session()->forget(auth()->user()->id . "-absen-siswa");

        return view("pages.absen.upload", compact("reports"));
    }

    public function uploadPost(Request $request, \App\Services\Interfaces\AbsenService $absenService)
    {
        $request->validate([
            'fileAbsen' => ['required']
        ]);

        try {
            $reports = $absenService->createAbsenSiswaBySpreadsheet($request->input('fileAbsen'));

            session([
                auth()->user()->id . "-absen-siswa" => $reports
            ]);

            return back()->with('success', 'data berhasil diolah');
        } catch (\App\Exceptions\SpreadsheetException $spreadsheetException) {
            return back()->with('error', $spreadsheetException->getMessage());
        } catch (\Throwable $th) {
            logError('absens failed to create by upload', $th);
            return back()->with('error', 'terdapat kesalahan, coba lagi nanti');
        }
    }
}
