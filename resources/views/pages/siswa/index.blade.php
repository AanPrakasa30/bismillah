@extends('layouts.app')

@section('body')
<header>
    <x-main-header title="List Siswa" />
</header>

<section class="w-full p-4 border border-gray-100 shadow rounded-lg">
    @livewire('master.list-siswa')
</section>
@endsection