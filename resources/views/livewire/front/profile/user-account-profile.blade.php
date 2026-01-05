<div>
    <div class="dark-grey-bg rounded-3">
        <div class="card mb-1 rounded-3">
            <div class="card-body">

                <!-- About -->
                <div class="mb-3">
                    <h6 class="fs-6 fw-bold">About</h6>
                    <p>{{ $user->short_description }}</p>
                </div>

                <!-- Social Media -->
                <div class="">
                    <h6 class="fs-6 fw-bold">Social Media</h6>
                    <div class="sociel_icons iconSmall mt-3 border-2">
                        <ul class="list-unstyled">
                            <li class="mb-3">
                                <div class="d-flex gap-2 align-items-center flex-wrap">
                                    <a href="{{ $user->instagram }}"
                                        class="d-flex align-items-center iconSize text-decoration-none dropdown-item">
                                        <i class="fa-brands fa-instagram text-blue"></i>
                                        <span class="ms-2 fw-bold text-blue">Instagram:</span>
                                    </a>
                                    <p class="mt-1 mb-0 text-break">
                                        {{ $user->instagram }}</p>
                                </div>
                            </li>
                            <li class="mb-3">
                                <div class="d-flex gap-2 align-items-center flex-wrap">
                                    <a href="{{ $user->facebook }}"
                                        class="d-flex align-items-center iconSize text-decoration-none dropdown-item">
                                        <i class="fa-brands fa-facebook-f text-blue"></i>
                                        <span class="ms-2 fw-bold text-blue">Facebook:</span>
                                    </a>
                                    <p class="mt-1 mb-0 text-break">
                                        {{ $user->facebook }}</p>
                                </div>
                            </li>
                            <li class="mb-3">
                                <div class="d-flex gap-2 align-items-center flex-wrap">
                                    <a href="{{ $user->youtube }}"
                                        class="d-flex align-items-center iconSize text-decoration-none dropdown-item">
                                        <i class="fa-brands fa-youtube text-blue"></i>
                                        <span class="ms-2 fw-bold text-blue">YouTube:</span>
                                    </a>
                                    <p class="mt-1 mb-0 text-break">
                                        {{ $user->youtube }}</p>
                                </div>
                            </li>
                            <li class="mb-3">
                                <div class="d-flex gap-2 align-items-center flex-wrap">
                                    <a href="{{ $user->twitter }}"
                                        class="d-flex align-items-center iconSize text-decoration-none dropdown-item">
                                        <i class="fa-brands fa-x-twitter text-blue"></i>
                                        <span class="ms-2 fw-bold text-blue">Twitter:</span>
                                    </a>
                                    <p class="mt-1 mb-0 text-break">{{ $user->twitter }}
                                    </p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
