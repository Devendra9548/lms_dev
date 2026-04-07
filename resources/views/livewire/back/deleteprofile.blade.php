@section('title', 'LMS - Delete Profile')

<div class="auth-box auth-box-signup editprofile">
    @if($showForm)
    <h2 class="h5">{{ Auth::user()->name }}. Are you Sure you want to Delete Account?</h2>
    <div class="subtitle mb-4">Enter OTP For Delete.</div>

    
    <form wire:submit.prevent="deleteProfile" method="POST" autocomplete="off">
        @csrf
        <input type="hidden" name="suser" value="{{ Auth::user()->role }}">
        
        <div class="my-4">
            <label>Reason*</label>
            <textarea name="reason" class="form-control" wire:model="reason" placeholder="Type Reason." id="reason" cols="30" rows="10"></textarea>
            @error('reason')
            <span class="text-danger fw-bold">{{ $message}}</span>
            @enderror
        </div>
        <div class="my-4">
            <label>Enter OTP (Please check your Mail Box)*</label>
            <input type="text" name="otp" wire:model="otp" class="form-control" placeholder="Enter OTP">
            @error('otp')
            <span class="text-danger fw-bold">{{ $message}}</span>
            @enderror
        </div>

        <button class="btn btn-danger w-100 mt-3" type="submit">Delete Account</button>
        <div class="bottom-text text-center mt-3">
            Want to Back? <a href="{{ route('dashboard') }}" wire:navigate>Click Here</a>
        </div>
        

    </form>
    @endif
    
    @if(session('success'))
        <div class="text-success fw-bold text-center mt-3">
            {{ session('success') }}
        </div>
    @endif

</div>


