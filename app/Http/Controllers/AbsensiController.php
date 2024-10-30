<?php

namespace App\Http\Controllers;

use App\Models\AbsenData;
use App\Models\Master\Kelas;
use App\Models\Master\Siswa;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index()
    {
        return view("pages.absen.index");
    }

    public function create()
    {
        $siswas = Siswa::get();
        $kelas  = Kelas::get();

        return view("pages.absen.create", compact("siswas", "kelas"));
    }

    public function createPost(Request $request)
    {
        $request->validate([
            'siswaId' => 'required',
            'kelasId' => 'required',
            'tipe' => 'required',
            'tahun' => 'required',
            'tanggal' => 'required',
            'keterangan' => 'required'
        ]);

        try {

            $siswa = Siswa::findOrFail($request->input('siswaId'));

            $absen = AbsenData::create([
                'NIS' => $siswa->NIS,
                'name' => $siswa->nama,
                'kelas' => $request->input('kelasId'),
                'tahun_angkatan' => $request->input('tahun'),
                'tanggal' => $request->input('tanggal'),
                'tipe' => $request->input('tipe'),
                'keterangan' => $request->input('keterangan'),
                'user_id' => auth()->user()->id
            ]);

            return redirect()->route('absen.index')->with('success', 'berhasil menambah data');
        } catch (\Throwable $th) {
            dd($th);
            return back()->with('error', 'gagal menambah data');
        }
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

    public function delete($id)
    {
        AbsenData::findOrFail($id)->delete();

        return redirect()->route('absen.index')->with('success', 'data berhasil dihapus');
    }
}
