<?php

namespace App\Http\Controllers;

use App\Models\Konseling;
use App\Models\Master\Siswa;
use Illuminate\Http\Request;

class KonselingController extends Controller
{
    public function index()
    {
        $konselings = Konseling::latest()->paginate(15);

        return view('pages.konseling.index', compact('konselings'));
    }

    public function create()
    {
        $siswas = Siswa::get();

        return view('pages.konseling.create', compact('siswas'));
    }

    public function createPost(Request $request)
    {
        $request->validate([
            'siswaId' => ['required', 'integer', 'exists:siswas,id'],
            'nama' => ['required', 'max:255'],
            'kasus' => ['required', 'max:255'],
        ]);

        try {
            $konseling = Konseling::create([
                'siswa_id' => $request->input('siswaId'),
                'nama' => $request->input('nama'),
                'kasus' => $request->input('kasus')
            ]);

            return redirect()->route('konseling.detail', $konseling->id)->with('success', 'berhasil membuat data');
        } catch (\Throwable $th) {
            return back()->with('error', 'gagal membuat data');
        }
    }

    public function detail($id)
    {
        $konseling = Konseling::with('siswa')->findOrFail($id);

        $siswas = Siswa::get();

        return view('pages.konseling.detail', compact('siswas', 'konseling'));
    }

    public function detailPost(Request $request, $id)
    {
        $request->validate([
            'siswaId' => ['required', 'integer', 'exists:siswas,id'],
            'nama' => ['required', 'max:255'],
            'kasus' => ['required', 'max:255'],
            'solusi' => 'string'
        ]);

        $konseling = Konseling::findOrFail($id);

        try {
            $konseling->siswa_id = $request->input('siswaId');
            $konseling->nama     = $request->input('nama');
            $konseling->kasus    = $request->input('kasus');
            $konseling->solusi   = $request->input('solusi');
            $konseling->save();

            return back()->with('success', 'berhasil mengubah data');
        } catch (\Throwable $th) {
            return back()->with('error', 'gagal membuat data');
        }
    }

    public function delete($id)
    {
        $konselings = Konseling::findOrFail($id);
        $konselings->delete();

        return redirect()->route('konseling.index')->with('success', 'berhasil menghapus data');
    }
}
