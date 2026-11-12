---
paths:
  - 'resources/views/**'
---

# Views

## Public site: Miracle of Salvation design in layouts/site
The public site uses the Miracle of Salvation design (originally the standalone `miracle_of_salvation/` PHP site). All public views live in `resources/views/site/*` and extend `layouts/site.blade.php`, which loads plain CSS/JS from `public/site/` (`style.css` = the original stylesheet, copied verbatim; `app.css` = components for DB-driven pages: calendar, events, stream, gallery, forms, pagination). NO Vite/Flux/Tailwind on public pages — only `@livewireStyles`/`@livewireScripts`. Public Livewire component views (prayer form, contact form, stream interactions) are plain HTML using the site's classes. Unfinished pages use `site.wip` (orange dashed "not yet done" banner) — replace the route's view when real content arrives. Old Flux-based views (`resources/views/{welcome,announcements,events,live,prayer-requests}.blade.php`, `partials/public-nav`) are unused leftovers.
