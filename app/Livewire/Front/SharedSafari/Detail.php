<?php

namespace App\Livewire\Front\SharedSafari;

use App\Helpers\UserHelper;
use App\Mail\DynamicMail;
use App\Models\ShareSafari;
use App\Models\{Admin, SafariFaq, FeaturePackageSafari, FeatureThingsToCarrySafari, ItineraryPackage, JoinSharedSafari, ParkFaq, Report, ReportResion, SafariAllottedSeat, SafariConversation, SafariConversationMessage, SafariDiscussion, User, Wishlist};
use Livewire\Component;
use Livewire\Attributes\Layout;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class Detail extends Component
{

    use WithPagination;

    public $shareSafari, $durationText, $similarPackages, $faqs, $carousel = true;
    public $dataInclusions, $dataExclusions, $dataAmenities = [], $itineraries = [], $thingsToCarries = [], $types, $organizer;
    public $discussions = [], $content, $replyBox, $dynamicTabs = [], $showUsersList = false, $userCountList = [];
    public $showChatBox = false, $joinededSafariSafri = 0, $conversation;
    public $allotSlot = false, $seat_number, $totalallottedSeats = [], $selectedUserId, $leavesharedSafariId;
    public $replyContent = [], $wishlistTitle = "Add Wishlist";
    public $reportDiscussionId;
    public $selectedResion;
    public $notes;
    public $reportResions = [];
    public $showReportModal = false, $type = 'user';


    public function mount($slug)
    {
        $this->shareSafari = ShareSafari::with([
            'detailsTabs',
            'dynamicTabs',
            'park.state',
            'category',
            'safariTypes.types',
            'park.parkSafariTypes',
            'park.parkBestTimes.weather',
            'joinedsafari',
            'allottedSeat',
        ])->where('slug', $slug)->first();
        if (empty($this->shareSafari)) {
            return redirect()->route('error.landing');
        }
        $this->faqs = ParkFaq::where('park_id', $this->shareSafari->park->id)->get()->toArray();
        $this->types = $this->shareSafari->safariTypes->pluck('types.name')->filter()->implode(', ');
        $this->dynamicTabs = $this->shareSafari->dynamicTabs;
        if ($this->shareSafari->organized_type == 'user') {
            $this->organizer =   User::find($this->shareSafari->organized_by);
            $this->type = "user";
        } elseif ($this->shareSafari->organized_type == 'agent') {
            $this->organizer =   User::find($this->shareSafari->organized_by);
            $this->type = "user";
        } elseif ($this->shareSafari->organized_type == 'admin') {
            $this->organizer = Admin::find($this->shareSafari->organized_by);
            $this->type = "admin";
        }
        $allData = FeaturePackageSafari::where('share_safari_id', $this->shareSafari->id)
            ->get()
            ->toArray();
        $this->thingsToCarries = FeatureThingsToCarrySafari::where('share_safari_id', $this->shareSafari->id)
            ->get();

        $this->dataInclusions = array_filter($allData, function ($item) {
            return $item['type'] == 1;
        });

        $this->dataExclusions = array_filter($allData, function ($item) {
            return $item['type'] == 2;
        });
        $this->dataAmenities = array_filter($allData, function ($item) {
            return $item['type'] == 3;
        });

        $this->itineraries = ItineraryPackage::with('packageActivities')->where('share_safari_id', $this->shareSafari->id)->orderBy('order_by', 'asc')->get();
        $start = Carbon::parse($this->shareSafari->start_date);
        $end = Carbon::parse($this->shareSafari->end_date);
        $days = $start->diffInDays($end) + 1;
        $nights = $days - 1;
        $this->durationText = "{$nights} Nights / {$days} Days";
        $this->similarPackages = ShareSafari::with('park.state')->where('safari_park_id', $this->shareSafari->safari_park_id)->where('status', 1)->whereNot('slug', $slug)->get();
        $checkWishlist = Wishlist::where('shared_safari_id', $this->shareSafari->id)
            ->where('user_id', Auth::id())
            ->first();
        if ($checkWishlist) {
            $this->wishlistTitle = "Remove Wishlist";
        }
        $this->userListCount();
        $this->loadJoinSharedSafari();
        $this->allottedSetsUser();
    }
    #[Layout('components.layouts.guest')]
    public function render()
    {
        $interestedUsers = JoinSharedSafari::with('user')
            ->where('share_safari_id', $this->shareSafari->id)
            ->orderBy('updated_at', 'desc')
            ->latest()
            ->paginate(10);

        $this->loadDiscussions();

        return view('livewire.front.shared-safari.detail', compact('interestedUsers'));
    }

    private function loadDiscussions()
    {
        $this->discussions = SafariDiscussion::with(['user', 'admin', 'replies'])
            ->where('share_safari_id', $this->shareSafari->id)
            ->whereNull('parent_id')
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function discussionReplyBox($id)
    {
        $this->replyBox = $this->replyBox === $id ? null : $id;
    }

    public function save($parentId = null)
    {
        $field   = $parentId ? "replyContent.$parentId" : "content";
        $content = $parentId ? ($this->replyContent[$parentId] ?? '') : $this->content;

        $this->validate([
            $field => 'required|string|max:500',
        ], [
            "$field.required" => 'Please write something before posting.',
        ]);

        $urlPattern = '/\b((https?:\/\/)?(www\.)?[a-z0-9-]+(\.[a-z]{2,})(\/\S*)?)/i';

        if (preg_match($urlPattern, $content)) {
            return $this->dispatch('swal:toast', [
                'type' => 'error',
                'message' => 'You cannot share links, domains, or websites in your message.',
            ]);
            return back()->withErrors([
                $field => 'You cannot share links, domains, or websites in your message.',
            ]);
        }

        SafariDiscussion::create([
            'share_safari_id' => $this->shareSafari->id,
            'user_id'         => Auth::id() ?? 0,
            'content'         => $content,
            'is_admin'        => 0,
            'parent_id'       => $parentId,
        ]);


        if ($parentId) {
            unset($this->replyContent[$parentId]);
        } else {
            $this->content = '';
        }
        $this->replyBox = null;
        $this->loadDiscussions();

        $receiver_type = ($this->shareSafari->organized_type == 'admin') ? 'App\Models\Admin' : 'App\Models\User';
        createNotification(
            14,
            $this->shareSafari->organized_by,
            $receiver_type,
            Auth::guard('web')->id(),
            get_class(Auth::guard('web')->user()),
            [
                'user_name' => Auth::guard('web')->user()->name,
                'safari_id' =>  $this->shareSafari->id,
                'safari_name' =>  $this->shareSafari->title ?? null,
                'message' => Auth::guard('web')->user()->name . ' joined ' . $this->shareSafari->title . ' shared safari successfully.',
                'safari_url' => route('shared-safari.detail', ['slug' => $this->shareSafari->slug])
            ],
            'chat'
        );

        $this->dispatch('swal:toast', [
            'type' => 'success',
            'message' => 'Comment added successfully!',
        ]);
    }

    public function joinsafari($id)
    {

        $safari = ShareSafari::find($id);

        if (!empty($safari)) {
            $sharedSafari = JoinSharedSafari::firstOrCreate([
                'user_id'        => Auth::guard('web')->id(),
                'share_safari_id' => $safari->id,
            ]);

            $conversation = SafariConversation::where('share_safari_id', $safari->id)
                ->where(function ($q) use ($safari) {
                    $q->where('creator_id', $safari->organized_by)
                        ->where('participant_id', Auth::guard('web')->id());
                })
                ->first();

            if (!$conversation) {
                $conversation = SafariConversation::create([
                    'share_safari_id'  => $safari->id,
                    'creator_id'       => $safari->organized_by,
                    'creator_type'     => ($safari->organized_type == 'admin') ? 'App\Models\Admin' : 'App\Models\User',
                    'participant_id'   => Auth::guard('web')->id(),
                    'participant_type' => get_class(Auth::guard('web')->user()),
                    'organized_type'   => $safari->organized_type,
                ]);
            }


            $sender_type = ($safari->organized_type == 'admin') ? 'App\Models\Admin' : 'App\Models\User';
            createNotification(
                1,
                $safari->organized_by,
                $sender_type,
                Auth::guard('web')->id(),
                get_class(Auth::guard('web')->user()),
                [
                    'user_name' => Auth::guard('web')->user()->name,
                    'safari_id' => $safari->id,
                    'safari_name' => $safari->title ?? null,
                    'message' => Auth::guard('web')->user()->name . ' joined ' . $safari->title . ' shared safari successfully.',
                    'safari_url' => route('shared-safari.detail', ['slug' => $this->shareSafari->slug])
                ]
            );

            $this->dispatch('swal:toast', [
                'type' => 'success',
                'title' => '',
                'message' => "Your join request has been sent to the host. Feel free to connect using the Personal Chat option below.",
            ]);

            $this->userListCount();
            $this->loadJoinSharedSafari();
        } else {
            $this->dispatch('swal:toast', [
                'type' => 'error',
                'title' => '',
                'message' => "Something went wrong",
            ]);
        }
    }

    public function confirmdeletejoinsafari($id)
    {
        $this->leavesharedSafariId = $id;
        $this->dispatch('swal:confirm', [
            'title' => 'Are you sure?',
            'text' => 'You Want to Leave this shared safari',
            'icon' => 'warning',
            'showCancelButton' => true,
            'confirmButtonText' => 'Yes, Leave it!',
            'cancelButtonText' => 'Cancel',
            'action' => 'deletejoinsafari'
        ]);
    }

    #[On('deletejoinsafari')]
    public function deletejoinsafari()
    {
        $join_safari = JoinSharedSafari::find($this->leavesharedSafariId);
        if (!empty($join_safari)) {
            $join_safari->delete();
            $this->showChatBox = false;

            $sender_type = ($this->shareSafari->organized_type == 'admin') ? 'App\Models\Admin' : 'App\Models\User';
            createNotification(
                2,
                $this->shareSafari->organized_by,
                $sender_type,
                Auth::guard('web')->id(),
                get_class(Auth::guard('web')->user()),
                [
                    'user_name' => Auth::guard('web')->user()->name,
                    'safari_id' => $this->shareSafari->id,
                    'safari_name' => $this->shareSafari->title ?? null,
                    'message' => Auth::guard('web')->user()->name . ' Left ' . $this->shareSafari->title . ' shared safari.',
                    'safari_url' => route('shared-safari.detail', ['slug' => $this->shareSafari->slug])
                ]
            );

            $this->dispatch('swal:toast', [
                'type' => 'success',
                'title' => '',
                'message' => "Leave Shared Safari  Successfully",
            ]);
        } else {
            return $this->dispatch('swal:toast', [
                'type' => 'error',
                'title' => '',
                'message' => "Something went wrong",
            ]);
        }
        $this->leavesharedSafariId = "";
        $this->loadJoinSharedSafari();
        $this->userListCount();
    }

    public function showUserLists()
    {
        $this->showUsersList = true;
        $this->allottedSetsUser();
    }

    public function closeUserLists()
    {
        $this->showUsersList = false;
        $this->allotSlot = false;
        $this->dispatch('resetSocialMediaCount');
    }


    public function userListCount()
    {
        $this->userCountList = JoinSharedSafari::with('user')->where('share_safari_id', $this->shareSafari->id)->get();
    }

    public function ShowChatBox()
    {
        $this->showChatBox = true;
    }

    public function loadJoinSharedSafari()
    {
        $this->joinededSafariSafri = JoinSharedSafari::where('user_id', Auth::guard('web')->id())
            ->where('share_safari_id', $this->shareSafari->id)->first();
        if (!Auth::guard('web')->check()) {
            $this->conversation = null;
            return;
        }
        $this->conversation = SafariConversation::where('share_safari_id', $this->shareSafari->id)
            ->where('participant_id', Auth::guard('web')->id())->first();
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
<<<<<<< HEAD
            // Mail::to($user->email)->queue(new DynamicMail($parsed['subject'], $parsed['body']));
             dispatch(function () use ($user, $parsed) {
                Mail::to($user->email)->send(
                    new DynamicMail($parsed['subject'], $parsed['body'])
                );
            })->afterResponse();
=======
            Mail::to($user->email)->queue(new DynamicMail($parsed['subject'], $parsed['body']));
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b

            $type = ($this->shareSafari->organized_type == 'admin') ? 'App\Models\Admin' : 'App\Models\User';
            createNotification(
                6,
                $user->id,
                get_class($user),
                $this->shareSafari->organized_by,
                $type,
                [
                    'user_name' => Auth::guard('web')->user()->name,
                    'safari_id' => $this->shareSafari->id,
                    'safari_name' => $this->shareSafari->title ?? null,
                    'message' => Auth::guard('web')->user()->name . ' Left ' . $this->shareSafari->title . ' shared safari.',
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
                "email_subject" => "Your Safari " . $this->shareSafari->title . " Seat Has Been Allotted",
                'name' => $user->name,
                "message_body" => "Good news! Your seat for the Shared Safari has been successfully allotted. Please check the details below.",
                "safaris" => $this->shareSafari->title,
                "start_date" => $this->shareSafari->day,
                "end_date" => $this->shareSafari->night,
                "seat_count" => $this->seat_number,
                'year' => date('Y'),
            ];
            $parsed = UserHelper::parseTemplate('SEATALLOTED', $data);
<<<<<<< HEAD
            // Mail::to($user->email)->queue(new DynamicMail($parsed['subject'], $parsed['body']));
            dispatch(function () use ($user, $parsed) {
                Mail::to($user->email)->send(
                    new DynamicMail($parsed['subject'], $parsed['body'])
                );
            })->afterResponse();
=======
            Mail::to($user->email)->queue(new DynamicMail($parsed['subject'], $parsed['body']));
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b

            $type = ($this->shareSafari->organized_type == 'admin') ? 'App\Models\Admin' : 'App\Models\User';
            createNotification(
                7,
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
<<<<<<< HEAD
            // Mail::to($user->email)->queue(new DynamicMail($parsed['subject'], $parsed['body']));
            dispatch(function () use ($user, $parsed) {
                Mail::to($user->email)->send(
                    new DynamicMail($parsed['subject'], $parsed['body'])
                );
            })->afterResponse();
=======
            Mail::to($user->email)->queue(new DynamicMail($parsed['subject'], $parsed['body']));
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
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
<<<<<<< HEAD
        // Mail::to($checkUser->allottedUser->email)->queue(
        //     new DynamicMail($parsed['subject'], $parsed['body'])
        // );
        dispatch(function () use ($checkUser, $parsed) {
            Mail::to($checkUser->allottedUser->email)->send(
                new DynamicMail($parsed['subject'], $parsed['body'])
            );
        })->afterResponse();
=======
        Mail::to($checkUser->allottedUser->email)->queue(
            new DynamicMail($parsed['subject'], $parsed['body'])
        );
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b

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
<<<<<<< HEAD
                // Mail::to($user->email)->queue(new DynamicMail($parsed['subject'], $parsed['body']));
                dispatch(function () use ($user, $parsed) {
                    Mail::to($user->email)->send(
                        new DynamicMail($parsed['subject'], $parsed['body'])
                    );
                })->afterResponse();
=======
                Mail::to($user->email)->queue(new DynamicMail($parsed['subject'], $parsed['body']));
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
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
                'user_name' => Auth::guard('web')->user()->name,
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

    public function addwishlist($id)
    {
        $checkWishlist = Wishlist::where('shared_safari_id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if ($checkWishlist) {
            $checkWishlist->delete();

            createNotification(
                3,
                1,
                'App\Models\Admin',
                Auth::guard('web')->id(),
                get_class(Auth::guard('web')->user()),
                [
                    'user_name' => Auth::guard('web')->user()->name,
                    'safari_id' => $this->shareSafari->id,
                    'safari_name' => $this->shareSafari->title ?? null,
                    'message' => Auth::guard('web')->user()->name . ' Left ' . $this->shareSafari->title . ' Wishlist.',
                    'safari_url' => route('shared-safari.detail', ['slug' => $this->shareSafari->slug])
                ],
                'system'
            );

            $this->wishlistTitle = "Add Wishlist";
            return $this->dispatch('swal:toast', [
                'type' => 'success',
                'title' => '',
                'message' => "Item Removed from Wishlist",
            ]);
        } else {
            Wishlist::create([
                'user_id' => Auth::id(),
                'shared_safari_id' => $id,
            ]);

            createNotification(
                4,
                1,
                'App\Models\Admin',
                Auth::guard('web')->id(),
                get_class(Auth::guard('web')->user()),
                [
                    'user_name' => Auth::guard('web')->user()->name,
                    'safari_id' => $this->shareSafari->id,
                    'safari_name' => $this->shareSafari->title ?? null,
                    'message' => Auth::guard('web')->user()->name . ' added ' . $this->shareSafari->title . ' Wishlist.',
                    'safari_url' => route('shared-safari.detail', ['slug' => $this->shareSafari->slug])
                ],
                'system'
            );

            $this->wishlistTitle = "Remove Wishlist";
            return $this->dispatch('swal:toast', [
                'type' => 'success',
                'title' => '',
                'message' => "Item Added to Wishlist",
            ]);
        }
    }

    public function discussionReport($discussionId)
    {
        $this->reportDiscussionId = $discussionId;
        $this->reportResions = ReportResion::where('status', '1')->get();
        $this->selectedResion = null;
        $this->notes = '';
        $this->showReportModal = true;
    }

    public function submitReport()
    {
        $this->validate([
            'selectedResion' => 'required|exists:report_resions,report_resion_id',
            'notes' => 'nullable|string|max:500',
        ]);
        $discussion =  SafariDiscussion::where('safari_discussion_id', $this->reportDiscussionId)->first();
        Report::create([
            'user_id' => Auth::id(),
            'report_type' => 'comment',
            'comment_id' => $this->reportDiscussionId,
            'comment' => $discussion->content,
            'share_safari_id' =>  $this->shareSafari->id,
            'report_resion_id' => $this->selectedResion,
            'details' => $this->notes,
        ]);

        $this->reset(['showReportModal', 'selectedResion', 'notes', 'reportDiscussionId']);
        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => '',
            'message' => 'Report submitted successfully!',
        ]);
    }
}
