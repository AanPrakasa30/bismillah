<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index()
    {

    }

    public function upload()
    {
        return view("pages.absen.upload");
    }

    public function uploadPost(Request $request, \App\Services\Interfaces\AbsenService $absenService)
    {
        $request->validate([
            'fileAbsen' => ['required']
        ]);

        try {
            $reports = $absenService->createAbsenSiswaBySpreadsheet($request->input('fileAbsen'));

            dd($reports);
        } catch (\Throwable $th) {
            dd($th);
        }
    }
}
