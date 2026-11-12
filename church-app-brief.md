# Church Web App — Project Brief for OpenCode

## Overview

A church management platform with two sides:
- **Admin panel** — powered by Filament, used only by church staff with accounts
- **Public website** — a Livewire-driven frontend for the congregation (no accounts, no login)

Built on the **TALL stack** (Tailwind, Alpine, Livewire, Laravel) using the **Livewire full starter kit** already initialized. Filament is installed alongside it — the admin panel lives at `/admin` while the public site runs as the main app.

---

## Who Has Accounts

**Only admins have accounts and can log in.** The general public (congregation) does not register or log in. They can interact with the site (submit prayer requests, leave comments on streams, view events) but anonymously — no identity is stored or required.

---

## Tech Stack Decisions

- **Framework:** Laravel
- **Admin Panel:** Filament
- **Frontend:** Livewire + Alpine + Tailwind (Livewire full starter kit)
- **Roles & Permissions:** Spatie Laravel Permission (integrated with Filament)
- **Email:** Laravel Notifications (for prayer request alerts)
- **Payments:** MazPay (or equivalent Ugandan payment aggregator supporting MTN Mobile Money, Airtel Money, and bank payments) — **to be integrated last**
- **Live Streaming:** YouTube embed approach — no self-hosted streaming infrastructure
- **Multi-tenancy:** Not in this phase. Single-church build first. DB structure should be kept clean enough to migrate later if needed.

---

## Modules

### 1. User Management & Roles (Filament — Admin)

- Only admins have accounts in the system
- The senior pastor (super admin) can create admin accounts and assign roles
- Roles are fully configurable — pastor decides who does what
- Built with Spatie permissions integrated into Filament
- Each admin user has a flag: **receives prayer request emails** (true/false) — the pastor can toggle this per user
- Multiple users can receive prayer request email notifications simultaneously

---

### 2. Announcements (Filament — Admin / Public — Frontend)

- Admins create announcements from the Filament panel
- Announcements are visible on the public website
- Fields: title, body, optional image, publish date
- Simple CRUD — good first module to build

---

### 3. Events (Filament — Admin / Public — Frontend)

- Admins create events from the Filament panel
- Events have: title, description, date, time, location/venue, optional image
- **No attendance tracking** — events are informational only
- Public frontend displays events in a **calendar view**
- Each event on the frontend has:
  - A **"Add to Google Calendar"** button (generates a Google Calendar link with event details pre-filled)
  - A **"Set Reminder"** button (browser-based or mailto-based reminder — decide implementation during build)
- Filament panel also shows events in a calendar or list view for admin reference

---

### 4. Live Streaming (Filament — Admin / Public — Frontend)

**How it works:**
- When the church starts a live stream on YouTube, an admin goes into the Filament panel and creates/updates a "Stream" record by pasting the YouTube URL
- The system extracts the YouTube video ID from the URL
- The public frontend renders the stream using a YouTube `<iframe>` embed
- Visitors watch the stream directly on the church website (not redirected to YouTube)
- This idea was inspired by how Delta uses vMix for streaming with embed links

**Stream Records store:**
- Title of the stream/service
- YouTube URL (and extracted video ID)
- Date
- Status: live / past
- Comments (see below)
- Likes count

**Comments & Likes:**
- Anyone on the public site can like a stream (stored in DB, anonymous)
- Anyone can leave a comment on a stream — no account required
- Comment fields: message, optional name (we may decide to skip even the name), timestamp
- Comments are stored in the database tied to the stream record
- Admins can view and moderate comments from the Filament panel

---

### 5. Prayer Requests (Public — Frontend / Filament — Admin)

- A prayer request form exists on the public website
- Anyone can submit a prayer request — no login required
- Fields: name (optional), email (optional), prayer request message
- **Optional payment tie-in:** the form has an optional toggle — "I want to attach a seed/offering to this request." If toggled, payment fields appear inline (uses the payment module). A `payment` record is created and linked to the `prayer_request` record via `prayer_request_id`
- On submission, Laravel fires an email notification to all admin users who have the **receives prayer request emails** flag enabled
- Admins can view all prayer requests in the Filament panel

---

### 6. Payments (Public — Frontend / Filament — Admin)

> **Build this last.**

**Public giving:**
- A giving/payment page on the public website where anyone can contribute
- Payment types are **admin-configurable** (not hardcoded) — examples: Tithe, Seed, Offertory, Building Fund, etc. Pastor can add/edit/remove types from Filament
- Payment methods: MTN Mobile Money, Airtel Money, Bank — all via the MazPay API (or confirmed aggregator)
- Payer fills in: name (optional), phone/account, amount, payment type, optional note
- On success, a payment record is stored in the DB

**Prayer request payments:**
- As described in the Prayer Requests module — a payment can be linked to a prayer request

**Admin payment view:**
- Filament panel shows all payments with filters by type, method, date range
- Part of the reports module

---

### 7. Reports (Filament — Admin)

- Reports are available across the system for admins with appropriate permissions
- **Payment reports:** total giving by type, by method, by date range
- **Event reports:** events list, upcoming vs past
- **Prayer request reports:** submissions over time
- **User reports:** admin accounts, roles
- Reports can be viewed in-panel (tables/charts) — export to PDF or Excel is a stretch goal

---

## Public Website Pages

Lydia owns the frontend. These are the pages needed:

| Page | Description |
|---|---|
| Home | Main landing — hero, intro, announcements teaser, upcoming events teaser |
| About Us | Church history, vision, mission |
| Ministries | Describe the church's ministry arms |
| Gallery | Photo gallery — images managed by admin |
| Events | Calendar view of all events with Google Calendar / reminder buttons |
| Live Stream | Embedded YouTube stream player + comments + likes |
| Give / Payments | Public giving form with payment type selection and MazPay integration |
| Prayer Requests | Prayer request submission form |
| Announcements | Full announcements listing |

---

## Database Key Relationships (decisions, not schema)

- `users` — admins only. Has `receives_prayer_emails` boolean
- `roles` / `permissions` — managed by Spatie, surfaced in Filament
- `announcements` — standalone
- `events` — standalone
- `streams` — has many `stream_comments`, has many `stream_likes`
- `prayer_requests` — optionally belongs to one `payment` via `payment_id` (or reverse: `payments.prayer_request_id`)
- `payments` — belongs to a `payment_type`. Optionally linked to a prayer request
- `payment_types` — admin-managed list (tithe, seed, offertory, etc.)
- `gallery_images` — managed by admin, shown on frontend gallery page

---

## Build Order

1. Filament setup + Spatie roles & permissions + user management
2. Announcements
3. Events (with calendar on both sides)
4. Live streaming (stream record + YouTube embed + comments & likes)
5. Prayer requests (form + email notifications + optional payment link placeholder)
6. Reports
7. Payments (MazPay integration — MTN, Airtel, Bank) — **last**

---

## Goals at Completion

- A fully functional church management platform usable by a real Ugandan church
- Admins manage everything through Filament with role-based access
- Congregation interacts with the public site anonymously — no accounts needed
- Church can accept digital payments in three methods (MTN, Airtel, Bank)
- Church can stream live services via YouTube embed without needing a separate streaming platform
- Prayer requests flow from the public into admin email inboxes automatically
- Events are discoverable and addable to personal Google Calendars
- System is built cleanly enough to be extended to multi-tenancy (multiple churches) in a future phase

---

## What Is Out of Scope (This Phase)

- Multi-tenancy / multiple churches
- Member registration or congregation accounts
- Attendance tracking
- Self-hosted video streaming
- Mobile app
- SMS notifications (email only for now)
