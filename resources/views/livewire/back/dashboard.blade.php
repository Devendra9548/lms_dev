@section('title', 'LMS - Dashboard')
@prepend('head-script')
@endprepend
<div>
    <h2 class="mb-4 h4">Welcome back, <span class="text-capitalize">{{ Auth::user()->name }}</span> 👋</h2>
    <!-- Stats -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow-sm p-3">
                <h6 class="text-muted">Enrolled Courses</h6>
                <h3>6</h3>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow-sm p-3">
                <h6 class="text-muted">Pending Assignments</h6>
                <h3>3</h3>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow-sm p-3">
                <h6 class="text-muted">Completed Tasks</h6>
                <h3>12</h3>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow-sm p-3">
                <h6 class="text-muted">Current GPA</h6>
                <h3>3.8</h3>
            </div>
        </div>
    </div>

    <!-- Courses & Activity -->
    <div class="row g-3">

        <!-- Recent Activity -->
        <div class="col-lg-6">
            <div class="card shadow-sm p-3">
                <h5 class="card-title">Recent Activity</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Submitted AI Assignment</li>
                    <li class="list-group-item">New message from Instructor</li>
                    <li class="list-group-item">Java Quiz graded</li>
                </ul>
            </div>
        </div>

        <!-- Login History -->
        <div class="col-lg-6">
            <div class="card shadow-sm p-3">
                <h5 class="card-title">Login Activity</h5>
                <p><strong>Last Login:</strong> Today 10:15 AM</p>
                <p><strong>Device:</strong> Chrome - Windows</p>
                <p><strong>IP:</strong> 192.168.1.24</p>
                <button class="btn btn-outline-primary btn-sm">Logout All Devices</button>
            </div>
        </div>

    </div>
    <div class="row g-3 mt-1">

        <!-- Account Information -->
        <div class="col-lg-6">
            <div class="card shadow-sm p-4">

                <h5 class="fw-bold mb-3">Account Information</h5>
                <hr>

                <div class="mb-2">
                    <strong>Name:</strong> <span class="text-capitalize">{{ Auth::user()->name }}</span>
                </div>

                <div class="mb-2">
                    <strong>Email:</strong> {{ Auth::user()->email }}
                </div>

                <div class="mb-2">
                    <strong>Phone:</strong> {{ Auth::user()->phone }}
                </div>

                <div class="mb-3">
                    <strong>Member Since:</strong> {{ Auth::user()->created_at->format('F d, Y') }}
                </div>

                <div class="d-flex flex-wrap gap-2">
                    <a class="btn btn-primary btn-sm" href="{{route('editprofile', Auth::user()->id)}}" wire:navigate>
                     <i class="bi bi-pencil-square"></i> Edit Profile</a>

                    <a class="btn btn-outline-secondary btn-sm" href="{{route('editpassword', Auth::user()->id)}}" wire:navigate>
                      Change Password</a>
                </div>

            </div>
        </div>


        <!-- Active Sessions -->
        <div class="col-lg-6">
            <div class="card shadow-sm p-4">

                <h5 class="fw-bold mb-3">Active Sessions</h5>
                <hr>

                <ul class="list-group list-group-flush">

                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <i class="bi bi-laptop me-2 text-primary"></i>
                            <strong>MacBook Pro</strong> - Chrome - New York, USA
                        </div>
                    </li>

                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <i class="bi bi-phone me-2 text-success"></i>
                            <strong>iPhone 12</strong> - Safari - Los Angeles, USA
                        </div>
                    </li>

                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <i class="bi bi-pc-display me-2 text-warning"></i>
                            <strong>Windows PC</strong> - Edge - Toronto, Canada
                        </div>
                    </li>

                </ul>

                <div class="mt-3 text-end">
                    <button class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-box-arrow-right"></i> Log Out All Devices
                    </button>
                </div>

            </div>
        </div>

    </div>
</div>


@push('foot-script')
@endpush