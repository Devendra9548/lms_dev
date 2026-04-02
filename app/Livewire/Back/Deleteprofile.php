<?php

namespace App\Livewire\Back;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\InstituteUser;
use Mail;
use App\Mail\SendOtpMail;

class DeleteProfile extends Component
{
    public $userId;
    public $reason;
    public $otp;
    public $showForm = true;

    public function mount($id)
    {
        $this->userId = $id;
        $this->sendOtp();
    }

    public function sendOtp()
    {
        $otp = rand(100000, 999999);
        Session::put('delete_otp', $otp);
        Session::put('otp_expire', now()->addMinutes(5));

        $user = User::find($this->userId) ?? InstituteUser::find($this->userId);
        if($user){
            Mail::to($user->email)->send(new SendOtpMail($otp));
        }
    }

    public function deleteProfile()
    {
        $this->validate([
            'reason' => 'required|min:5',
            'otp' => 'required|digits:6',
        ]);

        // OTP validation
        if(now()->greaterThan(Session::get('otp_expire'))){
            $this->addError('otp', 'OTP expired. Please reload the page.');
            return;
        }

        if($this->otp != Session::get('delete_otp')){
            $this->addError('otp', 'Invalid OTP');
            return;
        }

        // Update user status
        $user = User::find($this->userId);
        $table = 'users';
        if(!$user){
            $user = InstituteUser::find($this->userId);
            $table = 'institute_users';
        }

        if($user){
            $user->update([
                'dsstatus' => 1,
                'delete_reason' => $this->reason
            ]);
        }

        // Clear OTP
        Session::forget(['delete_otp','otp_expire']);

        // Feedback
        session()->flash('success','Account deleted successfully');
        $this->showForm = false;
    }

    public function render()
    {
        return view('livewire.back.deleteprofile')->layout('layouts.back');
    }
}