@extends('layouts.app')

@section('body')
<header>
    <x-main-header title="Konseling Kelompok" />
    <x-breadcrumb :datas="[route('konseling-kel.index') => 'Konseling']" last="Tambah" />
</header>

<section class="w-full p-4 border border-gray-100 shadow rounded-lg">

    @include('includes.alert')

    <form method="POST">
        @csrf
        <div class="mb-5">
            <x-basic-label for="nama" title="Nama" />
            <x-basic-input type="text" id="nama" name="nama" value="{{ old('nama') }}" required />

        </div>
        <div class="mb-5">
            <x-basic-label for="kasus" title="Kasus" />
            <x-basic-input type="text" id="kasus" name="kasus" value="{{ old('kasus') }}" required />
        </div>
        <div class="mb-5">
            <x-basic-label for="siswa" title="Kelompok" />
            <p class="text-xs text-gray-500 mb-2">dapat pilih lebih dari 1</p>
            <select name="siswasIds[]" id="siswa" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required multiple>
                <option></option>
                @foreach ($siswas as $item)
                    <option value="{{ $item->id }}">{{ $item->NIS }} | {{ $item->nama }}</option>
                @endforeach
            </select>
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
@endpush

@push('script')
<script>
    $(document).ready(function() {
        $('#siswa').select2({
            placeholder: 'Pilih Siswa Siswa'
        });
    });
</script>
@endpush