@extends('back.main')
@section('title', 'Reset Password - LMS')
@prepend('head-script')
<link rel="stylesheet" href="/css/admin/login.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css" />
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/intlTelInput.min.js"></script>
<style>
body {
    background-image: url('/imgs/bg.webp');
    background-size:cover;
    background-repeat:no-repeat;
    background-position:center center;
    min-height:100vh;
}
</style>
@endprepend

@section('main')
<section class="bgimg">
    <div class="row m-0 p-0">
        <div class="col-12 col-md-6"></div>
        <div class="col-12 col-md-6 d-flex align-items-center justify-content-center">
            <div class="form-main d-flex align-items-center justify-content-center py-5">

                <div class="auth-box auth-box-signup">
                    <h2>Reset Password</h2>
                    <div class="subtitle mb-4">Please enter your details.</div>

                    <form action="{{route('recoverpassword')}}" method="POST" autocomplete="off">
                        @csrf

                        @if(session('show_otp'))
                        <div class="my-3">
                            <label>Create New Password</label>
                            <input type="password" class="form-control" placeholder="Password"
                                autocomplete="new-password" name="upass">
                            @error('upass')
                            <span class="text-danger fw-bold">{{ $message}}</span>
                            @enderror
                        </div>

                        <div class="my-3">
                            <label>Confirm Password</label>
                            <input type="password" class="form-control" placeholder="Password"
                                autocomplete="new-password" name="upass_confirmation">
                        </div>

                        <div class="my-3">
                            <label>Enter OTP</label>
                            <input type="text" name="otp" class="form-control" placeholder="Enter OTP">
                        </div>

                        @else
                        <div class="my-3">
                            <label>Email</label>
                            <input type="email" class="form-control" value="{{ old('uemail') }}"
                                placeholder="Enter your email" autocomplete="off" name="uemail">
                            @error('uemail')
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
                            <span class="text-danger fw-bold">Please Try again</span>
                            @enderror
                        </div>
                        @endif


                        <button class="btn btn-login w-100 mt-3 web-btn" type="submit">
                            @if(session('show_otp'))
                            Create New Password
                            @else
                            Reset Password
                            @endif
                        </button>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#roleModal"
                            class="btn btn-google w-100 d-flex align-items-center justify-content-center gap-2 mb-1 mt-2">
                            <img src="https://img.icons8.com/color/18/google-logo.png" />
                            Sign in with Google
                        </button>

                        <a href="{{route('login')}}"
                            class="mt-0 w-100 d-flex align-items-center justify-content-center">
                            Login Now?
                        </a>

                        @if(session('fail'))
                        <div class="alert alert-danger">
                            {{ session('fail') }}
                        </div>
                        @endif

                    </form>

                </div>

            </div>
        </div>
    </div>
</section>
<!-- Role Selection Modal -->
<div class="modal fade" id="roleModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4">

      <div class="modal-header border-0">
        <h5 class="modal-title w-100 text-center">Continue as</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body text-center">

        <button onclick="redirectGoogle('student')" 
                class="btn btn-outline-primary w-100 mb-3">
            🎓 I am Student
        </button>

        <button onclick="redirectGoogle('faculty')" 
                class="btn btn-outline-dark w-100">
            👨‍🏫 I am Faculty
        </button>

      </div>

    </div>
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

document.querySelector("form").addEventListener("submit", function() {
    input.value = iti.getNumber();
});
</script>
<script>
function redirectGoogle(role) {
    window.location.href = "/auth/google?role=" + role;
}
</script>
@endpush