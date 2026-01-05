<div>
    <style>
        /* Profile avatar wrapper */
        .profileavtar {
            width: 40px;
            height: 40px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .profileavtar img {
            border: 2px solid #fff;
            transition: transform 0.3s ease;
        }

        .profileavtar:hover img {
            transform: scale(1.05);
        }

        /* Hover card styling */
        .profile-hover-card {
            position: absolute;
            top: -10px;
            left: 50px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            padding: 10px 12px;
            /* width: 180px; */
            z-index: 99;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.25s ease;
        }

        /* Show card on hover */
        .profileavtar:hover .profile-hover-card {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        /* Text inside hover card */
        .profile-hover-card strong {
            font-size: 14px;
            display: block;
            margin-bottom: 4px;
        }

        .profile-hover-card .profile-stats small {
            font-size: 12px;
        }

        /* Follow button */
        .profile-hover-card .follow-btn {
            border: none;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 12px;
            cursor: pointer;
            transition: 0.2s;
            width: 100%;
        }

        .profile-hover-card .follow-btn:hover {
            background-color: #007acc;
        }
    </style>
    <div class="profileavtar position-relative" id="{{ $userList->id }}">
        @php
            $avatarUrl = $userList?->profile_photo_path ? asset($userList?->profile_photo_path) : null;
            $fallbackInitial = strtoupper(substr($userList?->name, 0, 1));
            $bgColor = '#' . substr(md5($userList?->id), 0, 6);
        @endphp
        @if ($avatarUrl)
            <img src="{{ $avatarUrl }}" class="rounded-circle" width="40" height="40" alt="{{ $userList?->name }}">
        @else
            <div class="user-avatar rounded-circle d-flex align-items-center justify-content-center text-white fw-bold"
                style="width: 40px; height: 40px; background-color: {{ $bgColor }};">
                {{ $fallbackInitial }}
            </div>
        @endif

        <div class="profile-hover-card">
            <strong>{{ $userList?->name }}</strong>
            @if ($showEmail)
                <span><small>{{ $userList?->email }}</small></span><br>
            @endif
            @if ($userType == 'user')
                <div class="profile-stats d-flex justify-content-between text-muted mt-1">
                    <small><b>{{ $followerList }}</b> Followers</small>
                    <small><b>{{ $followingList }}</b> Following</small>
                </div>
                <a href="javascript:void(0)" wire:click.stop="toggleFollow({{ $userList->id }})"
                    class="follow-btn mt-2 btn btn-sm {{ $this->isFollowing($userList->id) ? 'btn-outline-secondary' : 'btn-primary' }}  blue-btn-hover border-0 rounded-1">{{ $this->isFollowing($userList->id) ? 'Unfollow' : 'Follow' }}</a>
            @endif
        </div>
    </div>
</div>
