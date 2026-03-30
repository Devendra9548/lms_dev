<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\InstituteUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

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
          return redirect()->route('dashboard')->with('success', 'Successful Login Faculty');
        }
        return back()->with('fail', 'Something Wrong. please try with different details');
      }
      else{
        $user = InstituteUser::where('email', $req->uemail)->first();
        if(Auth::guard('institute_users')->attempt($userdata)){
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
      $emailRule = $req->suser == 'faculty'
        ? 'required|email|unique:users,email'
        : 'required|email|unique:institute_users,email';

      $rs = $req->validate([
        'uname' => 'required',
        'uemail' => $emailRule,
        'uphone' => 'required|phone:AUTO',
        'suser' => 'required',
        'upass' => 'required|min:6|max:12|confirmed',
      ],
      [
        'uname.required' => 'Please enter your Correct Full Name.',
        'uemail.required' => 'Please enter your Correct Email.',
        'uphone.required' => 'Please enter your Correct Phone Number.',
        'upass.required' => 'Please enter your Correct Password.',
        'upass.confirmed' => 'Password Not Matched.',
        'uphone.phone' => 'Please enter your Correct Phone Number.'

      ],
      [
        'uemail' => 'Email',
        'upass' => 'Password',
        'suser' => 'User',
        
      ]
    );

    $rdata=[
      'name' => $req->uname,
      'email' => $req->uemail,
      'phone' => $req->uphone,
      'role' => $req->suser,
      'img' => 'thumb.jpg',
      'password' => $req->upass,
    ];
    $userdata=[
      'email' => $req->uemail,
      'password' => $req->upass,
    ];

    

    if($req->suser == 'faculty'){
      User::create($rdata);
      if(Auth::guard('web')->attempt($userdata)){
        return redirect()->route('dashboard')->with('success', 'Successful Login Faculty');
      }
      return back()->with('fail', 'Something Wrong. please try with different details');
    }
    else{
      InstituteUser::create($rdata);
      if(Auth::guard('institute_users')->attempt($userdata)){
        return redirect()->route('dashboard')->with('success', 'Successful Login Student');
      }
      return back()->with('fail', 'Something Wrong. please try with different details');
    }
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
    $emailRule = $req->suser == 'faculty'
    ? [
        'required',
        'email',
        Rule::unique('users', 'email')->ignore(auth()->id())
      ]
    : [
        'required',
        'email',
        Rule::unique('institute_users', 'email')->ignore(auth()->id())
      ];

      $rs = $req->validate([
        'uname' => 'required',
        'uemail' => $emailRule,
        'uphone' => 'required|phone:AUTO',
        'suser' => 'required',
        'img' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:300',
      ],
      [
        'uname.required' => 'Please enter your Correct Full Name.',
        'uemail.required' => 'Please enter your Correct Email.',
        'uphone.required' => 'Please enter your Correct Phone Number.',
        'uphone.phone' => 'Please enter your Correct Phone Number.',
        'img.image' => 'File must be an image.',
        'img.mimes' => 'Only JPG, JPEG, PNG, WEBP allowed.',
        'img.max' => 'Image size must not exceed 300KB.',
      ],
      [
        'uemail' => 'Email',
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
      'email' => $req->uemail,
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


}
