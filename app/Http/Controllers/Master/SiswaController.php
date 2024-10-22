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
                'nama' => $request->input('name'),
                'nis' => $request->input('nim'),
                'kelamin' => $request->input('kelamin')
            ]);

            logNotice('siswa success to create', [
                'data' => $siswa,
                'by' => auth()->user()->id
            ]);

            // return 
        } catch (\Throwable $th) {
            dd($th->getMessage());
            logError('siswa failed to create', $th);
        }
    }

    // create siswa by upload data
    public function upload()
    {

    }

    public function uploadPost()
    {

    }
}
