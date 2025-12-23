<?php

namespace App\Livewire\Admin\Notification;

use App\Models\NotificationTemplate;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Str;

#[Layout('components.layouts.admin-app')]
class Templates extends Component
{
    public $pageTitle = "Templates";
    public $activeTamp = "ENQUIRY", $body, $subject, $notificationTemplates = [], $template, $placeholders = [];

    public function mount()
    {
        $this->notificationTemplates = NotificationTemplate::where('status', 1)->get();
        $this->template = $this->notificationTemplates->first();

        $activeTabName = request()->query('tab');

        if (!empty($activeTabName)) {
            $matchedTemplate = $this->notificationTemplates->first(function ($item) use ($activeTabName) {
                return Str::slug($item->name, '_') === $activeTabName;
            });
            $this->activeTamp = $matchedTemplate->template_code ?? $this->template->template_code;
        } else {
            $this->activeTamp = $this->template->template_code;
        }
    }
    public function render()
    {
        return view('livewire.admin.notification.templates');
    }

    public function toggleStatus($tmp)
    {
        $this->template = $this->notificationTemplates->where('template_code', $tmp)->first();
        if ($this->template) {
            $this->activeTamp =  $this->template->template_code;
        } else {
            $this->dispatch('swal:toast', ['type' => 'error', 'title' => '', 'message' => 'somthing went to wrong !']);
        }
    }
}
