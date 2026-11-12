<?php

namespace App\Livewire;

use App\Models\PrayerRequest;
use App\Models\User;
use App\Notifications\NewPrayerRequest;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

class PrayerRequestForm extends Component
{
    #[Validate(['nullable', 'string', 'max:255'])]
    public string $name = '';

    #[Validate(['nullable', 'email', 'max:255'])]
    public string $email = '';

    #[Validate(['required', 'string', 'max:5000'])]
    public string $message = '';

    public function submit(): void
    {
        $this->validate();

        $prayerRequest = PrayerRequest::create([
            'name' => filled($this->name) ? $this->name : null,
            'email' => filled($this->email) ? $this->email : null,
            'message' => $this->message,
        ]);

        Notification::send(
            User::query()->where('receives_prayer_emails', true)->get(),
            new NewPrayerRequest($prayerRequest),
        );

        $this->reset('name', 'email', 'message');

        session()->flash('prayer_request_submitted', true);
    }

    public function render(): View
    {
        return view('livewire.prayer-request-form');
    }
}
