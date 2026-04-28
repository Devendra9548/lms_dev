<?php

namespace App\Livewire\Back;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\LoginActivity;
use App\Models\UserActivity;

class Dashboard extends Component
{
    public $activities = [];
    public $graphData = [];

    public function mount()
    {
        // ✅ Detailed activity table (working)
        $this->activities = LoginActivity::where('loggable_id', Auth::id())->latest()->take(3)->get();

        // 🔥 Current user
        $user = Auth::user();

        if ($user) {

            // ✅ GRAPH DATA from user_activities table
            $this->graphData = UserActivity::selectRaw('DATE(created_at) as date, COUNT(*) as total')
                ->where('activityable_id', $user->id)
                ->where('activityable_type', $user::class)
                ->where('created_at', '>=', now()->subDays(7))
                ->groupBy('date')
                ->orderBy('date')
                ->get()
                ->toArray();
        }
    }

    public function render()
    {
        return view('livewire.back.dashboard')
            ->layout('layouts.back');
    }
}