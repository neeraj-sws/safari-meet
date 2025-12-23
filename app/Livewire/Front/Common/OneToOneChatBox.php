<?php

namespace App\Livewire\Front\Common;

use App\Models\SafariConversation;
use App\Models\SafariConversationMessage;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class OneToOneChatBox extends Component
{
    public $shareSafari;
    public $conversation, $showChatBox = false, $chatConversationMessage = [], $chatContent;

    public function mount($shared)
    {
        $this->shareSafari = $shared;
    }
    public function render()
    {
        $this->loadConversation();
        return view('livewire.front.common.one-to-one-chat-box');
    }

    private function loadConversation()
    {
        if (!Auth::guard('web')->check()) {
            $this->conversation = null;
            $this->chatConversationMessage = collect();
            return;
        }

        $user = Auth::guard('web')->user();

        $this->conversation = SafariConversation::where('share_safari_id', $this->shareSafari->id)
            ->where('participant_id', $user->id)
            ->where('creator_id', $this->shareSafari->organized_by)
            ->first();

        $this->loadChatMessage();
    }

    private function loadChatMessage()
    {
        if (!$this->conversation) {
            $this->chatConversationMessage = collect();
            return;
        }

        $this->chatConversationMessage = SafariConversationMessage::where('safari_conversation_id', $this->conversation->id)
            ->with('sender')
            ->latest()
            ->take(20)
            ->get()
            ->reverse();
    }

    public function saveChate()
    {

        $this->validate([
            'chatContent' => 'required|string|max:500',
        ]);

        SafariConversationMessage::create([
            'safari_conversation_id' => $this->conversation?->id,
            'sender_id' => Auth::guard('web')->id(),
            'receiver_id' => $this->shareSafari->organized_by,
            'message' => $this->chatContent,
        ]);

        $this->reset('chatContent');

    }
}
