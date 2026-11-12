<?php

namespace App\Notifications;

use App\Filament\Resources\ContactMessages\ContactMessageResource;
use App\Models\ContactMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewContactMessage extends Notification
{
    /**
     * Create a new notification instance.
     */
    public function __construct(public ContactMessage $contactMessage) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New contact message: '.$this->contactMessage->subject)
            ->replyTo($this->contactMessage->email, $this->contactMessage->name)
            ->greeting('A new message was sent from the contact page')
            ->line('From: '.$this->contactMessage->name.' ('.$this->contactMessage->email.')')
            ->line('Subject: '.$this->contactMessage->subject)
            ->line('"'.$this->contactMessage->message.'"')
            ->action('View contact messages', ContactMessageResource::getUrl());
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'contact_message_id' => $this->contactMessage->id,
            'name' => $this->contactMessage->name,
            'subject' => $this->contactMessage->subject,
        ];
    }
}
