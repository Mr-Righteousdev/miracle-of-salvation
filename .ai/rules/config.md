---
paths:
  - config/filament-shield.php
---

# Config

## Super admin bypasses via Gate, not permissions
`filament-shield.super_admin.define_via_gate` must stay `true`. Shield then registers a `Gate::before` that lets the super_admin role bypass every policy, so super admins never need permission rows and tests don't have to seed all permissions onto the role. If set to `false`, Shield instead grants every generated permission to the super_admin role, which breaks in tests that create the role fresh (403 on resources).
