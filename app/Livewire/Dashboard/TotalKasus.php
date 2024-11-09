<?php

namespace App\Livewire\Dashboard;

use App\Models\Kasus;
use Livewire\Component;

class TotalKasus extends Component
{
    public function placeholder()
    {
        return view('livewire.skeleton.dashboard.card-loading');
    }


    public function render()
    {
        $total = Kasus::count();

        return view('livewire.dashboard.total-kasus', compact("total"));
    }
}
