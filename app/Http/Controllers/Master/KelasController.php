<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Kelas;
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
