<?php

namespace App\Livewire\Front;

use App\Models\ContactUsForm;
use App\Models\Park;
use App\Models\ParkSafariType;
use App\Rules\ValidPhoneNumber;
use App\Models\SafariType;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.guest')]
class ContactUs extends Component
{
    public $name, $email, $phone, $people_traveling, $travel_date, $park, $safari_type, $message;
    public $parks = [], $safariTypes = [];

    public function mount()
    {
        $this->parks = Park::where('status', 1)->orderBy('name')->get();
    }

    protected function rules()
    {
        return [
            'name'             => 'required|string|min:3',
            'email'            => 'required|email:rfc,dns',
            'phone' => ['required',  'numeric',  'digits:10', new ValidPhoneNumber(),],
            'people_traveling' => 'required|integer|min:1',
            'travel_date' => 'required|date_format:Y-m-d|after_or_equal:today',
            'park'             => 'required',
            'safari_type'      => 'required|string',
            'message'          => 'required|string|min:5',
        ];
    }

    public function render()
    {
        return view('livewire.front.contact-us');
    }

    public function updatedPark()
    {
        $this->safariTypes = ParkSafariType::with('safari_type:safari_type_id,name')
            ->where('park_id', $this->park)->get();
    }

    public function submit()
    {
        $this->validate();
        ContactUsForm::create([
            'name'             => ucwords($this->name),
            'email'            => $this->email,
            'phone'            => $this->phone,
            'people_traveling' => $this->people_traveling,
            'travel_date'      => $this->travel_date,
            'park_id'          => $this->park,
            'safari_type_id'   => $this->safari_type,
            'message'          => $this->message,
        ]);

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Your quote request has been submitted!']);
        
        $this->reset([
        'name',
        'email',
        'phone',
        'people_traveling',
        'travel_date',
        'park',
        'safari_type',
        'message',
        'safariTypes',
    ]);

    }
}
