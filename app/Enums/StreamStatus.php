<?php

namespace App\Enums;

enum StreamStatus: string
{
    case Live = 'live';
    case Past = 'past';

    public function label(): string
    {
        return match ($this) {
            self::Live => 'Live',
            self::Past => 'Past',
        };
    }
}
