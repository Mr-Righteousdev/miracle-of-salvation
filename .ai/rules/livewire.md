---
paths:
  - app/Livewire/StreamInteractions.php
  - app/Livewire/ContactForm.php
---

# Livewire

## Stream likes keyed by session ID (anonymous, toggleable)
Stream likes are anonymous and keyed by the visitor's session ID (`stream_likes.liker_token`, unique per stream+session). A like toggles: clicking again deletes the visitor's row. This needs no JS/localStorage and no login; a visitor who clears cookies can like again.

## Stream comment toggles: enabled (form) vs visible (list)
Streams have two YouTube-style comment toggles (both default true): `comments_enabled` (visitors can post — hides the comment form and `addComment()` silently no-ops when off) and `comments_visible` (existing approved comments are displayed). Both editable in the stream form's "Comments" section. When both are off the public page shows "Comments are turned off". Likes are never affected by these toggles.

## Contact emails reuse receives_prayer_emails
NewContactMessage goes (synchronously, no queue — same as prayer requests) to users with `receives_prayer_emails = true`. There is deliberately no separate contact-email flag; add one only if the church wants different people on each inbox. Opening a message in Filament marks it read (ViewContactMessage::mount).
