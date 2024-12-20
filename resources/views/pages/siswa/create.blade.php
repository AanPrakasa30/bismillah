@extends('layouts.app')

@section('body')
<header>
    <x-main-header title="Buat Data Siswa Baru" />
    <x-breadcrumb :datas="[route('master.siswa.index') => 'Siswa']" last="Buat Data Siswa" />
</header>

<section class="w-full p-4 border border-gray-100 shadow rounded-lg">

    @include('includes.alert')

    <form method="POST">
        @csrf
        <div class="mb-5">
            <x-basic-label for="nis" title="NIS" />
            <x-basic-input type="text" id="nis" name="nis" value="{{ old('nis') }}" required />
        </div>
        <div class="mb-5">
            <x-basic-label for="name" title="Name" />
            <x-basic-input type="text" id="name" name="name" value="{{ old('name') }}" required />
        </div>
        <div class="mb-5">
            <x-basic-label for="name" title="Kelamin" />
            <select name="kelamin" id="" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                <option @selected(old('kelamin') == 'PRIA')>PRIA</option>
                <option @selected(old('kelamin') == 'WANITA')>WANITA</option>
            </select>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Buat</button>
        </div>
    </form>
</section>
@endsection