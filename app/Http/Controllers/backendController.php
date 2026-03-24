<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class backendController extends Controller
{
    function login(){
        return view('back.login');
    }
    function signup(){
        return view('back.signup');
    }
    function signing(Request $req){
      $req->validate([
        'uname' => 'required',
        'uemail' => 'required',
        'uphone' => 'required',
        'upass' => 'required|confirmed',
      ],
      [
        'uname.required' => 'Please enter your Full Name.',
        'uemail.required' => 'Please enter your Email.',
        'uphone.required' => 'Please enter your Phone Number.',
        'upass.required' => 'Please enter your Correct Password.',
        'upass.confirmed' => 'Password Not Matched.',
      ]
    
    );

      return "Work";
    }
}
