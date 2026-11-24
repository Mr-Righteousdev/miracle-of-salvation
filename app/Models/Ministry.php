<?php

namespace App\Models;

use Database\Factories\MinistryFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $summary
 * @property string|null $description
 * @property string|null $leader
 * @property string|null $meeting_time
 * @property string|null $image
 * @property int $sort_order
 * @property Carbon|null $published_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['name', 'slug', 'summary', 'description', 'leader', 'meeting_time', 'image', 'sort_order', 'published_at'])]
class Ministry extends Model
{
    /** @use HasFactory<MinistryFactory> */
    use HasFactory;

    /**
     * Slugs taken by fixed pages under /ministries.
     *
     * @var list<string>
     */
    public const array RESERVED_SLUGS = ['gallery'];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'published_at' => 'datetime',
        ];
    }

    /**
     * Scope the query to published ministries in display order.
     *
     * @param  Builder<Ministry>  $query
     * @return Builder<Ministry>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('sort_order')
            ->orderBy('name');
    }
}
