<?php

namespace App\Http\Controllers;

use App\Models\HomeVisit;
use App\Models\Master\Siswa;
use Illuminate\Http\Request;

class HomeVisitController extends Controller
{
    public function index()
    {
        $visits = HomeVisit::with('siswa')->latest()->paginate(15);

        return view("pages.visit.index", compact("visits"));
    }

    public function create()
    {
        $siswas = Siswa::orderBy('nama')->get();

        return view("pages.visit.create", compact("siswas"));
    }

    public function createPost(Request $request)
    {
        $request->validate([
            'siswaId' => ['required', 'integer', 'exists:siswas,id'],
            'wali' => ['required', 'max:255'],
            'alamat' => 'required',
            'kasus' => 'required'
        ]);

        try {
            $visit = HomeVisit::create([
                'siswa_id' => $request->input('siswaId'),
                'wali' => $request->input('wali'),
                'alamat' => $request->input('alamat'),
                'kasus' => $request->input('kasus')
            ]);

            return redirect()->route('visit.index')->with('success', 'berhasil menambah data');
        } catch (\Throwable $th) {
            return back()->with('error', 'gagal menambah data');
        }
    }

    public function delete($id)
    {
        $visit = HomeVisit::findOrFail($id);
        $visit->delete();

        return redirect()->route('visit.index')->with('success', 'berhasil menghapus data');
    }
}
