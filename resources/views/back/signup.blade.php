@extends('back.main')
@section('title', 'Sign Up - LMS')
@prepend('head-script')
<link rel="stylesheet" href="/css/admin/login.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css"/>
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/intlTelInput.min.js"></script>
@endprepend

@section('main')
<div class="form-main d-flex align-items-center justify-content-center mt-4">

<div class="auth-box auth-box-signup">
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
    <label>Phone Number</label> <br>
    <input type="tel" id="phone" class="form-control d-block" value="{{ old('uphone') }}" name="uphone" autocomplete="off">

    @error('uphone')
        <span class="text-danger fw-bold">{{ $message }}</span>
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

    <div class="my-3">
      <label>Password</label>
      <input type="password" class="form-control" placeholder="Password" autocomplete="new-password" name="upass">
      @error('upass')
      <span class="text-danger fw-bold">{{ $message}}</span>
      @enderror
    </div>

    <div class="my-3">
      <label>Confirm Password</label>
      <input type="password" class="form-control" placeholder="Password" autocomplete="new-password" name="upass_confirmation">
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
<script>
    const input = document.querySelector("#phone");

    const iti = window.intlTelInput(input, {
        initialCountry: "in",       
        separateDialCode: true,
        preferredCountries: ["in"],    
        onlyCountries: [
            "in", "us", "gb", "ae", "sa", "ca", "au"
        ],

        utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js"
    });

    document.querySelector("form").addEventListener("submit", function () {
        input.value = iti.getNumber();
    });
</script>
@endpush