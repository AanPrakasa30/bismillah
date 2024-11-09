<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view("pages.user.index");
    }

    public function create()
    {
        return view("pages.user.create");
    }


    public function createPost(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:3']
        ]);

        try {
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => $request->input('password')
            ]);

            return redirect()->route('master.user.index')->with('success', 'data berhasil dibuat');
        } catch (\Throwable $th) {
            return back()->with('error', 'kesalahan server.');
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view("pages.user.edit", compact("user"));
    }

    public function editPost(Request $request, $id)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email,' . $id],
            'password' => ['nullable', 'min:3']
        ]);

        $user = User::findOrFail($id);


        try {
            $user->name  = $request->input('name');
            $user->email = $request->input('email');

            if ($request->input('password') != '') {
                $user->password = $request->input('password');
            }

            $user->save();

            return back()->with('success', 'data berhasil diubah');
        } catch (\Throwable $th) {
            return back()->with('error', 'kesalahan server.');
        }
    }


    public function delete($id)
    {
        User::findOrFail($id)->delete();

        return redirect()->route('master.user.index')->with('success', 'data berhasil dihapus');
    }
}
