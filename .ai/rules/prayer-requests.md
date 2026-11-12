---
paths:
  - 'app/Filament/Resources/PrayerRequests/**'
---

# Prayer Requests

## Prayer→payment toggle deferred until MazPay is integrated
The link column now exists (`payments.prayer_request_id`, nullable, nullOnDelete) — do NOT add a payment FK on prayer_requests. The optional "attach a seed/offering" toggle on the public prayer form stays hidden until the MazPay gateway flow exists; it should create a Payment with prayer_request_id set.
