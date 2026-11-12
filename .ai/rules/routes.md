---
paths:
  - 'routes/*.php'
  - routes/web.php
---

# Routes

## Public pages are route→view closures
Public pages follow a route→view shape so Lydia's frontend files drop in out of the box. Static pages: Route::view('/about', 'about'). DB-backed pages: Route::get('/events', fn () => view('events', ['events' => ...])) closures. Interactive bits (prayer form, stream comments/likes, give) are standalone Livewire components embedded in those views.

## Carbon startOfWeek returns immutable; use Carbon::instance to mutate
Carbon 3.x trap: `Carbon::startOfWeek()` / `endOfWeek()` return a CarbonImmutable, so `$x = $immutable->copy(); $x->addDay();` silently does NOT mutate — the loop never advances (OOM/segfault). When iterating calendar days, build the cursor with `Carbon::instance($immutable)` (or `toMutable()`) to get a mutable instance before calling addDay().

## Event category pages generated from the enum
`/events/{church-programs,community-outreach,missions}` are registered in a loop over EventCategory::cases(); each case's routeName() is the route name and its URL slug. Adding an enum case automatically adds a page and nav pill (site.partials.event-categories) — but also add it to the EVENTS dropdown in layouts/site. `/events` (upcoming + calendar) shows all categories.
