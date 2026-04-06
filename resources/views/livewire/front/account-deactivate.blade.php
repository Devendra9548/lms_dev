@section('title', 'LMS - Account Deactivated')
@prepend('head-script')
@endprepend
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow border-0 rounded-4">
                <div class="card-body text-center p-5">
                    <div class="mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="#ffc107"
                            class="bi bi-person-x-fill" viewBox="0 0 16 16">
                            <path d="M11 6a3 3 0 1 0-6 0 3 3 0 0 0 6 0z" />
                            <path fill-rule="evenodd"
                                d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37c.69-.595 1.62-1.12 2.868-1.47C6.32 10.66 7.14 10.5 8 10.5c.86 0 1.68.16 2.6.4 1.248.35 2.178.875 2.868 1.47A7 7 0 0 0 8 1z" />
                            <path
                                d="M12.146 11.354a.5.5 0 0 1 .708 0L14 12.5l1.146-1.146a.5.5 0 0 1 .708.708L14.707 13.207l1.147 1.146a.5.5 0 0 1-.708.708L14 13.914l-1.146 1.147a.5.5 0 0 1-.708-.708l1.147-1.146-1.147-1.147a.5.5 0 0 1 0-.706z" />
                        </svg>
                    </div>
                    <h3 class="fw-bold mb-3 text-warning">Account Deactivated</h3>
                    <p class="text-muted mb-4">
                        Your account has been deactivated. Please contact the administrator for further assistance or
                        reactivation.
                    </p>
                    <div class="d-grid gap-2">
                        <a href="mailto:admin@example.com" class="btn btn-warning rounded-pill">
                            Contact Administrator
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-secondary rounded-pill">
                            Back to Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('foot-script')
@endpush