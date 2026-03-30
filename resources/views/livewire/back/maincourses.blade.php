@section('title', 'LMS - About Us')
@prepend('head-script')
@endprepend
<div>
   <h4 class="mb-4">Welcome back, <span class="text-capitalize">{{ Auth::user()->name }}</span> 👋</h4>
   <h2>Course Page</h2>
</div>
@push('foot-script')
@endpush