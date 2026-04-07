<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\InstituteUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Mail;
use App\Mail\SendOtpMail;

class backendController extends Controller
{
    function login()
    {
      if (Auth::guard('web')->check() || Auth::guard('institute_users')->check()) {
          return redirect()->route('dashboard')
              ->with('success', 'Successful Login');
      }
      return view('back.login');
    }

    function logining(Request $req){
      $rs = $req->validate([
        'uemail' => 'required',
        'upass' => 'required',
        'suser' =>  'required',
      ],
      [
        'uemail.required' => 'Please enter your Correct Email.',
        'upass.required' => 'Please enter your Correct Password.',
        'suser.required' => 'Please enter your Correct User.',
      ],
      [
        'uemail' => 'Email',
        'upass' => 'Password',
        'suser' =>  'User',
      ]
      );
      
      $userdata=[
        'email' => $req->uemail,
        'password' => $req->upass,
      ];
       
      if($req->suser == 'faculty'){
        if(Auth::guard('web')->attempt($userdata)){
          session([
            'user_id' => $req->uemail,
            'user_type' => 'web', 
          ]);
          return redirect()->route('dashboard')->with('success', 'Successful Login Faculty');
        }
        return back()->with('fail', 'Something Wrong. please try with different details');
      }
      else{
        $user = InstituteUser::where('email', $req->uemail)->first();
        if(Auth::guard('institute_users')->attempt($userdata)){
          session([
            'user_id' => $req->uemail,
            'user_type' => 'institute_users', 
          ]);
          return redirect()->route('dashboard')->with('success', 'Successful Login Student');
        }
        return back()->with('fail', 'Something Wrong. please try with different details');
      }
    }

    function signup(){
      if (Auth::guard('web')->check() || Auth::guard('institute_users')->check()) {
        return redirect()->route('dashboard')->with('success', 'Successful Login');      
      }
      else{
        return view('back.signup');
      }
    }
 
  function signing(Request $req){
      if($req->has('otp')){
        if(now()->greaterThan(Session::get('otp_expire'))){
            return back()
                ->with('fail', 'OTP Expired. Please try again.')
                ->with('show_otp', true);
        }
        if($req->otp != Session::get('signup_otp')){
            return back()
                ->with('fail', 'Invalid OTP')
                ->with('show_otp', true);  
        }
        $rdata = Session::get('signup_data');
        $userdata = [
            'email' => $rdata['email'],
            'password' => $rdata['raw_password'], 
        ];

        if($rdata['role'] == 'faculty'){
            User::create($rdata);
            Auth::guard('web')->attempt($userdata);
        } 
        else{
            InstituteUser::create($rdata);
            Auth::guard('institute_users')->attempt($userdata);
        }
        Session::forget(['signup_otp', 'signup_data', 'otp_expire']);
        return redirect()->route('dashboard')->with('success', 'Signup Successful');
    }

    $emailRule = $req->suser == 'faculty'
        ? 'required|email|unique:users,email'
        : 'required|email|unique:institute_users,email';

    $req->validate([
        'uname' => 'required',
        'uemail' => $emailRule,
        'uphone' => 'required|phone:AUTO',
        'suser' => 'required',
        'upass' => 'required|min:6|max:12|confirmed',
    ]);

    $otp = rand(100000, 999999);

    $rdata = [
        'name' => $req->uname,
        'email' => $req->uemail,
        'phone' => $req->uphone,
        'role' => $req->suser,
        'img' => 'thumb.jpg',
        'password' => $req->upass,
        'raw_password' => $req->upass,
    ];

    Session::put('signup_otp', $otp);
    Session::put('signup_data', $rdata);
    Session::put('otp_expire', now()->addMinutes(1));

    Mail::to($req->uemail)->send(new SendOtpMail($otp));

    return back()->with('show_otp', true);
  }

  public function forgetpassword(){
     if (Auth::guard('web')->check() || Auth::guard('institute_users')->check()) {
       return redirect()->route('dashboard')->with('success', 'Successful Login');      
     }
     else{
       return view('back.forget-password');
      }
  }

  function recoverpassword(Request $req)
  {
    if ($req->has('otp')) {
        // Validate OTP and new password
        $req->validate([
            'suser' => 'required',
            'upass' => 'required|min:6|max:12|confirmed',
            'otp' => 'required',
        ]);

        // Check if OTP expired
        if (now()->greaterThan(Session::get('otp_expire'))) {
            return back()
                ->with('fail', 'OTP Expired. Please try again.')
                ->with('show_otp', true);
        }

        // Check if OTP matches
        if ($req->otp != Session::get('signup_otp')) {
            return back()
                ->with('fail', 'Invalid OTP')
                ->with('show_otp', true);
        }

        // Find the user by email stored in session
        $email = Session::get('otp_email');
        if ($req->suser == 'faculty') {
            $user = User::where('email', $email)->first();
        } else {
            $user = InstituteUser::where('email', $email)->first();
        }

        if (!$user) {
            return back()->with('fail', 'User not found.')->with('show_otp', true);
        }

        // Update password (hashed)
        $user->update([
            'password' => Hash::make($req->upass),
        ]);

        // Forget OTP sessions
        Session::forget(['signup_otp', 'otp_expire', 'otp_email']);

        return redirect()->route('login')->with('success', 'Password reset successfully!');
    }

    // If OTP not submitted yet
    $req->validate([
        'suser' => 'required',
        'uemail' => 'required|email',
    ]);

    $email = $req->uemail;
    if ($req->suser == 'faculty') {
        $user = User::where('email', $email)->first();
    } else {
        $user = InstituteUser::where('email', $email)->first();
    }

    if (!$user) {
        return back()->with('fail', 'Email not registered.');
    }

    // Generate OTP and send mail
    $otp = rand(100000, 999999);
    Session::put('signup_otp', $otp);
    Session::put('otp_expire', now()->addMinutes(5)); // 5 minutes OTP expiry
    Session::put('otp_email', $email);

    Mail::to($email)->send(new SendOtpMail($otp));

    return back()->with('show_otp', true)->with('success', 'OTP sent to your email.');
  }

  public function logout(){
    foreach (['web', 'institute_users'] as $guard) {
      if (Auth::guard($guard)->check()) {
          Auth::guard($guard)->logout();
      }
    }
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login')->with('success', 'You are Logout');
  }
  
  public function updateprofile(Request $req, $id){
      $rs = $req->validate([
        'uname' => 'required',
        'uphone' => 'required|phone:AUTO',
        'suser' => 'required',
        'img' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:300',
      ],
      [
        'uname.required' => 'Please enter your Correct Full Name.',
        'uphone.required' => 'Please enter your Correct Phone Number.',
        'uphone.phone' => 'Please enter your Correct Phone Number.',
        'img.image' => 'File must be an image.',
        'img.mimes' => 'Only JPG, JPEG, PNG, WEBP allowed.',
        'img.max' => 'Image size must not exceed 300KB.',
      ],
      [
        'suser' => 'User',
        'img' => 'Image',
      ]
    );

    $hasimg=Auth::user()->img;
    if($req->hasfile('img')){
      $files = $req->file('img');
      $names = $files->getClientOriginalName();
      $ts=time(); 
      $ds=date('ymd', $ts);
      $hasimg=$ds.'-'.$ts.'-'.$names; 
      $customefolderpathforpen=public_path('usersimg');
      if(!file_exists($customefolderpathforpen)){
          mkdir($customefolderpathforpen, 0755, true);
      }
      $files->move($customefolderpathforpen, $hasimg);
    }

    $rdata=[
      'name' => $req->uname,
      'phone' => $req->uphone,
      'role' => $req->suser,
      'img' => $hasimg,
    ];
   

    if($req->suser == 'faculty'){
      User::find($id)->update($rdata);
      return back()->with('success', 'Successfully Updated');
    }
    else{
      InstituteUser::find($id)->update($rdata);
      return back()->with('success', 'Successfully Updated');
    }
  }

  public function updatepassword(Request $req, $id){
    $emailRule = $req->suser == 'faculty'
    ? 'required|email|unique:users,email'
    : 'required|email|unique:institute_users,email';

  $rs = $req->validate([
    'upass' => 'required|min:6|max:12|confirmed',
  ],
  [
    'upass.required' => 'Please enter your Correct Password.',
    'upass.confirmed' => 'Password Not Matched.',
  ],
  [
    'upass' => 'Password',
  ]
);


    $rdata=[
      'password' => $req->upass,
    ];
   

    if($req->suser == 'faculty'){
      User::find($id)->update($rdata);
      return back()->with('success', 'Successfully Updated Password!');
    }
    else{
      InstituteUser::find($id)->update($rdata);
      return back()->with('success', 'Successfully Updated Password!');
    }
  }


  function deletingprofile(Request $req){
    if($req->has('otp')){
      if(now()->greaterThan(Session::get('otp_expire'))){
          return back()
              ->with('fail', 'OTP Expired. Please try again.')
              ->with('show_otp', true);
      }
      if($req->otp != Session::get('signup_otp')){
          return back()
              ->with('fail', 'Invalid OTP')
              ->with('show_otp', true);  
      }
      $rdata = Session::get('signup_data');
      $userdata = [
          'email' => $rdata['email'],
          'password' => $rdata['raw_password'], 
      ];

      if($rdata['role'] == 'faculty'){
          User::create($rdata);
          Auth::guard('web')->attempt($userdata);
      } 
      else{
          InstituteUser::create($rdata);
          Auth::guard('institute_users')->attempt($userdata);
      }
      Session::forget(['signup_otp', 'signup_data', 'otp_expire']);
      return redirect()->route('dashboard')->with('success', 'Signup Successful');
  }

  $emailRule = $req->suser == 'faculty'
      ? 'required|email|unique:users,email'
      : 'required|email|unique:institute_users,email';

  $req->validate([
      'uname' => 'required',
      'uemail' => $emailRule,
      'uphone' => 'required|phone:AUTO',
      'suser' => 'required',
      'upass' => 'required|min:6|max:12|confirmed',
  ]);

  $otp = rand(100000, 999999);

  $rdata = [
      'name' => $req->uname,
      'email' => $req->uemail,
      'phone' => $req->uphone,
      'role' => $req->suser,
      'img' => 'thumb.jpg',
      'password' => $req->upass,
      'raw_password' => $req->upass,
  ];

  Session::put('signup_otp', $otp);
  Session::put('signup_data', $rdata);
  Session::put('otp_expire', now()->addMinutes(1));

  Mail::to($req->uemail)->send(new SendOtpMail($otp));

  return back()->with('show_otp', true);
}

}