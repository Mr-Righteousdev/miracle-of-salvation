---
paths:
  - 'app/Filament/Resources/**'
---

# Resources

## Resource layout + published-scope pattern
Resources live in pluralized subdirectories (app/Filament/Resources/Users/, .../Announcements/) with Schemas/, Tables/, Pages/ split. Admin-only resources (Users) use navigationGroup 'Administration'; content resources (Announcements) use 'Content'. Publicly-visible content models get a `published()` scope (published_at not null AND <= now) and the public route is a route->view closure (routes.md) that queries that scope.

## Public images must use the public disk
FILESYSTEM_DISK is `local` (private), so Filament uploads default to a non-web-accessible disk. Any FileUpload whose file is shown on the public site (announcements, events, gallery) MUST set `->disk('public')`, and its ImageColumn/ImageEntry must too. Public views render them with `asset('storage/'.$path)`, which needs `php artisan storage:link` on every environment.
