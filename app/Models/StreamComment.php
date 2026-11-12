<?php

namespace App\Models;

use Database\Factories\StreamCommentFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $stream_id
 * @property string|null $name
 * @property string $message
 * @property bool $is_approved
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['stream_id', 'name', 'message', 'is_approved'])]
class StreamComment extends Model
{
    /** @use HasFactory<StreamCommentFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'is_approved' => 'boolean',
        ];
    }

    /**
     * @return BelongsTo<Stream, $this>
     */
    public function stream(): BelongsTo
    {
        return $this->belongsTo(Stream::class);
    }

    /**
     * Scope the query to approved comments only.
     *
     * @param  Builder<StreamComment>  $query
     * @return Builder<StreamComment>
     */
    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('is_approved', true);
    }
}
