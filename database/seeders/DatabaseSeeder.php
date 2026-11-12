<?php

namespace Database\Seeders;

use App\Enums\EventCategory;
use App\Models\Announcement;
use App\Models\ContactMessage;
use App\Models\Event;
use App\Models\PaymentType;
use App\Models\PrayerRequest;
use App\Models\Stream;
use App\Models\StreamComment;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $superAdminRole = Role::findOrCreate(config('filament-shield.super_admin.name'));

        $superAdmin = User::updateOrCreate(
            ['email' => 'admin@firstchurch.test'],
            [
                'name' => 'Senior Pastor',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'receives_prayer_emails' => true,
            ],
        );
        $superAdmin->assignRole($superAdminRole);

        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'receives_prayer_emails' => false,
            ],
        );

        Announcement::factory()->count(3)->create();
        Announcement::factory()->scheduled()->create();

        Event::factory()->count(4)->create();
        Event::factory()->past()->create();
        Event::factory()->category(EventCategory::CommunityOutreach)->create();
        Event::factory()->category(EventCategory::Mission)->create();

        $liveStream = Stream::factory()->create([
            'title' => 'Sunday Worship Service',
        ]);
        StreamComment::factory()->count(2)->create(['stream_id' => $liveStream->id]);
        StreamComment::factory()->unapproved()->create(['stream_id' => $liveStream->id]);

        Stream::factory()->past()->count(2)->create();

        PrayerRequest::factory()->count(3)->create();
        PrayerRequest::factory()->prayedFor()->create();

        ContactMessage::factory()->count(2)->create();

        foreach (['Tithe', 'Offertory', 'Seed', 'Building Fund'] as $order => $name) {
            PaymentType::updateOrCreate(['name' => $name], ['sort_order' => $order, 'is_active' => true]);
        }
    }
}
