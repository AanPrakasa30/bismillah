@extends('layouts.app')

@push('style')
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />
<style>
    .filepond--credits{
        display: none;
    }
    .filepond--root .filepond--drop-label {
        height: 200px;
    }
</style>
@endpush

@section('body')
<header>
    <x-main-header title="Buat Data Siswa by Upload" />
    <x-breadcrumb :datas="[route('master.siswa.index') => 'Siswa']" last="Upload Data Siswa" />
</header>

<section>
    
    @include('includes.alert')

    <div class="w-full grid grid-cols-1 md:grid-cols-2 p-4 border border-gray-100 shadow rounded-lg gap-5">
        <div class="">
            <h2 class="font-semibold text-xl">Ketentuan Upload</h2>
            <ol class="ml-8 list-disc">
                <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestias, distinctio!</li>
                <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestias, distinctio!</li>
            </ol>

            <div class="mt-4">
            </div>
            <div class="mt-6">
                <a href="{{ asset('assets/spreadsheet/tamplate-upload-siswa.xlsx') }}" class="w-full flex items-center justify-center gap-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2 me-2 mb-2" download>Download Tamplate <i class="fa-solid fa-file-arrow-down"></i></a>
            </div>
        </div>
        <form action="" method="post">
            @csrf
            <x-basic-input type="file" name="fileSiswa" />

            <div class="flex justify-end">
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2 me-2 mb-2">Upload</button>
            </div>
        </form>
    </div>
</section>

@if ($reports)
<section class="mt-10">
    <h2 class="font-medium text-lg mb-5">Hasil Upload</h2>
    @isset($reports['error']['duplicate'])
    <div class="w-full p-4 border border-gray-100 shadow rounded-lg gap-5 my-4">
        <div class="flex p-4 mb-4 text-sm text-red-800 border-t-4 border-red-300 bg-red-50" role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3 mt-[2px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
              <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <div>
                <span class="font-medium">Kesalahan Data :</span>
                <ul class="mt-1.5 list-disc list-inside">
                    <li>NIS sudah pernah terdaftar</li>
                </ul>
            </div>
        </div>
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-red-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            No
                        </th>
                        <th scope="col" class="px-6 py-3">
                            NIS
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nama
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Kelamin
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reports['error']['duplicate'] as $item)
                        <tr class="bg-white border-b">
                            <td class="px-6 py-4">
                                {{ $item['1'] }}
                            </td>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $item['2'] }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $item['3'] }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $item['4'] }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endisset
    @isset($reports['error']['syntax'])
    <div class="w-full p-4 border border-gray-100 shadow rounded-lg gap-5 my-4">
        <div class="flex p-4 mb-4 text-sm text-red-800 border-t-4 border-red-300 bg-red-50" role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3 mt-[2px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
              <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <div>
                <span class="font-medium">Kesalahan Penulisan :</span>
                <ul class="mt-1.5 list-disc list-inside">
                    <li>terdapat cell yang kosong</li>
                    <li>kelamin hanya: PRIA, WANITA (wajib kapital)</li>
                    <li>NIS harus angka</li>
                </ul>
            </div>
        </div>
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-red-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            No
                        </th>
                        <th scope="col" class="px-6 py-3">
                            NIS
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nama
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Kelamin
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reports['error']['syntax'] as $item)
                        <tr class="bg-white border-b">
                            <td class="px-6 py-4">
                                {{ $item['1'] }}
                            </td>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $item['2'] }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $item['3'] }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $item['4'] }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endisset
    @isset($reports['create'])
    <div class="w-full p-4 border border-gray-100 shadow rounded-lg gap-5 my-4">
        <div id="alert-border-1" class="flex items-center p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50 " role="alert">
            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <div class="ms-3 text-sm font-medium">
                Berhasil Disimpan
            </div>
        </div>
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-green-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            No
                        </th>
                        <th scope="col" class="px-6 py-3">
                            NIS
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nama
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Kelamin
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reports['create'] as $item)
                        <tr class="bg-white border-b">
                            <td class="px-6 py-4">
                                {{ $item['1'] }}
                            </td>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $item['2'] }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $item['3'] }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $item['4'] }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endisset
</section>
@endif
@endsection

@push('script')
<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
<script src="https://unpkg.com/filepond/dist/filepond.js"></script>
<script>
    const inputElement = document.querySelector('input[type="file"]');
    const btnSubmit = document.getElementById('btn-submit')
    // Register the plugin
    FilePond.registerPlugin(FilePondPluginFileValidateType);

    FilePond.create(inputElement, {
        acceptedFileTypes: ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'],
        required: true,
        onprocessfilestart: (file) => {
            console.log('file been process');
            btnSubmit.disabled = true;
        },
        onprocessfilerevert: (file) => {
            console.log('file been revert');
            btnSubmit.disabled = true;
        },
        onprocessfile: (error, file) => {
            console.log(error, file);
            btnSubmit.disabled = false;
        },
        onremovefile: (error, file) => {
            console.log(error);
            btnSubmit.disabled = false;
        },
        server: {
            process: {
                url: "{{ route('file.upload') }}",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    'Accept' : 'application/json'
                }
            },
            revert:{
                url: "{{ route('file.revert') }}",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    'Accept' : 'application/json'
                }
            }
        }
    })
</script>
@endpush