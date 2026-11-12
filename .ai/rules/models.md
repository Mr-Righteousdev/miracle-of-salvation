---
paths:
  - app/Models/Event.php
  - app/Models/StreamComment.php
  - app/Models/Payment.php
---

# Models

## Set Reminder is mailto; Google Calendar via TEMPLATE link
Event "Set Reminder" button is a mailto link (Event::reminderUrl()) pre-filling a reminder email — chosen over the browser Notification API because it works everywhere without permission prompts and doesn't rely on the tab staying open. "Add to Google Calendar" is Event::googleCalendarUrl() using the action=TEMPLATE link (UTC Ymd\THis\Z dates, +2h end).

## Stream comments require admin approval before public display
Stream comments are NOT shown publicly until an admin approves them: `is_approved` defaults to false and the public list uses the `approved()` scope. Admins moderate via the StreamCommentsRelationManager on the stream View page (Approve/Unapprove toggle + delete). Comments need no account; `name` is optional and stored null when blank.

## Payments are gateway-created, read-only in admin
Payment rows must only be created/updated by the payment gateway flow (MazPay, not yet integrated) — PaymentResource has canCreate() false and no edit page. Amounts are whole UGX in an unsigned integer (no decimals). `payments.prayer_request_id` is the prayer→payment link from the brief; the public "attach a seed" toggle is still deferred until the gateway exists. PaymentType is admin-managed (seeded: Tithe, Offertory, Seed, Building Fund).
