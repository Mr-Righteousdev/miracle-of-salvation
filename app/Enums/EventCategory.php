<?php

namespace App\Enums;

enum EventCategory: string
{
    case ChurchProgram = 'church_program';
    case CommunityOutreach = 'community_outreach';
    case Mission = 'mission';

    public function label(): string
    {
        return match ($this) {
            self::ChurchProgram => 'Church program',
            self::CommunityOutreach => 'Community outreach',
            self::Mission => 'Missions',
        };
    }

    /**
     * Name of the public route that lists events in this category.
     */
    public function routeName(): string
    {
        return match ($this) {
            self::ChurchProgram => 'events.church-programs',
            self::CommunityOutreach => 'events.community-outreach',
            self::Mission => 'events.missions',
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
