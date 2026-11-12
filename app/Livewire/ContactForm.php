<?php

namespace App\Livewire;

use App\Models\ContactMessage;
use App\Models\User;
use App\Notifications\NewContactMessage;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ContactForm extends Component
{
    #[Validate(['required', 'string', 'max:255'])]
    public string $name = '';

    #[Validate(['required', 'email', 'max:255'])]
    public string $email = '';

    #[Validate(['required', 'string', 'max:255'])]
    public string $subject = '';

    #[Validate(['required', 'string', 'max:5000'])]
    public string $message = '';

    public function submit(): void
    {
        $this->validate();

        $contactMessage = ContactMessage::create([
            'name' => $this->name,
            'email' => $this->email,
            'subject' => $this->subject,
            'message' => $this->message,
        ]);

        Notification::send(
            User::query()->where('receives_prayer_emails', true)->get(),
            new NewContactMessage($contactMessage),
        );

        $this->reset('name', 'email', 'subject', 'message');

        session()->flash('contact_message_sent', true);
    }

    public function render(): View
    {
        return view('livewire.contact-form');
    }
}
