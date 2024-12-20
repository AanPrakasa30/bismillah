<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Component;

class ListUser extends Component
{

    use \Livewire\WithPagination;

    public function placeholder()
    {
        return view('livewire.skeleton.table');
    }

    protected $queryString = ['search' => ['except' => '']];

    public string $search = '';

    public $perPage = 10;


    public function render()
    {
        $users = User::when($this->search != '', function ($query) {
            $query->where('name', 'like', "%$this->search%")
                ->orWhere('email', 'like', "%$this->search%");
        })
            ->paginate($this->perPage);

        return view('livewire.user.list-user', compact("users"));
    }
}
