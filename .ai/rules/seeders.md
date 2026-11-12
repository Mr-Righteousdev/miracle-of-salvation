---
paths:
  - database/seeders/DatabaseSeeder.php
---

# Seeders

## Seeder admin credentials + idempotent user seeding
The seeder creates the super admin `admin@firstchurch.test` / `password` (role: super_admin, receives_prayer_emails: true) and a plain `test@example.com` / `password` user. Users are seeded via updateOrCreate(keyed on email) so re-seeding is idempotent — keep it that way. Super admin bypasses all Shield policies via Gate::before.
