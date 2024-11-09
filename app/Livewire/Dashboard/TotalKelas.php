<?php

namespace App\Livewire\Dashboard;

use App\Models\Master\Kelas;
use Livewire\Component;

class TotalKelas extends Component
{
    public function placeholder()
    {
        return view('livewire.skeleton.dashboard.card-loading');
    }

    public function render()
    {
        $total = Kelas::count();

        return view('livewire.dashboard.total-kelas', compact("total"));
    }
}
