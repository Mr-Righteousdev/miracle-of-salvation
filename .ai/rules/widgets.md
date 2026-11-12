---
paths:
  - 'app/Filament/Widgets/**'
---

# Widgets

## Custom widgets: HasWidgetShield + $isLazy = false
Custom dashboard widgets must `use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;` so Shield gates them on the `View:{Widget}` permission (shield:generate --all auto-creates these). Widgets are lazy-loaded by default in Filament v5 — set `protected static bool $isLazy = false;` so they render server-side (no JS loading, and GET/Livewire test assertions can see their content). Default dashboard widgets (AccountWidget, FilamentInfoWidget) are removed in AdminPanelProvider.
