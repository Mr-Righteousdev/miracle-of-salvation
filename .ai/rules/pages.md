---
paths:
  - 'app/Filament/Pages/**'
---

# Pages

## Custom Filament pages must use HasPageShield trait
Custom Filament pages (anything not auto-protected by a policy, e.g. the Reports pages) MUST `use BezhanSalleh\FilamentShield\Traits\HasPageShield;` or they are accessible to ANY logged-in admin — Shield only auto-enforces resources via policies. The trait gates access on the `View:{Page}` permission that `shield:generate` creates.
