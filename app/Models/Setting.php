<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Once;

/**
 * Admin-editable site details (contact info, social links, giving instructions).
 *
 * @property int $id
 * @property string $key
 * @property string|null $value
 */
#[Fillable(['key', 'value'])]
class Setting extends Model
{
    /**
     * Defaults shown until an admin saves the settings page.
     *
     * @var array<string, string|null>
     */
    public const array DEFAULTS = [
        'church_name' => 'Miracle of Salvation Church',
        'address' => 'P.O. Box 30501, Kampala, Uganda',
        'phone' => null,
        'email' => null,
        'whatsapp' => null,
        'service_times' => null,
        'facebook_url' => null,
        'youtube_url' => null,
        'instagram_url' => null,
        'giving_instructions' => null,
    ];

    /**
     * All settings merged over the defaults, loaded once per request.
     *
     * @return array<string, string|null>
     */
    public static function values(): array
    {
        return once(fn (): array => array_merge(
            self::DEFAULTS,
            static::query()->pluck('value', 'key')->all(),
        ));
    }

    public static function get(string $key): ?string
    {
        return self::values()[$key] ?? null;
    }

    /**
     * @param  array<string, string|null>  $values
     */
    public static function saveMany(array $values): void
    {
        foreach (array_intersect_key($values, self::DEFAULTS) as $key => $value) {
            static::query()->updateOrCreate(['key' => $key], ['value' => $value]);
        }

        Once::flush();
    }
}
