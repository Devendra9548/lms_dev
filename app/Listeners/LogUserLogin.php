<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Jenssegers\Agent\Agent;
use App\Models\LoginActivity;
use Stevebauman\Location\Facades\Location;

class LogUserLogin
{
    public function handle(Login $event): void
    {
        $user = $event->user;
    
        // 🔥 ULTRA SAFE CHECK
        if (!$user || !is_object($user)) {
            return; // stop if user not found
        }
    
        $agent = new Agent();
        $ip = request()->ip();
    
        $location = 'Unknown';
    
        try {
            $position = Location::get($ip);
    
            if ($position) {
                $location = $position->cityName . ', ' . $position->countryName;
            }
        } catch (\Exception $e) {
            $location = 'Unknown';
        }
    
        // ✅ Save login activity
        LoginActivity::create([
            'loggable_id'   => $user->id,
            'loggable_type' => $user::class, // 🔥 use this instead of get_class()
            'ip_address'    => $ip,
            'browser'       => $agent->browser(),
            'platform'      => $agent->platform(),
            'device'        => $agent->device(),
            'location'      => $location,
            'login_at'      => now(),
        ]);
    
        // ✅ Save graph activity
        if (method_exists($user, 'activities')) {
            $user->activities()->create([
                'type' => 'login'
            ]);
        }
    }
}