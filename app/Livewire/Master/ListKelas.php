<?php

namespace App\Livewire\Master;

use App\Models\Master\Kelas;
use Livewire\Component;

class ListKelas extends Component
{
    use \Livewire\WithPagination;

    public function placeholder()
    {
        return view('livewire.skeleton.loading');
    }
    protected $queryString = ['search' => ['except' => '']];

    public string $search = '';

    public string $filterJurusan = 'All';

    public $perPage = 10;

    public function render()
    {
        $kelas = Kelas::when($this->search != '', function ($query) {
            $query->where('nama', 'like', "%$this->search%");
        })
            ->when($this->filterJurusan != 'All', function ($query) {
                $query->where('jurusan', $this->filterJurusan);
            })
            ->paginate($this->perPage);

        return view('livewire.master.list-kelas', compact("kelas"));
    }
}
