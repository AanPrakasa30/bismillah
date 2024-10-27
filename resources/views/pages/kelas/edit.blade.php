@extends('layouts.app')

@section('body')
<header>
    <x-main-header title="Edit Kelas" />
    <x-breadcrumb :datas="[route('master.kelas.index') => 'Kelas']" last="Edit Kelas" />
</header>

<section class="w-full p-4 border border-gray-100 shadow rounded-lg mt-5">
    <h2 class="text-xl font-medium mb-2">Data Kelas</h2>

    @include('includes.alert')

    <form method="POST">
        @csrf
        <div class="mb-5">
            <x-basic-label for="jurusan" title="Jurusan" />
            <select name="jurusan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                <option @selected(old('jurusan', $kelas->jurusan) == 'IPA')>IPA</option>
                <option @selected(old('jurusan', $kelas->jurusan) == 'IPS')>IPS</option>
            </select>
        </div>
        <div class="mb-5">
            <x-basic-label for="name" title="Name" />
            <x-basic-input type="text" id="name" name="name" value="{{ old('name', $kelas->nama) }}" required />
        </div>
        <div class="flex justify-end">
            <button class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="submit">
                Ubah
            </button>
        </div>
    </form>
</section>

<section class="w-full p-4 border border-gray-100 shadow rounded-lg mt-5">
    <h2 class="font-medium text-xl">Data Siswa</h2>
    <p class="text-sm mb-4">Data siswa pada kelas</p>
    <div class="flex justify-end">
        <button data-modal-target="default-modal" data-modal-toggle="default-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="button">
            Tambah
        </button>

        <div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                        <h3 class="text-xl font-semibold text-gray-900">
                            Tambah Data Siswa
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="default-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5 space-y-4">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio, ratione.</p>
                        <div class="grid grid-cols-2 gap-5">
                            <a href="#" class="w-full border border-gray-100 hover:border-gray-300 shadow h-36 sm:h-64 rounded-lg flex justify-center items-center">
                                <div class="text-gray-500 text-center">
                                    <i class="fa-regular fa-square-plus text-xl sm:text-[3rem]"></i>
                                    <p class="mt-2 font-bold">Create</p>
                                </div>
                            </a>
                            <a href="#" class="w-full border border-gray-100 hover:border-gray-300 shadow h-36 sm:h-64 rounded-lg flex justify-center items-center">
                                <div class="text-gray-500 text-center">
                                    <i class="fa-solid fa-upload text-xl sm:text-[3rem]"></i>
                                    <p class="mt-2 font-bold">Upload</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<section class="w-full p-4 border border-gray-100 shadow rounded-lg mt-5">
    <h2 class="text-red-500 font-medium text-xl">Hapus Permanent</h2>
    <p class="text-sm mb-4">dihapus secara permanent</p>
    <div class="flex justify-center items-center">
        <button class="block text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="button" id="btn-delete">
            Hapus
        </button>
    </div>
</section>
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    const btnDelete = document.getElementById('btn-delete')
    btnDelete.addEventListener("click", () => {
        Swal.fire({
            title: "Are you sure?",
            text: "Data Akan dihapus secara permanent",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
            }).then((result) => {
            if (result.isConfirmed) {
                window.location = "{{ route('master.kelas.delete', $kelas->id) }}"
            }
        });
    })
</script>
@endpush