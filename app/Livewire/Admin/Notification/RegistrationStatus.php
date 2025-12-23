<?php

namespace App\Livewire\Admin\Notification;

use App\Models\NotificationTemplate;
use Livewire\Component;

class RegistrationStatus extends Component
{
    public $activeTamp, $template, $body, $subject, $placeholders;

    public function mount($activeTamp)
    {
        $this->activeTamp = $activeTamp;
        $this->template = NotificationTemplate::where('template_code', $activeTamp)->first();
        $this->body = $this->template->body;
        $this->subject = $this->template->subject;
        $this->placeholders = json_decode($this->template->short_codes, true) ?? [];
    }

    public function render()
    {
        return view('livewire.admin.notification.registration-status');

    }



    public function store()
    {
        $this->validate([
            'subject' => 'required',
            'body' => 'required',
        ]);

        NotificationTemplate::where('template_code', $this->activeTamp)->update([
            'subject' =>  $this->subject,
            'body' =>  $this->body,
        ]);

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Notification Update Successfully']);
    }
}
