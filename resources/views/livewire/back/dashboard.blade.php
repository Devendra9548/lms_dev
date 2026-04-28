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


    <div class="row g-3">
        <!-- Login Activity -->
        <div class="col-lg-6">
            <div class="card shadow-sm p-4">

                <h5 class="fw-bold mb-3">Login Activity</h5>
                <hr>
                <div wire:ignore>
                    <canvas id="activityChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Account Information -->
        <div class="col-lg-6">
            <div class="card shadow-sm p-4 h-100">

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

                    <a class="btn btn-outline-secondary btn-sm" href="{{route('editpassword', Auth::user()->id)}}"
                        wire:navigate>
                        Change Password</a>
                </div>

            </div>
        </div>


    </div>
    <!-- Courses & Activity -->
    <div class="row g-3 mt-1">

        <!-- Login History -->
        <div class="col-lg-12">
            <div class="card shadow-sm p-3">
                <h5 class="card-title">Login History</h5>
                <hr>
                @foreach($activities as $activity)
                <div class="infobox">
                    <p class="mb-0"><strong>IP Address:</strong> {{ $activity->ip_address }}</p>
                    <p class="mb-0"><strong>Device:</strong> {{ $activity->browser }} - {{ $activity->platform }}</p>
                    <p class="mb-0"><strong>Location:</strong> {{ $activity->location }}</p>
                    <p class="mb-0">
                        <strong>Last Login:</strong>
                        {{ \Carbon\Carbon::parse($activity->login_at)->format('d M Y, h:i A') }}
                    </p>
                </div>
                @endforeach
                <div class="btn-logout my-2">
                    <a class="btn btn-danger" href="{{route('logoutactivity', Auth::user()->id)}}"><i
                            class="fas fa-sign-out-alt"></i>
                        Logout All Devices</a>
                </div>
            </div>
        </div>

    </div>
</div>


@push('foot-script')

<script>
document.addEventListener("DOMContentLoaded", function() {

    function initChart() {
        const data = @json($graphData);

        const labels = data.map(item => item.date);
        const totals = data.map(item => item.total);

        const ctx = document.getElementById('activityChart');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'My Login Activity',
                    data: totals,
                    borderWidth: 2,
                    fill: true,
                }]
            }
        });
    }

    initChart();

    // Livewire v2 / v3 support
    document.addEventListener("livewire:load", function() {
        initChart();
    });

    document.addEventListener("livewire:navigated", function() {
        initChart();
    });

});
</script>
@endpush