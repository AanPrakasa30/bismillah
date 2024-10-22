<?php

namespace App\Livewire\Master;

use App\Models\Master\Siswa;
use Livewire\Component;

class ListSiswa extends Component
{
    use \Livewire\WithPagination;

    public function placeholder()
    {
        return view('livewire.skeleton.loading');
    }
    protected $queryString = ['search' => ['except' => '']];

    public string $search = '';

    public string $filterKelamin = 'All';

    public $perPage = 10;

    public function render()
    {

        $siswas = Siswa::with("gabung.kelas", "gabung.angkatan")
            ->when($this->search != '', function ($query) {
                $query->where('nama', 'like', "%$this->search%");
            })
            ->when($this->filterKelamin != 'All', function ($query) {
                $query->where('kelamin', $this->filterKelamin);
            })
            ->latest()
            ->paginate($this->perPage);
        return view('livewire.master.list-siswa', compact("siswas"));
    }
}
