@extends('layouts.app')

@section('body')
    <header>
        <x-main-header title="Buat Data Siswa by Upload" />
        <x-breadcrumb :datas="[route('master.siswa.index') => 'Siswa']" last="Upload Data Siswa" />
    </header>
@endsection