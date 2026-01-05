<?php

namespace App\Livewire\Front\Common;

use App\Events\MessageSent;
use App\Models\{Admin, SafariConversation, SafariConversationMessage, User};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class ChatBox extends Component
{
    public $conversationId = null;
    public $chatConversationMessage;
    public $chatContent;
    public $shareSafari;
    public $selectedUser = null;
    public $safariConversations, $creator, $participant, $admin = false, $guard;

    public function mount($shared, $creator = null, $participant = null, $admin = false)
    {
        $this->shareSafari = $shared;
        $this->creator = $creator;  // true/false/null
        $this->participant = $participant; // null/conversationid
        $this->admin = $admin;
        $this->loadConversations();
        $this->chatConversationMessage = collect();
    }

    public function render()
    {
        if ($this->conversationId) {
            $this->loadChatMessage();
        }
        return view('livewire.front.common.chat-box');
    }

    /**
     * Load all conversations for the logged-in user
     */
    private function loadConversations()
    {
        if ($this->creator) {
            $this->safariConversations = collect(
                SafariConversation::where('creator_id', Auth::guard('web')->user()->id)
                    ->where('share_safari_id', $this->shareSafari->id)
                    ->with(['messages' => function ($q) {
                        $q->latest();
                    }, 'creator', 'participant'])
                    ->get()
            );
        } elseif ($this->participant && empty($this->creator)) {
            $this->safariConversations = collect(
                SafariConversation::where('participant_id', Auth::guard('web')->user()->id)
                    ->where('share_safari_id', $this->shareSafari->id)
                    ->with(['messages' => function ($q) {
                        $q->latest();
                    }, 'creator', 'participant'])
                    ->get()
            );
            //    dd('participant',$this->safariConversations);
        }
    }

    /**
     * Load messages of current conversation
     */
    private function loadChatMessage()
    {
        if (!$this->conversationId) {
            $this->chatConversationMessage = collect();
            return;
        }

        $this->chatConversationMessage = SafariConversationMessage::with(['sender', 'receiver'])
            ->where('safari_conversation_id', $this->conversationId)
            ->orderBy('created_at')
            ->get();
    }

    /**
     * Select or start a conversation with a user
     */
    public function selectConversation($userId)
    {
        if ($this->shareSafari->organized_type == 'admin') {
            $this->selectedUser = Admin::find($userId);
        } else {
            $this->selectedUser = User::find($userId);
        }

        $conversation = SafariConversation::where('share_safari_id', $this->shareSafari->id)
            ->where(function ($q) use ($userId) {
                $q->where(function ($q2) use ($userId) {
                    $q2->where('creator_id', Auth::id())
                        ->where('participant_id', $userId);
                })->orWhere(function ($q2) use ($userId) {
                    $q2->where('creator_id', $userId)
                        ->where('participant_id', Auth::id());
                });
            })
            ->first();
        if (!$conversation) {
            $conversation = SafariConversation::create([
                'creator_id' => Auth::id(),
                'creator_type' => get_class(Auth::guard('web')->user()),
                'participant_id' => $userId,
                'participant_type' => get_class($this->selectedUser),
                'share_safari_id' => $this->shareSafari->id ?? null,
                'organized_type' => $this->shareSafari->organized_type,
            ]);
        }

        $this->conversationId = $conversation->id;
        $this->loadChatMessage();
        $this->loadConversations(); // refresh sidebar
    }

    /**
     * Send message
     */
    public function saveChate()
    {
        $this->validate([
            'chatContent' => 'required|string|max:500',
        ]);

        if (!$this->conversationId) return;

        $conversation = SafariConversation::find($this->conversationId);
        $authUser = Auth::guard('web')->user();

        $receiverId = ($conversation->creator_id === $authUser->id &&  $conversation->creator_type == get_class($authUser))
            ? $conversation->participant_id
            : $conversation->creator_id;

        $receiverType = ($conversation->creator_id === $authUser->id &&  $conversation->creator_type == get_class($authUser))
            ? $conversation->participant_type
            : $conversation->creator_type;

        SafariConversationMessage::create([
            'safari_conversation_id' => $conversation->id,
            'sender_id'              => $authUser->id,
            'sender_type'            => get_class($authUser),
            'receiver_id'            => $receiverId,
            'receiver_type'          => $receiverType,
            'message'                => $this->chatContent,
        ]);

        // broadcast
        // event(new MessageSent($message));

        createNotification(
            15,
            $receiverId,
            $receiverType,
            $authUser->id,
            get_class($authUser),
            [
                'user_name' => $authUser->name,
                'safari_id' =>  $this->shareSafari->id,
                'safari_name' =>  $this->shareSafari->title ?? null,
                'message' => $authUser->name . ' sent you a message in ' . $this->shareSafari->title . ' shared safari.',
                'safari_url' => route('shared-safari.detail', ['slug' => $this->shareSafari->slug])
            ],
            'chat'
        );

        $this->reset('chatContent');
        $this->loadChatMessage();
        $this->loadConversations();
    }

    #[On('realtimeMessageReceived')]
    public function handleRealtimeMessage($payload)
    {
        $message = $payload['message'];

        $this->chatConversationMessage->push((object) [
            'id' => $message['id'],
            'safari_conversation_id' => $this->conversationId,
            'sender_id' => $message['sender_id'],
            'receiver_id' => $message['receiver_id'],
            'message' => $message['message'],
            'created_at' => \Carbon\Carbon::parse($message['created_at']),
            'sender' => \App\Models\User::find($message['sender_id']),
        ]);
    }
}
