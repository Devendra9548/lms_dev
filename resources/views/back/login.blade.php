@extends('back.main')
@section('title')
Login - LMS
@endsection
@prepend('head-script')
<link rel="stylesheet" href="/css/admin/login.css" />
@endprepend

@section('main')
<div class="form-main d-flex align-items-center justify-content-center vh-100">

<div class="auth-box">
  <h2>Welcome back</h2>
  <div class="subtitle mb-4">Please enter your details.</div>

  <form action="{{route('logining')}}" method="POST" autocomplete="off">
    @csrf 
    <div class="my-3">
      <label>Email</label>
      <input type="email" class="form-control" placeholder="Enter your email" autocomplete="off" value="{{ old('uemail') }}" name="uemail">
      @error('uemail')
      <span class="text-danger fw-bold">{{ $message}}</span>
      @enderror
    </div>

    <div class="my-4">
      <label>Password</label>
      <input type="password" class="form-control" placeholder="Password" autocomplete="new-password" value="{{ old('upass') }}" name="upass">
      @error('upass')
      <span class="text-danger fw-bold">{{ $message}}</span>
      @enderror
    </div>

    <div class="my-3">
      <label>Select User</label>
      <select name="suser" id="suser" class="form-control">
        <option value="student">Student</option>
        <option value="faculty">Faculty</option>
      </select>
      @error('suser')
      <span class="text-danger fw-bold">{{ $message}}</span>
      @enderror
    </div>

    <div class="my-3 text-end">
      <a href="#" class="link">Forgot password</a>
    </div>

    <button class="btn btn-login w-100 mb-3 web-btn" type="submit">Login</button>

    <button type="button" class="btn btn-google w-100 d-flex align-items-center justify-content-center gap-2 mb-3">
      <img src="https://img.icons8.com/color/18/google-logo.png"/>
      Sign in with Google
    </button>
  </form>

  <div class="bottom-text text-center">
    Don’t have an account? <a href="{{ route('signup') }}">Sign up Now</a>
  </div>

  @if(session('success'))
  <div class="text-success fw-bold text-center mt-3">
     {{ session('success') }}
  </div>
  @endif
  @if(session('fail'))
  <div class="text-danger fw-bold text-center mt-3">
     {{ session('fail') }}
  </div>
  @endif
</div>

</div>
@endsection


@push('foot-script')
@endpush