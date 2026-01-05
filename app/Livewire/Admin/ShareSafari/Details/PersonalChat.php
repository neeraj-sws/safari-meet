<?php

namespace App\Livewire\Admin\ShareSafari\Details;

use App\Models\ShareSafari;
use Illuminate\Support\Facades\Auth;
use App\Models\{Admin, SafariConversation, SafariConversationMessage, User};
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.admin-app')]
class PersonalChat extends Component
{
    public $characterDetails, $sharedsafari;
    public $conversationId = null;
    public $chatConversationMessage;
    public $chatContent;
    public $shareSafari;
    public $selectedUser = null;
    public $safariConversations, $creator, $participant, $admin = false, $guard,$currentAuth,$pageTitle ="Persnal Chat";


    public function mount($uuid)
    {
        $this->shareSafari = ShareSafari::with(['park'])->where('uuid', $uuid)->first();
        $this->creator = true;  // true/false/null
        $this->currentAuth = Auth::guard('admin')->user();
        $this->loadConversations();
        $this->chatConversationMessage = collect();
    }

    public function render()
    {
        if ($this->conversationId) {
            $this->loadChatMessage();
        }
        return view('livewire.admin.share-safari.details.personal-chat');
    }

    /**
     * Load all conversations for the logged-in user
     */
    private function loadConversations()
    {
        if ($this->creator) {

            $this->safariConversations = collect(
                SafariConversation::where('creator_id', Auth::guard('admin')->user()->id)
                    ->where('share_safari_id', $this->shareSafari->id)
                    ->with(['messages' => function ($q) {
                        $q->latest();
                    }, 'creator', 'participant'])
                    ->get()
            );
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
        $this->selectedUser = User::find($userId);

        $conversation = SafariConversation::where(function ($q) use ($userId) {
            $q->where('creator_id', $this->currentAuth->id)
                ->where('participant_id', $userId);
        })->where('share_safari_id', $this->shareSafari->id)->first();

        if (!$conversation) {
            $conversation = SafariConversation::create([
                'creator_id' => $this->currentAuth->id,
                'creator_type' => get_class(Auth::guard('admin')->user()),
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


        $receiverId = $conversation->creator_id === $this->currentAuth->id
            ? $conversation->participant_id
            : $conversation->creator_id;

        $receiverType = $conversation->creator_id === $this->currentAuth->id
            ? $conversation->participant_type
            : $conversation->creator_type;

        SafariConversationMessage::create([
            'safari_conversation_id' => $conversation->id,
            'sender_id'              => $this->currentAuth->id,
            'sender_type'            => get_class($this->currentAuth),
            'receiver_id'            => $receiverId,
            'receiver_type'          => $receiverType,
            'message'                => $this->chatContent,
        ]);

        // broadcast
        // event(new MessageSent($message));

        $this->reset('chatContent');
        $this->loadChatMessage();
        $this->loadConversations();
    }
}
