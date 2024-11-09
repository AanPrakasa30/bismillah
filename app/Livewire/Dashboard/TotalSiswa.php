<?php

namespace App\Livewire\Dashboard;

use App\Models\Master\Siswa;
use Livewire\Component;

class TotalSiswa extends Component
{

    public function placeholder()
    {
        return view('livewire.skeleton.dashboard.card-loading');
    }

    public function render()
    {
        $total = Siswa::count();

        return view('livewire.dashboard.total-siswa', [
            'total' => $total
        ]);
    }
}
