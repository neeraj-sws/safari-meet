<?php

namespace App\Livewire\Admin\ShareSafari;

use App\Helpers\UserHelper;
use App\Mail\DynamicMail;
use App\Models\JoinSharedSafari;
use App\Models\SafariAllottedSeat;
use App\Models\ShareSafari;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin-app')]
class IntertedUserLists extends Component
{
    use WithPagination;
    public $shareSafari;
    public $selectedUserId;
    public $allotSlot = false;
    public $seat_number;
    public $totalallottedSeats;
    public $pageTitle = "Interested User List";
    public function mount($uuid)
    {
        $this->shareSafari = ShareSafari::with(['park'])->where('uuid', $uuid)->first();
    }
    public function render()
    {
        $shareSafariId = $this->shareSafari->id;
        $interestedUsers = JoinSharedSafari::with([
            'user' => function ($query) use ($shareSafariId) {
                $query->select('user_id', 'name')
                    ->with(['sharedSafariSeats' => function ($q) use ($shareSafariId) {
                        $q->where('shared_safari_id', $shareSafariId)
                            ->select('safari_allotted_seat_id', 'shared_safari_id', 'user_id', 'number_of_seat');
                    }]);
            }
        ])
            ->where('share_safari_id', $shareSafariId)
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.share-safari.interted-user-lists', compact('interestedUsers'));
    }

    public function showAllotSlot($userId)
    {
        $this->selectedUserId = $userId;
        $this->allotSlot = true;

        $seat = SafariAllottedSeat::where('user_id', $userId)
            ->where('shared_safari_id', $this->shareSafari->id)
            ->first();

        $this->seat_number = $seat->number_of_seat ?? null;
    }

    public function submitAllotedSeat($userId)
    {
        if (!$this->seat_number || $this->seat_number <= 0) {
            $this->dispatch('swal:toast', [
                'type' => 'error',
                'message' => "Seat must be greater than 0",
            ]);
            return;
        }

        $checkUser = SafariAllottedSeat::with('allottedUser')
            ->where('user_id', $userId)
            ->where('shared_safari_id', $this->shareSafari->id)
            ->first();

        $existingSeat = $checkUser?->number_of_seat ?? 0;

        $totalAllottedSeats = SafariAllottedSeat::where('shared_safari_id', $this->shareSafari->id)
            ->sum('number_of_seat');

        $totalSeatCount = ($totalAllottedSeats - $existingSeat) + $this->seat_number;

        if ($totalSeatCount > $this->shareSafari->share_seats) {
            $this->dispatch('swal:toast', [
                'type' => 'error',
                'message' => "Only " . ($this->shareSafari->share_seats - ($totalAllottedSeats - $existingSeat)) . " seats are available.",
            ]);
            return;
        }

        if ($checkUser) {
            $checkUser->number_of_seat = $this->seat_number;
            $checkUser->save();
            $user = $checkUser->allottedUser;

            $data = [
                "email_subject" => "Your Safari Seat Has Been Updated",
                'name' => $user->name,
                "message_body" => "Your seat details have been updated by the Safari Organizer. Please review the updated details below.",
                "safaris" => $this->shareSafari->title,
                "start_date" => $this->shareSafari->day,
                "end_date" => $this->shareSafari->night,
                "seat_count" => $this->seat_number,
                'year' => date('Y'),
            ];

            $parsed = UserHelper::parseTemplate('SEATALLOTED', $data);
            Mail::to($user->email)->queue(new DynamicMail($parsed['subject'], $parsed['body']));

            $type = ($this->shareSafari->organized_type == 'admin') ? 'App\Models\Admin' : 'App\Models\User';
            createNotification(
                6,
                $user->id,
                get_class($user),
                $this->shareSafari->organized_by,
                $type,
                [
                    'user_name' => Auth::guard('admin')->user()->name,
                    'safari_id' => $this->shareSafari->id,
                    'safari_name' => $this->shareSafari->title ?? null,
                    'message' => Auth::guard('admin')->user()->name . ' Left ' . $this->shareSafari->title . ' shared safari.',
                    'safari_url' => route('shared-safari.detail', ['slug' => $this->shareSafari->slug])
                ]
            );
        } else {
            $safarialloted = SafariAllottedSeat::create([
                'shared_safari_id' => $this->shareSafari->id,
                'user_id' => $userId,
                'number_of_seat' => $this->seat_number,
            ]);
            $safarialloted->load('allottedUser');
            $user = $safarialloted->allottedUser;

            $data = [
                "email_subject" => "Your Safari Seat Has Been Allotted",
                'name' => $user->name,
                "message_body" => "Good news! Your seat for the Shared Safari has been successfully allotted. Please check the details below.",
                "safaris" => $this->shareSafari->title,
                "start_date" => $this->shareSafari->day,
                "end_date" => $this->shareSafari->night,
                "seat_count" => $this->seat_number,
                'year' => date('Y'),
            ];
            $parsed = UserHelper::parseTemplate('SEATALLOTED', $data);
            Mail::to($user->email)->queue(new DynamicMail($parsed['subject'], $parsed['body']));

            $type = ($this->shareSafari->organized_type == 'admin') ? 'App\Models\Admin' : 'App\Models\User';
            createNotification(
                7,
                $user->id,
                get_class($user),
                $this->shareSafari->organized_by,
                $type,
                [
                    'user_name' => Auth::guard('admin')->user()->name,
                    'safari_id' => $this->shareSafari->id,
                    'safari_name' => $this->shareSafari->title ?? null,
                    'safari_url' => route('shared-safari.detail', ['slug' => $this->shareSafari->slug])
                ]
            );
        }

        $isSeatFull = ($totalSeatCount == $this->shareSafari->share_seats);
        $this->shareSafari->is_seat_full = $isSeatFull ? 1 : 0;
        $this->shareSafari->save();

        $allottedUserIds = SafariAllottedSeat::where('shared_safari_id', $this->shareSafari->id)->pluck('user_id');
        $interestedUsers = JoinSharedSafari::with('user')
            ->where('share_safari_id', $this->shareSafari->id)
            ->whereNotIn('user_id', $allottedUserIds)
            ->get();

        $wishlistUsers = Wishlist::with('user')
            ->where('shared_safari_id', $this->shareSafari->id)
            ->whereNotIn('user_id', $allottedUserIds)
            ->get();
        $allUsers = $interestedUsers
            ->merge($wishlistUsers)
            ->filter(fn($item) => !empty($item->user))
            ->unique('user_id')
            ->values();

        foreach ($allUsers as $entry) {
            $user = $entry->user;

            if (!$user || empty($user->email)) {
                continue;
            }

            $type = ($this->shareSafari->organized_type == 'admin') ? 'App\Models\Admin' : 'App\Models\User';
            createNotification(
                10,
                $user->id,
                get_class($user),
                $this->shareSafari->organized_by,
                $type,
                [
                    'user_name' => Auth::guard('web')->user()->name,
                    'safari_id' => $this->shareSafari->id,
                    'safari_name' => $this->shareSafari->title ?? null,
                    'safari_url' => route('shared-safari.detail', ['slug' => $this->shareSafari->slug])
                ]
            );

            $data = [
                'email_subject' => $isSeatFull
                    ? 'Seats Of Safari ' . $this->shareSafari->title . ' is Now Full'
                    : 'Good News! A Safari Seat Is Now Available',

                'name' => $user->name,

                'message_body' => $isSeatFull
                    ? 'We wanted to let you know that all seats for the safari you were interested in are now full. Stay tuned — more slots may open soon!'
                    : 'Exciting news! A seat has just become available for the safari you were interested in.',

                'safari_name' => $this->shareSafari->title,
                'start_date' => $this->shareSafari->day,
                'end_date' => $this->shareSafari->night,
                'location' => $this->shareSafari->park->name,
                'shared_safari_link' => route('shared-safari.list'),
                'package_safari_link' => route('safari-package.list'),

                'extra_message' => $isSeatFull
                    ? '😞 Unfortunately, all seats for this safari are now <strong>fully booked</strong>.<br>
        But don’t worry! You can explore other exciting <a href="' . route('shared-safari.list') . '" style="color:#1b4332;text-decoration:underline;">Shared Safaris</a>
        or check our <a href="' . route('safari-package.list') . '" style="color:#1b4332;text-decoration:underline;">Package Safaris</a>.'
                    : '🎉 Good news! A seat has become <strong>available again</strong> for this safari.<br>
        Please <strong>contact the organizer</strong> as soon as possible to confirm your booking and secure your seat.',

                'year' => date('Y'),
            ];

            $parsed = UserHelper::parseTemplate('SEAT_STATUS_UPDATE', $data);
            Mail::to($user->email)->queue(new DynamicMail($parsed['subject'], $parsed['body']));
        }

        $this->allottedSetsUser();
        $this->dispatch('swal:toast', [
            'type' => 'success',
            'message' => "Seat Allotted Successfully",
        ]);

        $this->allotSlot = false;
        $this->selectedUserId = null;
        $this->seat_number = null;
    }


    public function allottedSetsUser()
    {
        $this->totalallottedSeats = SafariAllottedSeat::where('shared_safari_id', $this->shareSafari->id)->get();
    }

    public function deleteAllotedSeat($userId)
    {
        $checkUser = SafariAllottedSeat::with('allottedUser')
            ->where('user_id', $userId)
            ->where('shared_safari_id', $this->shareSafari->id)
            ->first();

        if (!$checkUser) {
            $this->dispatch('swal:toast', [
                'type' => 'error',
                'message' => "Seat not found.",
            ]);
            return;
        }
        $wasSeatFull = (bool) $this->shareSafari->is_seat_full;

        SafariAllottedSeat::where('user_id', $userId)
            ->where('shared_safari_id', $this->shareSafari->id)
            ->delete();

        $data = [
            "email_subject" => "Your Safari Seat Has Been Revoked",
            'name' => $checkUser->allottedUser->name,
            "message_body" => "We regret to inform you that your seat for the Shared Safari has been disallowed by the organizer. Please contact the organizer for further details.",
            "safaris" => $this->shareSafari->title,
            "start_date" => $this->shareSafari->day,
            "end_date" => $this->shareSafari->night,
            "seat_count" => $checkUser->number_of_seat,
            'year' => date('Y'),
        ];

        $parsed = UserHelper::parseTemplate('SEATALLOTED', $data);
        Mail::to($checkUser->allottedUser->email)->queue(
            new DynamicMail($parsed['subject'], $parsed['body'])
        );


        $totalAllottedSeats = SafariAllottedSeat::where('shared_safari_id', $this->shareSafari->id)
            ->sum('number_of_seat');

        $isSeatFull = ($totalAllottedSeats >= $this->shareSafari->share_seats);

        $this->shareSafari->is_seat_full = $isSeatFull ? 1 : 0;
        $this->shareSafari->save();

        if ($wasSeatFull && !$isSeatFull) {
            $allottedUserIds = SafariAllottedSeat::where('shared_safari_id', $this->shareSafari->id)
                ->pluck('user_id');

            $interestedUsers = JoinSharedSafari::with('user')
                ->where('share_safari_id', $this->shareSafari->id)
                ->whereNotIn('user_id', $allottedUserIds)
                ->get();

            $wishlistUsers = Wishlist::with('user')
                ->where('shared_safari_id', $this->shareSafari->id)
                ->whereNotIn('user_id', $allottedUserIds)
                ->get();
            $allUsers = $interestedUsers
                ->merge($wishlistUsers)
                ->filter(fn($item) => !empty($item->user))
                ->unique('user_id')
                ->values();

            foreach ($allUsers as $entry) {
                $user = $entry->user;

                if (!$user || empty($user->email)) {
                    continue;
                }

                $type = ($this->shareSafari->organized_type == 'admin') ? 'App\Models\Admin' : 'App\Models\User';
                createNotification(
                    11,
                    $user->id,
                    get_class($user),
                    $this->shareSafari->organized_by,
                    $type,
                    [
                        'user_name' => Auth::guard('web')->user()->name,
                        'safari_id' => $this->shareSafari->id,
                        'safari_name' => $this->shareSafari->title ?? null,
                        'safari_url' => route('shared-safari.detail', ['slug' => $this->shareSafari->slug])
                    ]
                );

                $data = [
                    'email_subject' => 'Good News! A Safari Seat Is Now Available',
                    'name' => $user->name,
                    'message_body' => 'Exciting news! A seat has just become available for the safari you were interested in.',
                    'safari_name' => $this->shareSafari->title,
                    'start_date' => $this->shareSafari->day,
                    'end_date' => $this->shareSafari->night,
                    'location' => $this->shareSafari->park->name,
                    'shared_safari_link' => route('shared-safari.list'),
                    'package_safari_link' => route('safari-package.list'),
                    'extra_message' => '🎉 Good news! A seat has become <strong>available again</strong> for this safari.<br>
                    Please <strong>contact the organizer</strong> as soon as possible to confirm your booking and secure your seat.',
                    'year' => date('Y'),
                ];

                $parsed = UserHelper::parseTemplate('SEAT_STATUS_UPDATE', $data);
                Mail::to($user->email)->queue(new DynamicMail($parsed['subject'], $parsed['body']));
            }
        }

        $type = ($this->shareSafari->organized_type == 'admin') ? 'App\Models\Admin' : 'App\Models\User';
        createNotification(
            5,
            $checkUser->user_id,
            'App\Models\User',
            $this->shareSafari->organized_by,
            $type,
            [
                'user_name' => Auth::guard('admin')->user()->name,
                'safari_id' => $this->shareSafari->id,
                'safari_name' => $this->shareSafari->title ?? null,
                'safari_url' => route('shared-safari.detail', ['slug' => $this->shareSafari->slug])
            ]
        );

        $this->allottedSetsUser();
        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => '',
            'message' => "Seat Deleted Successfully",
        ]);

        $this->allotSlot = false;
        $this->selectedUserId = null;
        $this->seat_number = null;
    }

    public function updating()
    {
        $this->resetPage();
    }
}
