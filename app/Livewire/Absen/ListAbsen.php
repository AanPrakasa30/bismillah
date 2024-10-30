<?php

namespace App\Livewire\Absen;

use App\Models\AbsenData;
use Livewire\Component;

class ListAbsen extends Component
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
        $absens = AbsenData::with('user')
            ->when($this->filterTipe != 'All', function ($query) {
                $query->where('tipe', $this->filterTipe);
            })
            ->when($this->search != '', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('NIS', $this->search)
                    ->orWhere('tahun_angkatan', $this->search);
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.absen.list-absen', compact("absens"));
    }
}
