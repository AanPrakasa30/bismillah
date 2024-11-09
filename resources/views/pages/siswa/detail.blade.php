@extends('layouts.app')

@section('body')
<header>
    <x-main-header title="Detail Siswa" />
    <x-breadcrumb :datas="[route('master.siswa.index') => 'Siswa']" last="Detail Siswa" />
</header>

<section class="w-full p-4 border border-gray-100 shadow rounded-lg mt-5">
    <h2 class="text-xl font-medium mb-2">Data Siswa</h2>

    @include('includes.alert')

    <form method="POST">
        @csrf
        <div class="mb-5">
            <x-basic-label for="nis" title="NIS" />
            <x-basic-input type="text" id="nis" name="nis" value="{{ old('nis', $siswa->NIS) }}" required/>
        </div>
        <div class="mb-5">
            <x-basic-label for="name" title="Name" />
            <x-basic-input type="text" id="name" name="name" value="{{ old('name', $siswa->nama) }}" required />
        </div>
        <div class="mb-5">
            <x-basic-label for="name" title="Kelamin" />
            <select name="kelamin" id="" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                <option @selected(old('kelamin', $siswa->kelamin) == 'PRIA')>PRIA</option>
                <option @selected(old('kelamin', $siswa->kelamin) == 'WANITA')>WANITA</option>
            </select>
        </div>
        <div class="mb-5">
            <x-basic-label for="alamat" title="alamat" />
            <textarea name="alamat" id="alamat" cols="30" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500">{{ $siswa->alamat }}</textarea>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Buat</button>
        </div>
    </form>
</section>

<section class="w-full p-4 border border-gray-100 shadow rounded-lg mt-5">
    <h2 class="text-xl font-medium mb-2">Kelas</h2>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-green-100">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Tahun
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Kelas
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Jurusan
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Izin
                    </th>
                    <th scope="col" class="px-6 py-3">
                        
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($siswa->kelas as $key => $item)
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            {{ $item->pivot->tahun }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $item['nama'] }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item['jurusan'] }}
                        </td>
                        <td class="px-6 py-4">
                            0
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="#" class="font-medium text-blue-600 hover:underline">Edit</a>
                            |
                            <a href="#" class="font-medium text-red-600 hover:underline">Delete</a>
                        </td>
                    </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center">tidak ada data kelas</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>

<section class="w-full p-4 border border-gray-100 shadow rounded-lg mt-5">
    <h2 class="text-xl font-medium mb-2">Riwayat Ketidakhadiran</h2>

    @livewire('siswa.list-ketidakhadiran', ['nis' => $siswa->NIS, 'lazy' => true])
</section>
@endsection