<?php

namespace App\Livewire\Back;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.back.dashboard')->layout('layouts.back');
    }
}
