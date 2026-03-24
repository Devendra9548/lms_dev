@extends('back.main')
@section('title')
Sign Up - LMS
@endsection
@prepend('head-script')
<link rel="stylesheet" href="/css/admin/login.css" />
@endprepend

@section('main')
<div class="form-main d-flex align-items-center justify-content-center vh-100">

<div class="auth-box">
  <h2>Sign Up Now</h2>
  <div class="subtitle mb-4">Please enter your details.</div>

  <form action="{{route('signing')}}" method="POST" autocomplete="off">
    @csrf 
    <div class="my-3">
      <label>Full Name</label>
      <input type="text" class="form-control" value="{{ old('uname') }}" placeholder="Enter Full Name" autocomplete="off" name="uname">
      @error('uname')
      <span class="text-danger fw-bold">{{ $message}}</span>
      @enderror
    </div>

    <div class="my-3">
      <label>Email</label>
      <input type="email" class="form-control" value="{{ old('uemail') }}" placeholder="Enter your email" autocomplete="off" name="uemail">
      @error('uemail')
      <span class="text-danger fw-bold">{{ $message}}</span>
      @enderror
    </div>

    <div class="my-3">
      <label>Phone Number</label>
      <input type="text" class="form-control" value="{{ old('uphone') }}" placeholder="Phone Number" autocomplete="off" name="uphone">
      @error('uphone')
      <span class="text-danger fw-bold">{{ $message}}</span>
      @enderror
    </div>

    <div class="my-3">
      <label>Password</label>
      <input type="password" class="form-control" placeholder="Password" autocomplete="new-password" name="upass">
      @error('upass')
      <span class="text-danger fw-bold">{{ $message}}</span>
      @enderror
    </div>

    <div class="my-3">
      <label>Confirm Password</label>
      <input type="password" class="form-control" placeholder="Password" autocomplete="new-password" name="password_confirmation">
    </div>

    <button class="btn btn-login w-100 mt-3 web-btn" type="submit">Sign Up</button>
    <a href="{{route('login')}}" class="mt-3 w-100 d-flex align-items-center justify-content-center">
      Login Now?
    </a>

  </form>

</div>

</div>
@endsection


@push('foot-script')
@endpush