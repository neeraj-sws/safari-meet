<div>
    <div class="dark-grey-bg rounded-3">
        <div class="card mb-1 rounded-3">
            <div class="card-body">
                <form wire:submit.prevent="save">
                    <div class="row gx-2">
                        <!-- Email (Read Only) -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <p class="form-control-plaintext">{{ $user->email }}
                            </p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">User handle</label>
                            <p class="form-control-plaintext">{{ $user->username }}</p>
                        </div>

                        <!-- Name -->
                        <div class="col-md-4 mb-3">
                            <label for="name" class="form-label fw-semibold">Name
                                <span class="text-danger">*</span></label>
                            <input type="text" class="form-control text-capitalize" id="name"
                                oninput="filterAndFormatInputs(this,{allowAlpha:true})" placeholder="Enter name"
                                wire:model="name">
                            @error('name')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- DOB -->
                        <div class="col-md-4 mb-3">
                            <label for="dob" class="form-label fw-semibold">D.O.B.</label>
                            <input type="text" class="form-control datepicker flatpickr-input"
                                data-restrict-future="true" data-nostart="null" wire:model="dob">
                            {{-- <input type="date" class="form-control" id="dob"
                                                            wire:model="dob"> --}}
                            @error('dob')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Gender -->
                        <div class="col-md-4 mb-3">
                            <label for="gender" class="form-label fw-semibold">Gender</label>
                            <select class="form-select" id="gender" wire:model.defer="gender">
                                <option>Choose Gender</option>
                                <option value="female">Female</option>
                                <option value="male" selected>Male</option>
                                <option value="other">Other</option>
                            </select>
                            @error('gender')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label  ">Country
                                <span class="text-danger">*</span></label>
                            <select class="form-select select2" wire:model="country" id="country">
                                <option value="">Select Country</option>
                                @foreach ($countries as $key => $item)
                                    <option @selected($key == $country) value="{{ $key }}">
                                        {{ $item }}</option>
                                @endforeach
                            </select>
                            @error('country')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label  ">State
                                <span class="text-danger">*</span></label>
                            <select class="form-select select2" wire:model="state" id="state">
                                <option value="">Select State</option>
                                @foreach ($states as $key => $item)
                                    <option @selected($key == $state) value="{{ $key }}">
                                        {{ $item }}</option>
                                @endforeach
                            </select>
                            @error('state')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label  ">City
                                <span class="text-danger">*</span></label>
                            <select class="form-select select2" wire:model="city" id="city">
                                <option value="">Select City</option>
                                @foreach ($cities as $key => $item)
                                    <option @selected($key == $city) value="{{ $key }}">
                                        {{ $item }}</option>
                                @endforeach
                            </select>
                            @error('state')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        @if ($user->user_type == 1)
                            <div class="col-md-4 mb-3">
                                <label class="form-label  ">Agency Name
                                    <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" wire:model="agency_name" />
                                @error('agency_name')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label  ">License Number
                                    <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" wire:model="license_number" />
                                @error('license_number')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label  ">Contact Person
                                    <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" wire:model="contact_person" />
                                @error('contact_person')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label  ">Phone Number
                                    <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" wire:model="phone_number"
                                    oninput="filterPhoneNumber(this)" />
                                @error('phone_number')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label  ">Website </label>
                                <input type="text" class="form-control" wire:model="website_url" />
                                @error('website_url')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif

                        <!-- Profile Description -->
                        <div class="col-12 mb-3">
                            <label for="profileDesc" class="form-label fw-semibold">You
                                are</label>
                            <textarea class="form-control" id="profileDesc" rows="2" wire:model="profileDesc"
                                placeholder="Profile Description eg: Wildlife | Nature"></textarea>
                            @error('profileDesc')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- About -->
                        <div class="col-12 mb-3">
                            <label for="about" class="form-label fw-semibold">About</label>
                            <textarea class="form-control" id="about" placeholder="About" rows="3" wire:model="about"></textarea>
                            @error('about')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Social Media -->
                        <div class="col-sm-6 mb-3">
                            <label class="form-label fw-semibold">Facebook</label>
                            <input type="url" class="form-control" placeholder="https://facebook.com/yourprofile"
                                wire:model="facebook">
                            @error('facebook')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-sm-6 mb-3">
                            <label class="form-label fw-semibold">Instagram</label>
                            <input type="url" class="form-control"
                                placeholder="https://instagram.com/yourprofile" wire:model="instagram">
                            @error('instagram')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-sm-6 mb-3">
                            <label class="form-label fw-semibold">YouTube</label>
                            <input type="url" class="form-control"
                                placeholder="https://youtube.com/channel/yourchannel" wire:model="youtube">
                            @error('youtube')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-sm-6 mb-3">
                            <label class="form-label fw-semibold">X</label>
                            <input type="url" class="form-control" placeholder="https://x.com/yourhandle"
                                wire:model="twitter">
                            @error('twitter')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 mb-3">
                        <div class="col-md-12 mb-3">
                            <label for="coverImage" class="form-label fw-semibold">Cover Image</label>
                            <input type="file" class="form-control" id="coverImage" wire:model="coverImage"
                                accept=".jpg,.jpeg,.png,.webp,.JPG,.JPEG,.PNG,.WEBP">
                            <small>Expected Image 1800x300 px.</small><br>
                            @error('coverImage')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                        @if (!empty($coverImage))
                            <div class="col-md-12 mb-3">
                                <img src="{{ $coverImage->temporaryUrl() }}" alt="Cover Image" class="img-fluid" />
                            </div>
                        @elseif (!empty($uploadedprofile) && empty($coverImage))
                            <div class="col-md-12 mb-3">
                                <img src="{{ asset($uploadedprofile) }}" alt="Cover Image" class="img-fluid" />
                            </div>
                        @endif
                    </div>

                    <!-- Save Button -->
                    <div class="text-end">
                        <button type="submit" wire:loading.attr="disabled" class="btn btn-primary px-4"
                            wire:target="save">
                            <span wire:loading.remove wire:target="save">Save</span>
                            <span wire:loading wire:target="save">
                                <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                Saving...
                            </span>
                        </button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function filterPhoneNumber(input) {
        let value = input.value.replace(/[^0-9]/g, ''); // Remove non-digits

        // Prevent starting with 0
        if (value.startsWith('0')) {
            value = value.slice(1);
        }

        // Allow max 5 same digits in a row
        let newValue = '';
        let count = 1;

        for (let i = 0; i < value.length; i++) {
            if (i > 0 && value[i] === value[i - 1]) {
                count++;
                if (count > 5) {
                    continue; // Block the digit beyond 5 repeats
                }
            } else {
                count = 1;
            }
            newValue += value[i];
        }

        // Limit to 10 digits total
        input.value = newValue.slice(0, 10);
    }
</script>
