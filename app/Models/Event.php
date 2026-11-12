<?php

namespace App\Models;

use App\Enums\EventCategory;
use Database\Factories\EventFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $title
 * @property string $description
 * @property Carbon $starts_at
 * @property string|null $location
 * @property EventCategory $category
 * @property string|null $image
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['title', 'description', 'starts_at', 'location', 'category', 'image'])]
class Event extends Model
{
    /** @use HasFactory<EventFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'category' => EventCategory::class,
        ];
    }

    /**
     * Scope the query to upcoming events, oldest first.
     *
     * @param  Builder<Event>  $query
     * @return Builder<Event>
     */
    public function scopeUpcoming(Builder $query): Builder
    {
        return $query
            ->where('starts_at', '>=', now())
            ->orderBy('starts_at');
    }

    /**
     * Scope the query to events in the given category.
     *
     * @param  Builder<Event>  $query
     * @return Builder<Event>
     */
    public function scopeInCategory(Builder $query, EventCategory $category): Builder
    {
        return $query->where('category', $category);
    }

    /**
     * Scope the query to past events, newest first.
     *
     * @param  Builder<Event>  $query
     * @return Builder<Event>
     */
    public function scopePast(Builder $query): Builder
    {
        return $query
            ->where('starts_at', '<', now())
            ->orderBy('starts_at', 'desc');
    }

    /**
     * Build a Google Calendar "add to calendar" link with this event pre-filled.
     */
    public function googleCalendarUrl(): string
    {
        $start = $this->starts_at->utc()->format('Ymd\THis\Z');
        $end = $this->starts_at->copy()->addHours(2)->utc()->format('Ymd\THis\Z');

        return 'https://calendar.google.com/calendar/render?'.http_build_query([
            'action' => 'TEMPLATE',
            'text' => $this->title,
            'dates' => "{$start}/{$end}",
            'details' => $this->description,
            'location' => $this->location ?? '',
        ]);
    }

    /**
     * Build a mailto link pre-filled with a reminder for this event.
     */
    public function reminderUrl(): string
    {
        $formatted = $this->starts_at->format('l, F j, Y \a\t g:i A');

        return 'mailto:?'.http_build_query([
            'subject' => "Reminder: {$this->title}",
            'body' => "{$this->title}\n\n{$formatted}\n".($this->location ? "{$this->location}\n" : '')."\n{$this->description}",
        ]);
    }
}
