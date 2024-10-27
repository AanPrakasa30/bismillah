<?php

namespace App\Livewire\Kasus;

use App\Models\Kasus;
use Livewire\Component;

class ListKasus extends Component
{
    use \Livewire\WithPagination;

    public function placeholder()
    {
        return view('livewire.skeleton.table');
    }

    protected $queryString = ['search' => ['except' => '']];

    public string $search = '';

    public string $filterTipe = 'All';

    public $perPage = 10;

    public function render()
    {
        $kasus = Kasus::with("siswa")
            ->when($this->filterTipe != 'All', function ($query) {
                $query->where('tipe', $this->filterTipe);
            })
            ->when($this->search != '', function ($query) {
                $query->whereHas('siswa', function ($query) {
                    $query->where('nama', 'like', "%" . $this->search . "%");
                });
            })
            ->paginate($this->perPage);
        return view('livewire.kasus.list-kasus', compact("kasus"));
    }
}
