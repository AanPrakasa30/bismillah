<?php

namespace App\Livewire\Kelas;

use App\Models\Relasi\KelasSiswa;
use Livewire\Component;

class ListSiswaKelas extends Component
{
    use \Livewire\WithPagination;

    public function placeholder()
    {
        return view('livewire.skeleton.table');
    }

    public string $id;

    public function mount($id)
    {
        $this->id = $id;
    }

    protected $queryString = ['search' => ['except' => '']];

    public string $search = '';

    public string $filterKelamin = 'All';

    public $perPage = 10;
    public function render()
    {
        $siswas = KelasSiswa::with("siswa")
            ->where('kelas_id', $this->id)
            ->when($this->search != '', function ($query) {
                $query->whereHas('siswa', function ($query) {
                    $query->where("nama", "like", "%$this->search%")
                        ->orWhere("NIS", "like", "%$this->search%");
                });
            })
            ->orderByDesc('tahun')
            ->paginate($this->perPage);


        // dd($siswas);
        return view('livewire.kelas.list-siswa-kelas', [
            "siswas" => $siswas,
            "id" => $this->id
        ]);
    }
}
