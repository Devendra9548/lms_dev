<div class="auth-box auth-box-signup editprofile">
    <h2 class="h5">Edit Information - {{ Auth::user()->name }}</h2>
    <div class="subtitle mb-4">You can edit below details.</div>

    <form action="{{route('updateprofile', Auth::user()->id)}}" method="POST" enctype="multipart/form-data" autocomplete="off">
        @csrf
        <input type="hidden" name="suser" value="{{ Auth::user()->role }}">
        <div class="my-4">
            <label>Full Name</label>
            <input type="text" class="form-control" value="{{ Auth::user()->name }}" placeholder="Enter Full Name"
                autocomplete="off" name="uname">
            @error('uname')
            <span class="text-danger fw-bold">{{ $message}}</span>
            @enderror
        </div>

        <div class="my-4">
            <label>Email</label>
            <input type="email" class="form-control" value="{{ Auth::user()->email }}" placeholder="Enter your email"
                autocomplete="off" name="uemail">
            @error('uemail')
            <span class="text-danger fw-bold">{{ $message}}</span>
            @enderror
        </div>

        <div class="my-4">
            <label>Phone Number</label> <br>
            <input type="tel" id="phone" class="form-control d-block" value="{{ Auth::user()->phone }}" name="uphone"
                autocomplete="off">

            @error('uphone')
            <span class="text-danger fw-bold">{{ $message }}</span>
            @enderror
        </div>

        <div class="my-4">
            <label class="form-label">Profile Image (Image size must not exceed 300KB.)</label>
            <input type="file" class="form-control" name="img" value="{{ Auth::user()->img }}"
                onchange="document.getElementById('changepf').src = window.URL.createObjectURL(this.files[0])" accept=".jpg,.jpeg,.png,.JPG,.JPEG,.PNG,.webp,image/*">
            @error('img')
            <span class="text-danger fw-bold">{{ $message}}</span><br>
            @enderror
            <br>
            <img src="/usersimg/{{ Auth::user()->img }}" alt="{{Auth::user()->name}}" width="120px" id="changepf">
            
        </div>

        <button class="btn btn-login w-100 mt-3 web-btn" type="submit">Update Information</button>
        <div class="bottom-text text-center mt-3">
            Want to change password? <a href="{{ route('editpassword', Auth()->user()->id) }}" wire:navigate>Click Here</a>
        </div>
        @if(session('success'))
        <div class="text-success fw-bold text-center mt-3">
            {{ session('success') }}
        </div>
        @endif

    </form>

</div>