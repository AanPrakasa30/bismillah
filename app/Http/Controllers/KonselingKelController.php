<?php

namespace App\Http\Controllers;

use App\Models\KonselingKel;
use App\Models\Master\Siswa;
use Illuminate\Http\Request;

class KonselingKelController extends Controller
{
    public function index()
    {
        $konselings = KonselingKel::paginate(15);

        return view("pages.konseling-kel.index", compact("konselings"));
    }

    public function create()
    {
        $siswas = Siswa::get();

        return view("pages.konseling-kel.create", compact("siswas"));
    }

    public function createPost(Request $request)
    {
        $request->validate([
            'siswasIds' => ['required', 'array', 'min:1'],
            'nama' => ['required', 'max:255'],
            'kasus' => ['required', 'max:255'],
        ]);

        try {
            $konseling = KonselingKel::create([
                'nama' => $request->input('nama'),
                'kasus' => $request->input('kasus'),
            ]);

            $konseling->kelompoks()->attach($request->input('siswasIds'));

            return redirect()->route('konseling-kel.detail', $konseling->id)->with('success', 'data berhasil dibuat');
        } catch (\Throwable $th) {
            dd($th);
            return back()->with('error', 'konseling gagal dibuat');
        }
    }

    public function detail($id)
    {
        $konseling = KonselingKel::with('kelompoks')->findOrFail($id);

        $siswas = Siswa::get();

        // mapping data kelompoks
        $selected = $konseling->kelompoks->map(function ($siswa) {
            return $siswa->id;
        })->toArray();

        return view("pages.konseling-kel.detail", compact("konseling", "siswas", "selected"));
    }

    public function detailPost(Request $request, $id)
    {
        $request->validate([
            'siswasIds' => ['required', 'array', 'min:1'],
            'nama' => ['required', 'max:255'],
            'kasus' => ['required', 'max:255'],
            'solusi' => 'string'
        ]);

        $konseling = KonselingKel::with('kelompoks')->findOrFail($id);

        try {
            $konseling->nama   = $request->input('nama');
            $konseling->kasus  = $request->input('kasus');
            $konseling->solusi = $request->input('solusi');
            $konseling->save();

            $konseling->kelompoks()->sync($request->input('siswasIds'));

            return back()->with('success', 'data berhasil diubah');
        } catch (\Throwable $th) {
            return back()->with('error', 'data gagal diubah');
        }
    }

    public function delete($id)
    {
        $konseling = KonselingKel::findOrFail($id);

        $konseling->delete();

        return redirect()->route('konseling-kel.delete')->with('success', 'berhasil menghapus data');
    }
}
