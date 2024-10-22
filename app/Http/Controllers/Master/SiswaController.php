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
                'kelamin' => $request->input('kelamin')
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
        return view("pages.siswa.upload");
    }

    public function uploadPost()
    {

    }
}
