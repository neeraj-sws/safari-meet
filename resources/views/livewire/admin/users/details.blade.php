<div class="container" id="agentDetails">
    @include('livewire.components.breadcrumb', [
        'menu' => 'Users',
        'submenus' => [['Users' => route('admin.allUser')], 'Details'],
        'backButton' => true,
    ])

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card p-3 text-center">
                <div class="">
                    <img src="{{ asset($agent->profile_photo_path ?? 'assets/images/user.png') }}" alt="Profile"
                        class="img-fluid rounded-circle mb-3" style="width: 120px;">
                </div>
                <h5>{{ $agent->name }}</h5>
                <p class="text-muted">{{ $agent->email }}</p>
                <span
                    class="badge bg-{{ $agent->status ? 'success' : 'danger' }}">{{ $agent->status ? 'Active' : 'Inactive' }}</span>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card p-3">
                <h6 class="fw-bold border-bottom pb-2 mb-3">Personal Info</h6>
                <div class="row mb-2">
                    <div class="col-md-6"><strong>Phone:</strong> {{ $agent->phone_number }}</div>
                    <div class="col-md-6"><strong>Gender:</strong> {{ $agent->gender }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6"><strong>DOB:</strong> {{ $agent->dob }}</div>
                    <div class="col-md-6"><strong>country: </strong>{{ $agent?->country?->name }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6"><strong>State: </strong>{{ $agent?->state?->name }}</div>
                    <div class="col-md-6"><strong>City: </strong>{{ $agent?->city?->name }}</div>
                </div>

                <h6 class="fw-bold border-bottom pb-2 mt-4 mb-3">Social Media</h6>
                <div class="row mb-2">
                    <div class="col-md-6"><strong>Facebook:</strong> {{ $agent->facebook }}</div>
                    <div class="col-md-6"><strong>Instagram:</strong> {{ $agent->instagram }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6"><strong>YouTube:</strong> {{ $agent->youtube }}</div>
                    <div class="col-md-6"><strong>Twitter:</strong> {{ $agent->twitter }}</div>
                </div>

                <h6 class="fw-bold border-bottom pb-2 mt-4 mb-3">Device Info</h6>
                <div class="row mb-2">
                    <div class="col-md-6"><strong>IP:</strong> {{ $agent->ip_address }}</div>
                    <div class="col-md-6"><strong>Browser:</strong> {{ $agent->browser }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6"><strong>OS:</strong> {{ $agent->os }}</div>
                    <div class="col-md-6"><strong>Device:</strong> {{ $agent->device }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6"><strong>Login At:</strong> {{ $agent->login_at }}</div>
                    <div class="col-md-6"><strong>Logout At:</strong> {{ $agent->logout_at }}</div>
                </div>

                <h6 class="fw-bold border-bottom pb-2 mt-4 mb-3">Other Info</h6>
                <div class="row">
                    <div class="col-md-6"><strong>Created At:</strong> {{ $agent->created_at }}</div>
                    <div class="col-md-6"><strong>Updated At:</strong> {{ $agent->updated_at }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
