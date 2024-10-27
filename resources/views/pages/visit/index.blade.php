@extends('layouts.app')

@section('body')
<header class="mb-5">
    <x-main-header title="List Home Visit" />
    <div class="flex justify-end">
        <a href="{{ route('visit.create') }}" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="button">
            Tambah
        </a>
    </div>

    @include('includes.alert')

</header>

<section class="w-full p-4 border border-gray-100 shadow rounded-lg">
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-green-100">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        No
                    </th>
                    <th scope="col" class="w-2/3 px-6  py-4 font-medium text-gray-900 whitespace-nowrap">
                        Kasus
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nama Siswa
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Wali
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Tanggal Buat
                    </th>
                    <th scope="col" class="px-6 py-3">
                        
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($visits as $key => $item)
                <tr class="bg-white border-b hover:bg-gray-100">
                    <td class="px-6 py-4">
                        {{ ($visits->currentPage() - 1) * $visits->perPage() + $key + 1 }}
                    </td>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        {{ $item->kasus }}
                    </th>
                    <td class="px-6 py-4">
                        {{ $item->siswa->nama }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $item->wali }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $item->created_at }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('visit.delete', $item->id) }}" class="font-medium text-red-600 hover:underline">Delete</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-gray-900 font-medium text-md">Tidak Ditemukan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="flex items-center gap-3 mt-4">
        <p class="text-sm">Per Page</p>
        <select name="filter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block p-1">
            <option>10</option>
            <option>50</option>
            <option>100</option>
        </select>
    </div>

    <div class="w-full mt-4">
        {{ $visits->links() }}
    </div>
</section>
@endsection