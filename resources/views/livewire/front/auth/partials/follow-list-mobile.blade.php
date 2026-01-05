<div>
    @if ($type == 'following')
        <div class="card mt-lg-4 rounded-3">
            <div class="card-body">
                <h6 class="fw-bold">Following</h6>
                @foreach ($followinglists as $followinglist)
                    <ul class="list-unstyled mt-3">
                        <li class="mb-3">
                            <div class="d-flex align-items-center">
                                <!-- Clickable Area (Image + Text inside anchor) -->
                                <a href="javascript:void(0)" class="d-flex align-items-center text-decoration-none w-100">
                                    @if ($followinglist->following->profile_photo_path)
                                        <img src="{{ asset($followinglist->following->profile_photo_path) }}"
                                            alt="user-img" class="profile-user-icon rounded-circle">
                                    @else
                                        <div class="profile-user-icon rounded-circle bg-primary text-white d-flex justify-content-center align-items-center"
                                            style="width:40px; height:40px; font-weight:bold;">
                                            {{ $this->userInitials($followinglist->following->name) }}
                                        </div>
                                    @endif

                                    <div class="profile-username ms-lg-3 ms-2 text-dark">
                                        <p class="mb-0 profile-user-name text-truncate">
                                            {{ $followinglist->following->username }}
                                        </p>
                                        <p class="mb-0 profile-person-name text-truncate">
                                            {{ $followinglist->following->name }}
                                        </p>
                                    </div>
                                </a>

                                <!-- Buttons Section -->
                                <div class="message-btn d-flex align-items-center ms-3 gap-2">
                                    <a href="javascript:void(0)"
                                        class="btn btn-sm btn-primary blue-btn-hover border-0 rounded-1 d-sm-block d-none">Message
                                    </a>
                                    <a href="javascript:void(0)"
                                        class="btn btn-sm text-blue border-0 rounded-1 d-sm-none d-block py-0">
                                        <i class="fa-regular fa-message d-sm-none d-block"></i>

                                    </a>
                                    <div class="follows-dropdown dropdown">
                                        <button class="btn p-0 border-0 bg-transparent" type="button"
                                            id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end"
                                            aria-labelledby="dropdownMenuButton1">
                                            {{-- <li><a class="dropdown-item text-blue" href="#">Mute</a>
                                            </li> --}}
                                            <li><a class="dropdown-item text-blue" href="javascript:void(0)"
                                                    wire:click = "followToggleStatus({{ $followinglist->id }})">Unfollow</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </li>
                    </ul>
                @endforeach
            </div>
        </div>
    @else
        <div class="card mt-lg-4 rounded-3">
            <div class="card-body">
                <h6 class="fw-bold">Follower</h6>
                <!-- <p class="mt-3">No Follower</p> -->
                @foreach ($followerlists as $followerlist)
                    <ul class="list-unstyled mt-3">
                        <li class="mb-3">
                            <div class="d-flex align-items-center">
                                <!-- Clickable Area (Image + Text inside anchor) -->
                                <a href="javascript:void(0)"
                                    class="d-flex align-items-center text-decoration-none w-100">
                                    @if ($followerlist->follower->profile_photo_path)
                                        <img src="{{ asset($followerlist->follower->profile_photo_path) }}"
                                            alt="user-img" class="profile-user-icon rounded-circle">
                                    @else
                                        <div class="profile-user-icon rounded-circle bg-primary text-white d-flex justify-content-center align-items-center"
                                            style="width:40px; height:40px; font-weight:bold;">
                                            {{ $this->userInitials($followerlist->follower->name) }}
                                        </div>
                                    @endif

                                    <div class="profile-username ms-lg-3 ms-2 text-dark">
                                        <p class="mb-0 profile-user-name text-truncate">
                                            {{ $followerlist->follower->username }}
                                        </p>
                                        <p class="mb-0 profile-person-name text-truncate">
                                            {{ $followerlist->follower->name }}
                                        </p>
                                    </div>
                                </a>

                                <!-- Buttons Section -->
                                <div class="message-btn d-flex align-items-center ms-3 gap-2">
                                    <a href="javascript:void(0)"
                                        class="btn btn-sm btn-primary blue-btn-hover border-0 rounded-1 d-sm-block d-none">Message
                                    </a>
                                    <a href="javascript:void(0)"
                                        class="btn btn-sm text-blue border-0 rounded-1 d-sm-none d-block py-0">
                                        <i class="fa-regular fa-message d-sm-none d-block"></i>

                                    </a>
                                    <div class="follows-dropdown">
                                        <button class="btn p-0 border-0 bg-transparent" type="button"
                                            wire:click = "followToggleStatus({{ $followerlist->id }})"
                                            id="dropdownMenuButton1">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </li>
                    </ul>
                @endforeach
            </div>
        </div>
    @endif


</div>
