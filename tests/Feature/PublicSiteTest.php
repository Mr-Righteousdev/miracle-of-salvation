<?php

test('every public page renders', function (string $routeName) {
    $this->get(route($routeName))->assertOk();
})->with([
    'home', 'contact', 'give', 'branches',
    'about.vision-bearer', 'about.church-profile', 'about.leadership',
    'ministries.gallery',
    'events', 'events.church-programs', 'events.community-outreach', 'events.missions',
    'announcements', 'live', 'livestream.sermons', 'livestream.videos', 'prayer-requests',
]);

test('the site layout loads the church stylesheet and navigation', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee('site/css/style.css')
        ->assertSee(route('events.missions'))
        ->assertSee(route('prayer-requests'));
});

test('the home page lists the church branches', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Miracle of Salvation Kinshasa')
        ->assertSee(route('branches').'#kinshasa');
});

test('branch activities still show the work in progress banner', function () {
    $this->get(route('branches'))
        ->assertOk()
        ->assertSee('Branch activities — page not yet done');
});
