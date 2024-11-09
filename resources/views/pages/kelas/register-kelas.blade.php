@extends('layouts.app')

@section('body')
<header>
    <x-main-header title="Register Siswa kedalam Kelas" />
    <x-breadcrumb :datas="[route('master.kelas.index') => 'Kelas', route('master.kelas.edit', $id) => 'Edit Kelas']" last="Daftar Siswa Kelas" />
</header>

<section class="w-full p-4 border border-gray-100 shadow rounded-lg">

    @include('includes.alert')

    <form method="POST">
        @csrf
        <div class="mb-5">
            <x-basic-label for="tahun" title="Tahun" />
            <x-basic-input type="number" id="tahun" name="tahun" value="{{ old('tahun') }}" required />
        </div>
        <div class="mb-5">
            <x-basic-label for="nis" title="NIS Siswa" />
            <x-basic-input type="text" id="nis" name="nis" value="{{ old('nis') }}" required />
        </div>
        <div class="flex justify-end">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Buat</button>
        </div>
    </form>
</section>
@endsection