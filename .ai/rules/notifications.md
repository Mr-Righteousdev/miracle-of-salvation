---
paths:
  - app/Notifications/NewPrayerRequest.php
---

# Notifications

## Prayer request notifications sent synchronously (no queue)
NewPrayerRequest is sent synchronously (NOT ShouldQueue) from the public prayer request form to every admin with `receives_prayer_emails = true`. There is no queue worker, so do not add ShouldQueue or the emails will never send. MAIL_MAILER=log in dev.
