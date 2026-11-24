<?php

namespace App\Models;

use Database\Factories\VideoFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * A YouTube video for the Videos page (ministry, branch and outreach clips — not sermons).
 *
 * @property int $id
 * @property string $title
 * @property string $youtube_url
 * @property string $video_id
 * @property string|null $description
 * @property Carbon|null $published_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['title', 'youtube_url', 'description', 'published_at'])]
class Video extends Model
{
    /** @use HasFactory<VideoFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Video $video): void {
            $video->video_id = (string) Stream::extractVideoId($video->youtube_url);
        });
    }

    /**
     * Scope the query to published videos, newest first.
     *
     * @param  Builder<Video>  $query
     * @return Builder<Video>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->latest('published_at');
    }

    public function thumbnailUrl(): string
    {
        return 'https://img.youtube.com/vi/'.$this->video_id.'/mqdefault.jpg';
    }
}
