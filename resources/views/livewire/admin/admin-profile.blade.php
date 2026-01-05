<div class="container">
    <div class="">

        <div class="row">
            <div class="col-6">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center ">
                        <h5 class="mb-0 fw-bold">Admin Profile</h5>
                    </div>
                    <div class="card-body">
                        <form wire:submit="updateProfile">
                            <div class="mb-3">
                                <label>Name</label>
                                <input type="text" class="form-control form-control-sm" wire:model="name">
                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" class="form-control form-control-sm" wire:model="email">
                                @error('email')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label class="form-label">Profile Photo</label>
                                        <input type="file"  class="form-control form-control-sm" accept=".jpg,.jpeg,.png,.webp,.JPG,.JPEG,.PNG,.WEBP" wire:model="profile_photo">
                                    </div>
                                    <div class="col-md-2 align-self-end">
                                        @if ($profile_photo)
                                        <img src="{{ $profile_photo->temporaryUrl() }}" class="img-thumbnail mt-2"
                                            style="max-width: 100px;">
                                        @elseif ($existing_photo)
                                        <img src="{{ asset($existing_photo) }}" class="img-thumbnail mt-2"
                                            style="max-width: 100px;">
                                        @else
                                        <span class="text-muted">No Profile Photo</span>
                                        @endif
                                    </div>
                                </div>

                                @error('profile_photo')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-success btn-sm">
                                Update
                                <i class="spinner-border spinner-border-sm" wire:loading wire:target="updateProfile"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                 <form wire:submit="changePassword" class="h-100">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center ">
                        <h5 class="mb-0 fw-bold">Change Password</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label>New Password</label>
                            <input type="password" class="form-control form-control-sm" wire:model="password">
                            @error('password')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label>Confirm Password</label>
                            <input type="password" class="form-control form-control-sm" wire:model="password_confirmation">
                        </div>

                        <button type="submit" class="btn btn-success btn-sm">
                             Change Password
                            <i class="spinner-border spinner-border-sm" wire:target="changePassword" wire:loading></i>
                        </button>

                    </div>
                </div>
                </form>
            </div>
        </div>



    </div>
</div>
