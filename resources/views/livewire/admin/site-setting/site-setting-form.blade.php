<div>
    <div class="card">
        <div class="card-body">
            <form wire:submit="save">
                <div class="mb-3">
                    <label class="form-label">Site Status</label>
                    <select class="form-control" wire:model="key.site_status">
                        <option value="live" @selected($key['site_status'] == 'live')>Live</option>
                        <option value="maintenance" @selected($key['site_status'] == 'maintenance')>Maintenance</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Timezone</label>
                    <select class="form-control" wire:model="key.timezone">
                        @foreach (timezone_identifiers_list() as $tz)
                            <option value="{{ $tz }}" @selected($tz == $key['timezone'])>{{ $tz }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- <div class="mb-3">
                    <label class="form-label">Language</label>
                    <select class="form-control" wire:model="key.language">
                        <option value="en">English</option>
                        <option value="hi">Hindi</option>
                        <option value="fr">French</option>
                        <!-- Add more as needed -->
                    </select>
                </div> --}}

                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-9">
                            <label class="form-label">Favicon</label>
                            <input type="file" class="form-control" accept=".jpg,.jpeg,.png,.webp,.JPG,.JPEG,.PNG,.WEBP" wire:model="favicon">
                        </div>
                        <div class="col-md-2 align-self-end">
                            @if ($favicon)
                                <img src="{{ $favicon->temporaryUrl() }}" class="img-fluid" style="max-width: 64px;">
                            @elseif(!empty($key['existing_favicon']))
                                <img src="{{ asset($key['existing_favicon']) }}" class="img-fluid"
                                    style="max-width: 64px;">
                            @else
                                <span class="text-muted">No Favicon</span>
                            @endif
                        </div>
                    </div>
                    @error('favicon')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Site Name</label>
                    <input type="text" class="form-control @error('key.site_name') is-invalid @enderror"
                        wire:model="key.site_name">
                    @error('key.site_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Phone Number</label>
                    <input type="number" class="form-control @error('key.phone_number') is-invalid @enderror"
                        wire:model="key.phone_number">
                    @error('key.phone_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Site Email</label>
                    <input type="email" class="form-control @error('key.site_email') is-invalid @enderror"
                        wire:model="key.site_email">
                    @error('key.site_email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <input type="text" class="form-control @error('key.address') is-invalid @enderror"
                        wire:model="key.address">
                    @error('key.address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Footer Text</label>
                    <textarea class="form-control" rows="3" wire:model="key.footer_text"></textarea>
                </div>

                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-9">
                            <label class="form-label">Site Logo</label>
                            <input type="file" class="form-control" wire:model="site_logo" accept=".jpg,.jpeg,.png,.webp,.JPG,.JPEG,.PNG,.WEBP" >
                        </div>
                        <div class="col-md-2">
                            @if ($site_logo)
                                <img src="{{ $site_logo->temporaryUrl() }}" class="img-fluid"
                                    style="max-width: 200px;max-height: 200px">
                            @elseif(!empty($key['existing_logo']))
                                <img src="{{ asset($key['existing_logo']) }}" class="img-fluid"
                                    style="max-width: 200px;max-height: 200px">
                            @else
                                <span class="text-muted">No Image Selected</span>
                            @endif
                        </div>
                    </div>

                    @error('site_logo')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success">
                        Save
                        <i class="spinner-border spinner-border-sm" wire:loading></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
