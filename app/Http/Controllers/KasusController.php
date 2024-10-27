<?php

namespace App\Http\Controllers;

use App\Models\Kasus;
use App\Models\Master\Siswa;
use Illuminate\Http\Request;

class KasusController extends Controller
{
    public function index()
    {
        return view("pages.kasus.index");
    }

    public function create()
    {
        $siswas = Siswa::orderBy('nama')->get();

        return view("pages.kasus.create", compact("siswas"));
    }

    public function createPost(Request $request)
    {
        $request->validate([
            'siswaId' => ['required', 'numeric', 'exists:siswas,id'],
            'tipe' => ['required', "in:BERAT,SEDANG,RINGAN"],
            'point' => ['required', 'integer', 'between:1,100'],
            'keterangan' => 'required'
        ]);

        try {
            $kasus = Kasus::create([
                'siswa_id' => $request->input("siswaId"),
                'tipe' => $request->input("tipe"),
                'point' => $request->input("point"),
                'keterangan' => $request->input("keterangan"),
            ]);

            return redirect()->route('kasus.index')->with('success', 'kasus berhasil dibuat');
        } catch (\Throwable $th) {
            return back()->with('error', 'kasus gagal dibuat');
        }
    }

    public function delete($id)
    {
        $kasus = Kasus::findOrFail($id);
        $kasus->delete();

        return back()->with('success', 'kasus berhasil dihapus');
    }
}
