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
    <div class="w-full grid grid-cols-1 md:grid-cols-2 p-4 border border-gray-100 shadow rounded-lg gap-5">
        <div class="">
            <h2 class="font-semibold text-xl">Ketentuan Upload</h2>
            <ol>
                <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestias, distinctio!</li>
                <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestias, distinctio!</li>
            </ol>
        </div>
        <form action="" method="post">
            <x-basic-input type="file" name="fileSiswa" />
        </form>
    </div>
</section>
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