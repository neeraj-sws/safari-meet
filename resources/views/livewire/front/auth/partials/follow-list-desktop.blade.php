 @php

 @endphp

 <div class="desktop-view" id="desktopview">
     <div class="filter-sidebar-wrapper following-follower dark-grey-bg px-4 pt-2 pb-3 rounded-3 ">
         <nav class="overflow-auto">
             <ul class="nav nav-pills flex-nowrap flex-sm-nowrap d-flex border-0 gap-2" id="packageTab" role="tablist"
                 style="white-space: nowrap;">
                 <li class="nav-item" role="presentation">
                     <button class="nav-link fw-semibold {{ $activeStatus === 'following' ? 'active' : '' }} "
                         wire:click="followtoggle('following')" id="following-tab" type="button">Following</button>
                 </li>
                 <li class="nav-item" role="presentation">
                     <button
                         class="nav-link fw-semibold {{ $activeStatus === 'follower' ? 'active' : '' }} rounded-pill"
                         wire:click="followtoggle('follower')" id="follower-tab" type="button"
                         role="tab">Follower</button>
                 </li>
             </ul>
         </nav>

         <div class="tab-content" id="followTabContent">
             <div class="tab-pane fade {{ $activeStatus === 'following' ? 'show active' : '' }}" id="following"
                 role="tabpanel" aria-labelledby="following-tab">
                 <!-- Following Content -->
                 <!-- <p class="my-3">No Following.</p> -->
                 <div class="following-list my-3">
                     @if ($followinglists->isNotEmpty())
                         @foreach ($followinglists as $followinglist)
                             <ul class="list-unstyled" wire:key="following-{{ $followinglist->id }}">
                                 <li>
                                     <div class="d-flex align-items-center">
                                         <a href="javascript:void(0)"
                                             class="d-flex align-items-center text-decoration-none w-100">
                                             @if ($followinglist->following->profile_photo_path)
                                                 <img src="{{ asset($followinglist->following->profile_photo_path) }}"
                                                     alt="user-img" class="profile-user-icon rounded-circle">
                                             @else
                                                 <div class="profile-user-icon rounded-circle bg-primary text-white d-flex justify-content-center align-items-center"
                                                     style="width:40px; height:40px; font-weight:bold;">
                                                     {{ $this->userInitials($followinglist->following->name) }}
                                                 </div>
                                             @endif

                                             <div class="profile-username ms-3 text-dark">
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
                                                 class="btn btn-sm btn-primary blue-btn-hover border-0 rounded-1">Message</a>

                                             <div class="follows-dropdown dropdown">
                                                 <button class="btn p-0 border-0 bg-transparent" type="button"
                                                     id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                                     aria-expanded="false">
                                                     <i class="fa-solid fa-ellipsis-vertical"></i>
                                                 </button>
                                                 <ul class="dropdown-menu dropdown-menu-end"
                                                     aria-labelledby="dropdownMenuButton1">
                                                     <li>
                                                         <a class="dropdown-item text-blue" href="javascript:void(0)"
                                                             wire:click.stop="followToggleStatus({{ $followinglist->id }})">
                                                             Unfollow
                                                         </a>
                                                     </li>
                                                 </ul>
                                             </div>
                                         </div>
                                     </div>
                                 </li>
                             </ul>
                         @endforeach
                     @else
                         <div class="text-center text-muted py-3">
                             <i class="fas fa-user-slash fa-2x mb-2"></i><br>
                             <span>No following found</span>
                         </div>
                     @endif
                 </div>
             </div>
             <div class="tab-pane fade {{ $activeStatus === 'follower' ? 'show active' : '' }}" id="follower"
                 role="tabpanel" aria-labelledby="follower-tab">
                 <div class="follower-list my-3">
                     @if ($followerlists->isNotEmpty())
                         @foreach ($followerlists as $followerlist)
                             <ul class="list-unstyled mt-3" wire:key="follower-{{ $followerlist->id }}">
                                 <li class="mb-3">
                                     <div class="d-flex align-items-center">
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
                                                     {{ $followerlist->follower->username }}</p>
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
                                                     wire:click.stop = "followToggleStatus({{ $followerlist->id }})"
                                                     id="dropdownMenuButton1">
                                                     <i class="fa-solid fa-xmark"></i>
                                                 </button>
                                             </div>
                                         </div>
                                     </div>

                                 </li>
                             </ul>
                         @endforeach
                     @else
                         <div class="text-center text-muted py-3">
                             <i class="fas fa-user-slash fa-2x mb-2"></i><br>
                             <span>No follower found</span>
                         </div>
                     @endif
                 </div>
             </div>
         </div>
     </div>
 </div>
