<div>
    <div class="container">

        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">{{ $pageTitle }}</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $pageTitle }}</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <a href="{{ route('admin.sharedsafari.share.safari') }}" class="btn btn-primary ms-auto"> <i
                            class="lni lni-arrow-left"></i></a>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Join At</th>
                                <th>Seat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($interestedUsers as $index => $interestedUser)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        @if ($interestedUser?->user->profile_photo_path)
                                            <img src="{{ asset($interestedUser?->user->profile_photo_path) }}"
                                                width="40" height="40" alt="{{ $interestedUser?->user->name }}"
                                                class="rounded-circle bg-info object-fit-cover">
                                                <a href="{{ route('admin.user.details',$interestedUser->user->id) }}" class="text-dark">
                                                    {{ $interestedUser->user->name }}
                                                </a>
                                        @else
                                            <div class="d-flex">
                                                <div class="d-flex justify-content-center align-items-center rounded-circle bg-info text-white fw-bold"
                                                    style="width: 40px; height: 40px;">
                                                    {{ strtoupper(substr($interestedUser?->user->name, 0, 1)) }}
                                                </div>
                                                <span class="ms-2">
                                                    {{ $interestedUser->user->name }}
                                                </span>
                                            </div>
                                        @endif

                                    </td>
                                    <td>
                                        {{ $interestedUser->created_at->format('M-d-Y') }}

                                    </td>
                                    <td>
                                        @if ($interestedUser->user->sharedSafariSeats)
                                            <span class="badge bg-secondary" style="cursor: pointer;"
                                                wire:click="showAllotSlot({{ $interestedUser->user->user_id }})">
                                                {{ $interestedUser->user->sharedSafariSeats->number_of_seat }} Seat(s)
                                            </span>
                                            <button
                                                wire:click="deleteAllotedSeat({{ $interestedUser->user->user_id }})"
                                                class="btn btn-sm btn-danger ms-2">Delete</button>
                                        @else
                                            <button wire:click="showAllotSlot({{ $interestedUser->user->user_id }})"
                                                class="btn btn-sm btn-primary">Allot Seat</button>
                                        @endif

                                        @if ($selectedUserId === $interestedUser->user->user_id && $allotSlot)
                                            <div class="mb-3">
                                                <label for="" class="form-label">Seat</label>
                                                <input type="number" class="form-control" wire:model="seat_number"
                                                    min="1" />
                                                <button
                                                    wire:click="submitAllotedSeat({{ $interestedUser->user->user_id }})"
                                                    class="mt-2 btn btn-sm btn-success float-end">Submit</button>
                                                <button wire:click="$set('allotSlot', false)"
                                                    class="mt-2 btn btn-sm btn-secondary float-end me-2">Cancel</button>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <x-pagination :paginator="$interestedUsers" />
                </div>
            </div>
        </div>
    </div>
</div>
