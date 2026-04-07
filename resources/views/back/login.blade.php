@extends('back.main')
@section('title')
Login - LMS
@endsection
@prepend('head-script')
<link rel="stylesheet" href="/css/admin/login.css" />
<style>
body {
    background-image: url('/imgs/bg.png');
    background-size: cover;
    background-repeat: no-repeat;
    background-position: top center;
    min-height:100vh;
}
</style>
@endprepend

@section('main')
<section class="bgimg">
    <div class="row m-0 p-0">
        <div class="col-12 col-md-6"></div>
        <div class="col-12 col-md-6 d-flex align-items-center justify-content-center">
            <div class="form-main d-flex align-items-center justify-content-center vh-100">

                <div class="auth-box">
                    <h2>Welcome back</h2>
                    <div class="subtitle mb-4">Please enter your details.</div>

                    <form action="{{route('logining')}}" method="POST" autocomplete="off">
                        @csrf
                        <div class="my-3">
                            <label>Email</label>
                            <input type="email" class="form-control" placeholder="Enter your email" autocomplete="off"
                                value="{{ old('uemail') }}" name="uemail">
                            @error('uemail')
                            <span class="text-danger fw-bold">{{ $message}}</span>
                            @enderror
                        </div>

                        <div class="my-4">
                            <label>Password</label>
                            <input type="password" class="form-control" placeholder="Password"
                                autocomplete="new-password" value="{{ old('upass') }}" name="upass">
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
                            <a href="{{route('forget-password')}}" class="link">Forgot password</a>
                        </div>

                        <button class="btn btn-login w-100 mb-3 web-btn" type="submit">Login</button>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#roleModal"
                            class="btn btn-google w-100 d-flex align-items-center justify-content-center gap-2 mb-3">
                            <img src="https://img.icons8.com/color/18/google-logo.png" />
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
function redirectGoogle(role) {
    window.location.href = "/auth/google?role=" + role;
}
</script>
@endpush















