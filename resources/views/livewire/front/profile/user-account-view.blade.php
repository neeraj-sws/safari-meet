<div>
    <section id="profile-cover" class="position-relative mb-5">
        <div class="cover-image"
            style="background-image: url('{{ $user->coverImage ? asset($user->coverImage) : asset('front-assets/images/banner-image/banner-2.jpg') }}')">
            <div class="overlay w-100 h-100 bg-dark bg-opacity-50"></div>
        </div>

        <div class="container-lg container-inner-padding position-relative">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="row align-items-center gy-4">

                        <!-- Profile Image & Info -->
                        <div class="col-12 col-lg-6 d-sm-flex align-items-center">
                            <!-- Profile Image -->
                            <div class="profile-img-wrapper position-relative text-center">
                                <input type="file" id="uploadProfile" accept=".jpg,.jpeg,.png,.webp,.JPG,.JPEG,.PNG,.WEBP" class="d-none"
                                    wire:model="profile_photo">

                                <a href="javascript:void(0);"
                                    onclick="document.getElementById('uploadProfile').click();">
                                    <!-- Camera Icon -->
                                    <div
                                        class="position-absolute profile-img-icon bg-white rounded-circle shadow d-flex align-items-center justify-content-center">
                                        <i class="fa-solid fa-camera text-blue p-2"></i>
                                    </div>

                                    <!-- Profile Picture -->
                                    <img id="profileImagePreview"
                                        src="{{ $user->profile_photo_path ? asset($user->profile_photo_path) : asset('front-assets/images/icons/user-img.jpeg') }}"
                                        alt="Profile Picture" class="rounded-5 border border-white border-4 shadow-sm">
                                </a>
                            </div>

                            @error('profile_photo')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror


                            <!-- User Info -->
                            <div class="">
                                <div class="profile-user-text ms-3 text-center text-lg-start mt-3 mt-lg-0">
                                    <h2 class="mb-0">{{ $user->name }}</h2>
                                    <p class="text-muted mb-0">{{ $user->short_title }}</p>
                                </div>
                                <div class="edit-share ms-3 mt-3 text-sm-start text-center" wire:ignore>
                                    @if ($isProfileRoute)
                                        <a href="{{ route('profile-edit') }}"
                                            class="btn btn-sm btn-primary blue-btn-hover border-0 rounded-1 me-2">
                                            Edit Profile
                                        </a>
                                    @elseif (request()->routeIs('profile-edit'))
                                        <a href="{{ route('profile') }}"
                                            class="btn btn-sm btn-primary blue-btn-hover border-0 rounded-1 me-2">
                                            Back to Profile
                                        </a>
                                    @endif
                                    <div class="follows-dropdown dropdown d-inline-block d-none">
                                        <button class="btn p-0 border-0 bg-transparent" type="button"
                                            id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-share text-blue"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end social-share-list"
                                            aria-labelledby="dropdownMenuButton1">
                                            <li class="mb-1">
                                                <div class="d-flex gap-2 align-items-center flex-wrap">
                                                    <a href="javascript:void(0)"
                                                        class="d-flex align-items-center iconSize text-decoration-none dropdown-item text-blue fw-bold text-blue">
                                                        <i class="fa-brands fa-instagram text-blue me-2"></i>
                                                        Instagram
                                                    </a>
                                                </div>
                                            </li>
                                            <li class="mb-1">
                                                <div class="d-flex gap-2 align-items-center flex-wrap">
                                                    <a href="javascript:void(0)"
                                                        class="d-flex align-items-center iconSize text-decoration-none dropdown-item text-blue fw-bold text-blue">
                                                        <i class="fa-brands fa-facebook-f text-blue me-2"></i>
                                                        Facebook
                                                    </a>
                                                </div>
                                            </li>
                                            <li class="mb-1">
                                                <div class="d-flex gap-2 align-items-center flex-wrap">
                                                    <a href="javascript:void(0)"
                                                        class="d-flex align-items-center iconSize text-decoration-none dropdown-item text-blue fw-bold text-blue">
                                                        <i class="fa-brands fa-youtube text-blue me-2"></i>
                                                        YouTube
                                                    </a>
                                                </div>
                                            </li>
                                            <li class="mb-1">
                                                <div class="d-flex gap-2 align-items-center flex-wrap">
                                                    <a href="javascript:void(0)"
                                                        class="d-flex align-items-center iconSize text-decoration-none dropdown-item text-blue fw-bold text-blue">
                                                        <i class="fa-brands fa-x-twitter text-blue me-2"></i>
                                                        Twitter
                                                    </a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Follower Stats -->
                        <div class="col-12 col-lg-6 px-xl-3 px-0">
                            <div class="row text-center follow-list gy-2 gx-0 ">
                                <div class="col-6 col-sm-3 border-end px-2">
                                    <p class="mb-0">Followers</p>
                                    <span>{{ $followerList->count() }}</span>
                                </div>
                                <div class="col-6 col-sm-3 border-end px-2">
                                    <p class="mb-0">Following</p>
                                    <span>{{ $followingList->count() }}</span>
                                </div>
                                <div class="col-6 col-sm-3 border-end px-2">
                                    <p class="mb-0">Safari Organized</p>
                                    <span> <a href="{{ route('profile',['tab' => 'shared-safari']) }}" class="text-decoration-none" >{{ $SafariOrganized }} </a></span>
                                </div>
                                <div class="col-6 col-sm-3">
                                    <p class="mb-0">Safari Joined</p>
                                   <span><a href="{{ route('profile',['tab' => 'shared-safari']) }}" class="text-decoration-none" >{{ $SafariJoined }} </a></span>
                                </div>
                            </div>
                            <div class="row mt-4 g-0">
                                <div class="col-12 text-sm-end text-center d-none">
                                    <div class="account-delete mb-1 d-inline-block">
                                        <!-- Deactivate Account -->
                                        <a href="javascript:void(0)"
                                            class="btn btn-sm border-bg blue-btn-hover border-0 rounded-1 me-2">Deactivate
                                            Account</a>
                                    </div>
                                    <div class="account-delete mb-1 d-inline-block">

                                        <!-- Delete Account -->
                                        <a href="javascript:void(0)"
                                            class="btn btn-sm border-bg blue-btn-hover border-0 rounded-1 me-2">Delete
                                            Account</a>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
                 @if (request()->routeIs('profile-edit') &&  !$user->is_profile_complete)
                    <div class="mt-4 alert alert-warning d-flex justify-content-between align-items-center mb-3 rounded-3 shadow-sm"
                        style="background-color: #fff8e1; border-left: 5px solid #ff9800; padding: 15px 20px;">
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-circle-exclamation text-warning me-2"></i>
                            <p class="mb-0" style="color: #333; font-size: 15px;">
                                <strong>Action Required:</strong> Please complete your profile to unlock all features and
                                build trust in the community.
                                <a href="{{ route('whyVefrifyProfile') }}" class="fw-semibold text-decoration-underline text-dark ms-1">
                                    Why verify your profile?
                                </a>
                            </p>
                        </div>
                        {{-- <a href="#"
                            class="btn btn-sm  text-white fw-semibold px-3" style="background-color: #085055;">Verify Now</a> --}}
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>
