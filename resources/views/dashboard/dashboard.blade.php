@extends('layouts.app')

@section('body')
    <header>
        <x-main-header title="Ini dashboard utama" />
    </header>

    <section>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="w-full p-4 shadow rounded-lg border border-gray-100">
                @livewire('dashboard.total-siswa', ['lazy' => true])
            </div>

            <div class="w-full p-4 shadow rounded-lg border border-gray-100">
                @livewire('dashboard.total-kelas', ['lazy' => true])
            </div>

            <div class="w-full p-4 shadow rounded-lg border border-gray-100">
                @livewire('dashboard.total-kasus', ['lazy' => true])
            </div>
            <div class="w-full p-4 shadow rounded-lg border border-gray-100">
                @livewire('dashboard.total-home-visit', ['lazy' => true])
            </div>
            <div class="w-full p-4 shadow rounded-lg border border-gray-100">
                @livewire('dashboard.total-konseling-individu', ['lazy' => true])
            </div>
            <div class="w-full p-4 shadow rounded-lg border border-gray-100">
                @livewire('dashboard.total-konseling-kelompok', ['lazy' => true])
            </div>
        </div>
    </section>
@endsection