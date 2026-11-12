# Handover — things to do yourself

Everything below is **not** done in code. Items are ordered by priority.

---

## 1. Run on every environment (local is already done)

```bash
php artisan migrate          # 5 new migrations (contact, gallery, payment types, payments, event category)
php artisan storage:link     # public/storage symlink — uploaded images 404 without it
php artisan db:seed          # optional: seeds payment types Tithe / Offertory / Seed / Building Fund
```

- **Roles:** Shield generated permissions for the 4 new resources (Contact messages, Gallery, Payment types, Payments).
  Super admins see them automatically. Any other role needs them ticked in **Admin → Roles**.
- **Mail:** `MAIL_MAILER=log` in dev. Set real SMTP in production, or prayer/contact emails go nowhere.

---

## 2. Payments / Give — MazPay integration (the big one)

Already built: `PaymentType` + `Payment` models, admin list with filters (type / method / status / date),
payment types CRUD. The `/give` page still shows the original "Giving Platforms Coming Soon" notice.

To do:

- [ ] Get from the client: MazPay API docs, sandbox + live credentials, webhook/callback spec, signature method.
- [ ] Add credentials to `.env` + `config/services.php` (`services.mazpay.*`).
- [ ] Gateway class that starts a payment (MTN / Airtel / Bank) and returns the provider reference.
- [ ] Public Livewire `GiveForm` on `/give`: name (optional), phone/account, amount (whole UGX), type (`PaymentType::active()`), method, note.
      Create a `Payment` with status `pending` before calling the gateway.
- [ ] Webhook route: exclude it from CSRF, verify the signature, find the payment by `provider_reference`,
      set `status` + `paid_at`. Make it idempotent, because webhooks get retried.
- [ ] Prayer form "attach a seed/offering" toggle → creates a Payment with `prayer_request_id` (see `.ai/rules/prayer-requests.md`).
- [ ] Payment report page (totals by type / method / date range). Custom Filament pages **must** use `HasPageShield` (`.ai/rules/pages.md`).
- [ ] Tests for all of the above. Fake the gateway with `Http::fake()`.

---

## 3. Decisions needed from the client

- [ ] **App name:** `.env` `APP_NAME="First Church"` drives page titles (`Give | First Church`) and the mail sender.
      It should probably be `Miracle of Salvation Church`. If you change it, update `.ai/rules/general.md` and `->brandName()` in `AdminPanelProvider`.
- [ ] **Leadership:** keep it a static page, or make it admin-editable (Leader model: name, role, photo, order)?
- [ ] **Videos** (`/livestream/videos`): is this different from the sermons archive? If yes, add a `type` to streams. If no, drop the menu item.
- [ ] **Branches** (`/branches`): the content is in `config/church.php`. What does "branch activities" mean for each branch?
- [ ] **Contact details:** the site has only a P.O. box. Get the phone, email, physical address and service times.
- [ ] Should contact emails go to the same people as prayer emails? They currently reuse `receives_prayer_emails`.

---

## 4. Content / frontend (you + your co-developer)

Pages showing the orange "🚧 not yet done" banner. Each is one `Route::view(..., 'site.wip', ...)` line in `routes/web.php`.
Make a `resources/views/site/<page>.blade.php` and point the route at it:

| Page | Route name |
| --- | --- |
| Vision bearer | `about.vision-bearer` |
| Church profile | `about.church-profile` |
| Leadership | `about.leadership` |
| Youth / Children / Fathers & Mothers ministries | `ministries.youth`, `ministries.children`, `ministries.fathers-mothers` |
| Videos | `livestream.videos` |
| Branch activities (banner on top of `/branches`) | `branches` |

Also:

- [ ] **Missing image:** `public/site/images/church-banner.jpg`. The home hero shows only the blue gradient until it's added.
- [ ] **Home page teasers:** the brief wants announcements + upcoming events teasers on the home page.
      The new design has none, so add sections to `site/home.blade.php` and pass the data from the `home` route.
- [ ] Look over the DB-driven pages, which are new styles in the site's colours (`public/site/css/app.css`):
      `/events` (calendar), `/events/missions` etc., `/live`, `/livestream/sermons`, `/ministries/gallery`, `/announcements`, `/prayer-requests`, `/contact`.
- [ ] Menu placement I chose: **announcements** under EVENTS, **prayer requests** under CONTACT, **our branches** under ABOUT US. Change it in `layouts/site.blade.php` if you prefer something else.

---

## 5. Cleanup once you're happy

- [ ] Delete `miracle_of_salvation/`. Its assets were copied to `public/site/`, so **edit those copies from now on**.
- [ ] Delete the unused Flux-era views: `resources/views/{welcome,announcements,events,live,prayer-requests}.blade.php` and `partials/public-nav.blade.php`.
- [ ] Put the project in git. `pint --dirty` and code review both need it.

---

## What was built (for reference)

- **Public site:** `layouts/site` + `resources/views/site/*`. All menu links are live routes.
- **Contact messages:** Livewire form → saved + emailed to admins. Admin: read-only list, opening a message marks it read, read/unread toggle, unread count on the dashboard.
- **Event categories:** church program / community outreach / missions. Shown in the admin form, table filter and badge; each has a public page.
- **Sermons archive:** past streams with YouTube thumbnails, paginated.
- **Gallery:** admin upload, drag-to-reorder, publish date. Public gallery is paginated.
- **Payments data layer:** see section 2.
- **Fix:** announcement/event images were being saved to the private disk, so they never showed publicly. They now use the `public` disk.
- **Tests:** 163 passing (53 new). Larastan clean.
