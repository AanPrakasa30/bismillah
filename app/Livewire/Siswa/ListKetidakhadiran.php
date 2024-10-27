<?php

namespace App\Livewire\Siswa;

use App\Models\AbsenData;
use Livewire\Component;

class ListKetidakhadiran extends Component
{
    use \Livewire\WithPagination;

    public function placeholder()
    {
        return view('livewire.skeleton.table');
    }

    public string $nis;

    public function mount($nis)
    {
        $this->nis = $nis;
    }

    protected $queryString = ['search' => ['except' => '']];

    public string $search = '';

    public string $filterKelamin = 'All';

    public $perPage = 10;

    public function render()
    {
        $ketidakhadiran = AbsenData::where('NIS', $this->nis)->paginate($this->perPage);

        // sleep(3);

        return view('livewire.siswa.list-ketidakhadiran', compact("ketidakhadiran"));
    }
}
