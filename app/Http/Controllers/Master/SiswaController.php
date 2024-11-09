<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index()
    {
        return view("pages.siswa.index");
    }

    public function create()
    {
        return view("pages.siswa.create");
    }

    public function createPost(Request $request)
    {
        $request->validate([
            'nis' => ['required', 'numeric', 'unique:siswas,nis'],
            'name' => ['required', 'max:255', 'min:2'],
            'kelamin' => ['required', 'in:PRIA,WANITA']
        ], [
            'nis.unique' => 'NIS sudah digunakan'
        ]);

        try {
            $siswa = Siswa::create([
                'NIS' => $request->input('nis'),
                'nama' => $request->input('name'),
                'kelamin' => $request->input('kelamin'),
                'alamat' => $request->input('alamat')
            ]);

            logNotice('siswa success to create', [
                'data' => $siswa,
                'by' => auth()->user()->id
            ]);

            return redirect()->route("master.siswa.index")->with("success", "berhasil menambah siswa baru dalam data");
        } catch (\Throwable $th) {
            dd($th->getMessage());
            logError('siswa failed to create', $th);

            return back()->with("error", "gagal membuat siswa baru");
        }
    }

    // create siswa by upload data
    public function upload()
    {
        // jika ada hasil reports sebelumnya
        $reports = session(auth()->user()->id . "-upload-siswa") ?? null;

        session()->forget(auth()->user()->id . "-upload-siswa");

        return view("pages.siswa.upload", compact("reports"));
    }

    public function uploadPost(Request $request, \App\Services\Interfaces\SiswaService $siswaService)
    {
        $request->validate([
            'fileSiswa' => ['required']
        ]);

        try {
            $reports = $siswaService->createSiswasBySpreadsheetTemp($request->input('fileSiswa'));

            session([
                auth()->user()->id . "-upload-siswa" => $reports
            ]);

            return back()->with('success', 'data berhasil diolah');
        } catch (\App\Exceptions\SpreadsheetException $spreadsheetException) {
            return back()->with('error', $spreadsheetException->getMessage());
        } catch (\Throwable $th) {
            logError('siswa failed to create by upload', $th);
            return back()->with('error', 'terdapat kesalahan, coba lagi nanti');
        }
    }

    public function detail($nis)
    {
        $siswa = Siswa::with('kelas')
            ->where('NIS', $nis)->first();

        return view("pages.siswa.detail", compact("siswa"));
    }
}
