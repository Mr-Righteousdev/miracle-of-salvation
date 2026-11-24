<?php

namespace App\Models;

use Database\Factories\LeaderFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string $role
 * @property string|null $photo
 * @property string|null $bio
 * @property int $sort_order
 * @property Carbon|null $published_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['name', 'role', 'photo', 'bio', 'sort_order', 'published_at'])]
class Leader extends Model
{
    /** @use HasFactory<LeaderFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'published_at' => 'datetime',
        ];
    }

    /**
     * Scope the query to published leaders in display order.
     *
     * @param  Builder<Leader>  $query
     * @return Builder<Leader>
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
