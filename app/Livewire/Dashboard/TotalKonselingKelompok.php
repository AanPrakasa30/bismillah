<?php

namespace App\Livewire\Dashboard;

use App\Models\KonselingKel;
use Livewire\Component;

class TotalKonselingKelompok extends Component
{
    public function placeholder()
    {
        return view('livewire.skeleton.dashboard.card-loading');
    }

    public function render()
    {

        $total = KonselingKel::count();

        return view('livewire.dashboard.total-konseling-kelompok', compact("total"));
    }
}
