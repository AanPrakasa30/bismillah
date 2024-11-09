<?php

namespace App\Livewire\Dashboard;

use App\Models\Konseling;
use Livewire\Component;

class TotalKonselingIndividu extends Component
{
    public function placeholder()
    {
        return view('livewire.skeleton.dashboard.card-loading');
    }

    public function render()
    {
        $total = Konseling::count();

        return view('livewire.dashboard.total-konseling-individu', compact("total"));
    }
}
