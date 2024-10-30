@extends('layouts.app')

@section('body')
<header>
    <x-main-header title="Buat Absensi Baru" />
    <x-breadcrumb :datas="[route('absen.index') => 'Absen']" last="Tambah" />
</header>

<section class="w-full p-4 border border-gray-100 shadow rounded-lg">

    @include('includes.alert')

    <form method="POST">
        @csrf
        <div class="mb-5">
            <x-basic-label for="siswa" title="Siswa" />
            <select name="siswaId" id="siswa" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                <option></option>
                @foreach ($siswas as $item)
                    <option value="{{ $item->id }}">{{ $item->NIS }} | {{ $item->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-5">
            <x-basic-label for="kelas" title="Kelas" />
            <select name="kelasId" id="kelas" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                <option></option>
                @foreach ($kelas as $item)
                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-5">
            <x-basic-label for="tahun" title="tahun siswa" />
            <x-basic-input name="tahun" type="number" id="tahun" />
        </div>
        <div class="mb-5">
            <x-basic-label for="tipe" title="Tipe" />
            <select name="tipe" id="tipe" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                <option @selected(old('tipe') == 'INHAL')>INHAL</option>
                <option @selected(old('tipe') == 'IZIN')>IZIN</option>
            </select>
        </div>
        <div class="mb-5">
            <x-basic-label for="tanggal" title="tanggal ketidakhadiran" />
            <x-basic-input name="tanggal" type="date" id="tanggal" />
        </div>
        <div class="mb-5">
            <x-basic-label for="keterangan" title="Keterangan" />
            <textarea name="keterangan" id="" cols="30" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500">{{ old('keterangan') }}</textarea>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Buat</button>
        </div>
    </form>
</section>
@endsection

@push('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<style>
    .select2.select2-container {
        width: 100% !important;
    }

    .select2.select2-container .select2-selection {
        border: 1px solid #ccc;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        height: 34px;
        outline: none !important;
        transition: all .15s ease-in-out;
    }

    .select2.select2-container .select2-selection .select2-selection__rendered {
        color: #333;
        font-size: 0.875rem;
        line-height: 32px;
        --tw-bg-opacity: 1;
        background-color: rgb(249 250 251 / var(--tw-bg-opacity));
    }

    .select2.select2-container .select2-selection .select2-selection__arrow {
        background: #f8f8f8;
        border-left: 1px solid #ccc;
        -webkit-border-radius: 0 3px 3px 0;
        -moz-border-radius: 0 3px 3px 0;
        border-radius: 0 3px 3px 0;
        height: 32px;
        width: 33px;
    }
</style>
@endpush

@push('script')
<script>
    $(document).ready(function() {
        $('#siswa').select2({
            placeholder: 'Pilih siswa..'
        });
    });
</script>
@endpush