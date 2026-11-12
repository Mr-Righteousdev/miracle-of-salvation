<?php

test('every public page renders', function (string $routeName) {
    $this->get(route($routeName))->assertOk();
})->with([
    'home', 'contact', 'give', 'branches',
    'about.vision-bearer', 'about.church-profile', 'about.leadership',
    'ministries.youth', 'ministries.children', 'ministries.fathers-mothers', 'ministries.gallery',
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

test('the home page lists the church branches from config', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Miracle of Salvation Kinshasa')
        ->assertSee(route('branches').'#kinshasa');
});

test('unfinished pages show the work in progress banner', function () {
    $this->get(route('about.leadership'))
        ->assertOk()
        ->assertSee('Leadership — page not yet done');
});
