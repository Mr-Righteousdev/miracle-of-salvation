---
paths:
  - 'app/Providers/Filament/**'
---

# Filament

## Filament is admin-only; public app stays Filament-free
Filament is the ADMIN-ONLY panel at /admin (panel id 'admin', web guard). Never run `filament:install --scaffold` — it overwrites starter-kit files. Never import Filament CSS/JS/components into the public app (resources/css, public views, or public Livewire components). The public site is plain Livewire/Blade + Vite and must stay fully independent of Filament.
