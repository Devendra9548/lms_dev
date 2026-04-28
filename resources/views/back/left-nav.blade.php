<nav class="navbar navbar-light bg-white shadow-sm d-md-none">
    <div class="container-fluid">
        <button class="btn btn-primary" data-bs-target="#sidebarMenu">
            <i class="bi bi-list"></i>
        </button>
        <span class="fw-bold">Student LMS</span>
    </div>
</nav>
<div class="col-md-3 col-lg-2 p-0 sidebar">
    <div class="text-white" id="sidebarMenu">

        <div class="offcanvas-header d-md-none">
            <h5 class="offcanvas-title">Menu</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
        </div>

        <div class="offcanvas-body d-block px-3">

            <!-- Profile -->
            <div class="profile-box">
                <img src="/usersimg/{{ Auth::user()->img }}">
                <h6 class="mt-2 mb-0 text-capitalize">{{ Auth::user()->name }}</h6>
                <small class="text-capitalize">{{ Auth::user()->role }}</small>
            </div>

            <ul class="nav flex-column mt-4" id="menu">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{route('dashboard')}}" wire:navigate><i class="bi bi-speedometer2"></i>
                        Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('courses') ? 'active' : '' }}" href="{{route('courses')}}" wire:navigate><i class="bi bi-journal-bookmark"></i>
                        My Courses</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="bi bi-file-earmark-text"></i> Assignments</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="bi bi-bar-chart"></i> Grades</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="bi bi-chat-dots"></i> Messages</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="bi bi-shield-lock"></i> Security</a>
                </li>
                <li class="nav-item mt-3">
                    <a class="btn btn-danger w-100" href="{{route('logout')}}"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </li>
            </ul>

        </div>
    </div>
</div>
