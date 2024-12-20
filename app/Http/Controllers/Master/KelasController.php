<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Kelas;
use App\Models\Master\Siswa;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        return view("pages.kelas.index");
    }

    public function createPost(Request $request)
    {
        $request->validate([
            'jurusan' => ['required', 'in:IPA,IPS'],
            'name' => ['required', 'string', 'max:255', new \App\Rules\UniqueNamaJurusanKelas]
        ]);

        try {
            $kelas = Kelas::create([
                'nama' => $request->input("name"),
                'jurusan' => $request->input("jurusan")
            ]);

            logNotice('kelas success to create', [
                'data' => $kelas,
                'by' => auth()->user()->id
            ]);

            return back()->with("success", "berhasil menambah data");
        } catch (\Throwable $th) {
            logError("kelas failed to create", $th);

            return back()->with("error", "kelas gagal ditambahkan");
        }
    }

    public function edit($id)
    {
        $kelas = Kelas::findOrFail($id);

        return view("pages.kelas.edit", compact("kelas"));
    }

    public function editPost(Request $request, $id)
    {
        $request->validate([
            'jurusan' => ['required', 'in:IPA,IPS'],
            'name' => ['required', 'string', 'max:255', new \App\Rules\UniqueNamaJurusanKelas]
        ]);

        $kelas = Kelas::findOrFail($id);

        try {
            $kelas->nama    = $request->input("name");
            $kelas->jurusan = $request->input("jurusan");
            $kelas->save();

            logNotice('kelas success to update', [
                'data' => $kelas,
                'by' => auth()->user()->id
            ]);

            return back()->with("success", "berhasil mengubah data");
        } catch (\Throwable $th) {
            logError("kelas failed to update", $th);
            return back()->with("error", "kelas gagal diubah");
        }
    }

    public function registerSiswa($id)
    {
        $kelas = Kelas::findOrFail($id);
        return view("pages.kelas.register-kelas", compact("id"));
    }

    public function registerSiswaPost(Request $request, $id)
    {
        $request->validate([
            "nis" => ["required", "numeric"],
            "tahun" => ["required", "string", "max:4", "min:4"]
        ]);

        $siswa = Siswa::where('NIS', $request->input("nis"))->first();

        if (!$siswa) {
            return back()->withErrors('siswa tidak terdaftar atau NIS tidak ditemukan');
        }

        $kelas = Kelas::findOrFail($id);

        try {
            $kelasSiswa = \App\Models\Relasi\KelasSiswa::firstOrCreate(['siswa_id' => $siswa->id, 'kelas_id' => $kelas->id, 'tahun' => $request->input('tahun')], [
                'siswa_id' => $siswa->id,
                'kelas_id' => $kelas->id,
                'tahun' => $request->input('tahun')
            ]);

            if (!$kelasSiswa->wasRecentlyCreated) {
                return back()->withErrors('siswa tersebut sudah pernah terdaftar pada kelas tersebut pada tahun tersebut');
            }

            return back()->with('success', 'siswa berhasil ditambahkan kedalam kelas');
        } catch (\Throwable $th) {
            return back()->with("error", "server error, coba lagi nanti!");
        }
    }

    public function uploadSiswa($id)
    {
        // jika ada hasil reports sebelumnya
        $reports = session(auth()->user()->id . "-upload-siswa-kelas") ?? null;

        session()->forget(auth()->user()->id . "-upload-siswa-kelas");

        return view("pages.kelas.upload-siswa-kelas", compact("id", "reports"));
    }

    public function uploadSiswaPost(Request $request, $id, \App\Services\Interfaces\SiswaService $siswaService)
    {
        $request->validate([
            "fileSiswa" => "required",
            "tahun" => ["required", "string", "max:4", "min:4"]
        ]);

        $kelas = Kelas::findOrFail($id);

        try {
            $reports = $siswaService->registerKelasSiswaBySpreadsheetTemp($request->input("fileSiswa"), $kelas, $request->input("tahun"));

            session([
                auth()->user()->id . "-upload-siswa-kelas" => $reports
            ]);

            return back()->with('success', 'data berhasil diolah');
        } catch (\Throwable $th) {
            //throw $th;

            dd($th);
        }
    }

    public function deleteSiswa($id, $relasaiId)
    {
        \App\Models\Relasi\KelasSiswa::findOrFail($relasaiId)->delete();

        return back()->with('success', 'siswa berhasil dihapus dari kelas');
    }

    public function delete($id)
    {
        $kelas = Kelas::findOrFail($id);

        $kelas->delete();

        logNotice("kelas success to delete", [
            'data' => $kelas,
            'by' => auth()->user()->id
        ]);

        return redirect()->route('master.kelas.index')->with("success", "berhasil menghapus kelas");
    }
}
