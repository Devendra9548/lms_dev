<div class="auth-box auth-box-signup editprofile">
    <h2 class="h5">Edit Information - {{ Auth::user()->name }}</h2>
    <div class="subtitle mb-4">You can edit below details.</div>

    <form action="{{route('updatepassword', Auth::user()->id)}}" method="POST" autocomplete="off">
        @csrf
        <input type="hidden" name="suser" value="{{ Auth::user()->role }}">

        <div class="my-3">
            <label>Password</label>
            <input type="password" class="form-control" value="********" placeholder="Password"
                autocomplete="new-password" name="upass">
            @error('upass')
            <span class="text-danger fw-bold">{{ $message}}</span>
            @enderror
        </div>

        <div class="my-3">
            <label>Confirm Password</label>
            <input type="password" class="form-control" value="********" placeholder="Password"
                autocomplete="new-password" name="upass_confirmation">
        </div>


        <button class="btn btn-login w-100 mt-3 web-btn" type="submit">Update Information</button>
        <div class="bottom-text text-center mt-3">
            Want to edit profile? <a href="{{ route('editprofile', Auth()->user()->id) }}" wire:navigate>Click Here</a>
        </div>
        @if(session('success'))
        <div class="text-success fw-bold text-center mt-3">
            {{ session('success') }}
        </div>
        @endif

    </form>

</div>