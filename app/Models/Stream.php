<?php

namespace App\Models;

use App\Enums\StreamStatus;
use Database\Factories\StreamFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $title
 * @property string $youtube_url
 * @property string $video_id
 * @property Carbon|null $starts_at
 * @property StreamStatus $status
 * @property bool $comments_enabled
 * @property bool $comments_visible
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['title', 'youtube_url', 'video_id', 'starts_at', 'status', 'comments_enabled', 'comments_visible'])]
class Stream extends Model
{
    /** @use HasFactory<StreamFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'status' => StreamStatus::class,
            'comments_enabled' => 'boolean',
            'comments_visible' => 'boolean',
        ];
    }

    /**
     * @return HasMany<StreamLike, $this>
     */
    public function likes(): HasMany
    {
        return $this->hasMany(StreamLike::class);
    }

    /**
     * @return HasMany<StreamComment, $this>
     */
    public function comments(): HasMany
    {
        return $this->hasMany(StreamComment::class);
    }

    /**
     * Extract the YouTube video ID from a URL of any supported format.
     */
    public static function extractVideoId(string $url): ?string
    {
        $patterns = [
            '~^https?://(?:www\.)?youtube\.com/watch\?[^#]*\bv=([A-Za-z0-9_-]{11})~',
            '~^https?://(?:www\.)?youtu\.be/([A-Za-z0-9_-]{11})~',
            '~^https?://(?:www\.)?youtube\.com/(?:embed|live)/([A-Za-z0-9_-]{11})~',
            '~^https?://(?:www\.)?youtube\.com/shorts/([A-Za-z0-9_-]{11})~',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches) === 1) {
                return $matches[1];
            }
        }

        return null;
    }

    /**
     * URL used to embed the stream in an iframe.
     */
    public function embedUrl(): string
    {
        return 'https://www.youtube.com/embed/'.$this->video_id;
    }

    /**
     * URL of the thumbnail for the stream's video.
     */
    public function thumbnailUrl(): string
    {
        return 'https://img.youtube.com/vi/'.$this->video_id.'/mqdefault.jpg';
    }

    /**
     * Scope the query to live streams.
     *
     * @param  Builder<Stream>  $query
     * @return Builder<Stream>
     */
    public function scopeLive(Builder $query): Builder
    {
        return $query->where('status', StreamStatus::Live);
    }

    /**
     * Scope the query to past streams, newest first.
     *
     * @param  Builder<Stream>  $query
     * @return Builder<Stream>
     */
    public function scopePast(Builder $query): Builder
    {
        return $query->where('status', StreamStatus::Past)->orderBy('starts_at', 'desc');
    }

    /**
     * Return the stream to feature on the public page: the latest live stream
     * if one exists, otherwise the most recent past stream.
     */
    public static function current(): ?self
    {
        return static::live()
            ->latest('starts_at')
            ->first() ?? static::past()->first();
    }
}
