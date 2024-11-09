<?php

namespace App\Livewire\Dashboard;

use App\Models\HomeVisit;
use Livewire\Component;

class TotalHomeVisit extends Component
{
    public function placeholder()
    {
        return view('livewire.skeleton.dashboard.card-loading');
    }

    public function render()
    {
        $total = HomeVisit::count();

        return view('livewire.dashboard.total-home-visit', compact('total'));
    }
}
