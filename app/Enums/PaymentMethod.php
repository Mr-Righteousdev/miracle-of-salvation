<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case MtnMobileMoney = 'mtn';
    case AirtelMoney = 'airtel';
    case Bank = 'bank';

    public function label(): string
    {
        return match ($this) {
            self::MtnMobileMoney => 'MTN Mobile Money',
            self::AirtelMoney => 'Airtel Money',
            self::Bank => 'Bank',
        };
    }

    /**
     * @return array<string, string>
     */
    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $case): array => [$case->value => $case->label()])
            ->all();
    }
}
