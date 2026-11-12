<?php

namespace App\Notifications;

use App\Filament\Resources\PrayerRequests\PrayerRequestResource;
use App\Models\PrayerRequest;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewPrayerRequest extends Notification
{
    /**
     * Create a new notification instance.
     */
    public function __construct(public PrayerRequest $prayerRequest) {}

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
            ->subject('New prayer request')
            ->greeting('A new prayer request has been submitted')
            ->line('"'.$this->prayerRequest->message.'"')
            ->when($this->prayerRequest->name, fn (MailMessage $mail): MailMessage => $mail->line('From: '.$this->prayerRequest->name))
            ->when($this->prayerRequest->email, fn (MailMessage $mail): MailMessage => $mail->line('Reply: '.$this->prayerRequest->email))
            ->action('View prayer requests', PrayerRequestResource::getUrl())
            ->line('Please pray over this request at your next opportunity.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'prayer_request_id' => $this->prayerRequest->id,
            'name' => $this->prayerRequest->name,
            'message' => $this->prayerRequest->message,
        ];
    }
}
