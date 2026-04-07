<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\InstituteUser;

class GoogleController extends Controller
{
    public function redirect(Request $request)
    {
        // role store karo (faculty / student etc.)
        if ($request->role) {
            session(['role' => $request->role]);
        }

        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $role = session('role'); // faculty ya student

            if ($role == 'faculty') {

                // USERS TABLE CHECK
                $user = User::where('email', $googleUser->email)->first();

                if (!$user) {
                    $user = User::create([
                        'name' => $googleUser->name,
                        'email' => $googleUser->email,
                        'phone' => '',
                        'role' => 'faculty',
                        'img' => 'thumb.jpg',
                        'password' => bcrypt('google_login'),
                    ]);
                }

                Auth::guard('web')->login($user);

            } else {

                // INSTITUTE_USERS TABLE CHECK
                $user = InstituteUser::where('email', $googleUser->email)->first();

                if (!$user) {
                    $user = InstituteUser::create([
                        'name' => $googleUser->name,
                        'email' => $googleUser->email,
                        'phone' => '',
                        'role' => $role ?? 'student',
                        'img' => 'thumb.jpg',
                        'password' => bcrypt('google_login'),
                    ]);
                }

                Auth::guard('institute_users')->login($user);
            }

            return redirect()->route('dashboard');

        } catch (\Exception $e) {
            // dd($e->getMessage());
            return redirect()->route('login')->with('fail', 'Google login failed');
        }
    }
}