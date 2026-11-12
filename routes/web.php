<?php

use App\Enums\EventCategory;
use App\Models\Announcement;
use App\Models\Event;
use App\Models\GalleryImage;
use App\Models\Stream;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;

Route::view('/', 'site.home')->name('home');

Route::view('/contact', 'site.contact')->name('contact');
Route::view('/give', 'site.give')->name('give');
Route::view('/branches', 'site.branches')->name('branches');

Route::view('/about/vision-bearer', 'site.wip', ['title' => 'Vision Bearer'])->name('about.vision-bearer');
Route::view('/about/church-profile', 'site.wip', ['title' => 'Church Profile'])->name('about.church-profile');
Route::view('/about/leadership', 'site.wip', ['title' => 'Leadership'])->name('about.leadership');

Route::view('/ministries/youth', 'site.wip', ['title' => 'Youth Ministry'])->name('ministries.youth');
Route::view('/ministries/children', 'site.wip', ['title' => "Children's Ministry"])->name('ministries.children');
Route::view('/ministries/fathers-mothers', 'site.wip', ['title' => 'Fathers and Mothers Ministry'])->name('ministries.fathers-mothers');
Route::get('/ministries/gallery', fn () => view('site.gallery', [
    'images' => GalleryImage::published()->paginate(24),
]))->name('ministries.gallery');

Route::get('/livestream/sermons', fn () => view('site.sermons', [
    'streams' => Stream::past()->paginate(12),
]))->name('livestream.sermons');
Route::view('/livestream/videos', 'site.wip', ['title' => 'Videos'])->name('livestream.videos');

foreach (EventCategory::cases() as $category) {
    Route::get('/events/'.str($category->routeName())->after('events.'), fn () => view('site.events-category', [
        'category' => $category,
        'events' => Event::upcoming()->inCategory($category)->get(),
    ]))->name($category->routeName());
}

Route::get('/announcements', fn () => view('site.announcements', [
    'announcements' => Announcement::published()->get(),
]))->name('announcements');

Route::get('/events', function (Request $request) {
    $monthKey = $request->query('month');

    $month = is_string($monthKey) && preg_match('/^\d{4}-\d{2}$/', $monthKey) === 1
        ? Carbon::parse($monthKey)->startOfMonth()
        : now()->startOfMonth();

    $monthStart = $month->copy()->startOfMonth();
    $monthEnd = $month->copy()->endOfMonth();

    $eventsByDay = Event::query()
        ->whereBetween('starts_at', [$monthStart, $monthEnd])
        ->orderBy('starts_at')
        ->get()
        ->groupBy(fn (Event $event): string => $event->starts_at->toDateString());

    $gridStart = $monthStart->copy()->startOfWeek(Carbon::SUNDAY);
    $gridEnd = $monthEnd->copy()->endOfWeek(Carbon::SATURDAY);

    $cursor = Carbon::instance($gridStart);
    $weeks = [];

    while ($cursor->lte($gridEnd)) {
        $days = [];

        for ($i = 0; $i < 7 && $cursor->lte($gridEnd); $i++) {
            $date = $cursor->copy();
            $days[] = [
                'date' => $date,
                'inMonth' => $date->month === $month->month,
                'today' => $date->isToday(),
                'events' => $eventsByDay->get($date->toDateString(), collect()),
            ];
            $cursor->addDay();
        }

        $weeks[] = $days;
    }

    return view('site.events', [
        'month' => $month,
        'weeks' => $weeks,
        'prevMonth' => $month->copy()->subMonth()->format('Y-m'),
        'nextMonth' => $month->copy()->addMonth()->format('Y-m'),
        'upcomingEvents' => Event::upcoming()->get(),
    ]);
})->name('events');

Route::get('/live', fn () => view('site.live', [
    'stream' => Stream::current(),
]))->name('live');

Route::view('/prayer-requests', 'site.prayer-requests')->name('prayer-requests');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
