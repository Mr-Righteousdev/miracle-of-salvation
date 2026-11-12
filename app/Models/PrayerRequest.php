<?php

namespace App\Models;

use Database\Factories\PrayerRequestFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string|null $name
 * @property string|null $email
 * @property string $message
 * @property bool $is_prayed_for
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['name', 'email', 'message', 'is_prayed_for'])]
class PrayerRequest extends Model
{
    /** @use HasFactory<PrayerRequestFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'is_prayed_for' => 'boolean',
        ];
    }
}
