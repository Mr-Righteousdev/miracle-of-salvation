# What we still need

Every page is built now. What's left is **content from the church**, a few **decisions**, and some **server steps**.
Once content arrives, the church can type almost all of it into **/admin** themselves. The "Where it goes" column says where.

---

## 1. Content to collect from the church

### About Us

| What | Details | Where it goes |
| --- | --- | --- |
| **Vision Bearer: name and title** | e.g. "Apostle …", "Founder & Senior Pastor" | Admin → Content → About Pages |
| **Vision Bearer: photo** | Good-quality portrait, ideally upright (4:5) | About Pages |
| **Vision Bearer: biography** | Calling, ministry journey, family (optional). 3–8 paragraphs | About Pages |
| **Vision Bearer: quote or scripture** | Optional, with its reference | About Pages |
| **Church history ("Our story")** | How and where the church started, key milestones | About Pages |
| **Year founded and founder** | | About Pages |
| **Leadership team** | For each leader: name, role, square photo, short bio (2–4 sentences), display order | Admin → Content → Leaders |
| **Core value 09 scripture** | "Compassion and Service" still says *"Official scripture references to be confirmed"* | Code (tell us) |

### Ministries
For **Youth**, **Children's** and **Fathers & Mothers** (and any other ministry they want listed):

- [ ] One-sentence summary
- [ ] Description (what they do, who it's for)
- [ ] Ministry leader's name
- [ ] When and where they meet
- [ ] Cover photo (landscape)

Goes in: Admin → Content → Ministries. Adding a ministry here also adds it to the menu.

### Branches
For each of the 6 branches (Kampala, Rwamwanja, Kagadi, Kirianjagi, Kinshasa, Twin Falls):

- [ ] Branch pastor
- [ ] Phone number
- [ ] Service times
- [ ] Photo of the church or congregation
- [ ] Google Maps link
- [ ] A better description (the current ones are placeholders)
- [ ] Any branches missing from the list?

Goes in: Admin → Content → Branches.

### Contact and giving

| What | Where it goes |
| --- | --- |
| Main phone number | Admin → Administration → Site Settings |
| Email address | Site Settings |
| WhatsApp number | Site Settings |
| Physical address (the site has only a P.O. Box) | Site Settings |
| Main service times | Site Settings |
| Facebook, YouTube and Instagram links | Site Settings |
| **How to give for now**: Mobile Money numbers and names, bank details | Site Settings → "How to give" (replaces "Coming Soon" on /give) |

### Media

- [ ] **Videos**: YouTube links for ministry, outreach and branch videos (not sermons, which go in Streams). They need a YouTube channel first.
- [ ] **Gallery photos**
- [ ] **Home page banner image**: `public/site/images/church-banner.jpg` is missing, so the hero shows only the blue gradient. This one is a file, so send it to us.

---

## 2. Decisions needed from the church

- [ ] **Site/app name**: `.env` says `APP_NAME="First Church"`, which shows in browser tabs ("Give | First Church") and as the email sender. Should it be **"Miracle of Salvation Church"**? If yes, we also update `->brandName()` in `AdminPanelProvider` and `.ai/rules/general.md`.
- [ ] **Branch activities**: `/branches` still has a "not yet done" banner. What should a branch's activities be: its own events, photos, videos, announcements? This decides whether each branch gets its own page.
- [ ] **Home page teasers**: should the home page show the latest announcements and upcoming events? (The original brief asked for it.)
- [ ] **Contact form emails**: should they go to the same people as prayer requests? (They currently do.)
- [ ] **Who manages the site**: names and emails of the people who need admin logins, and what each may touch. See "Editor role" below.

---

## 3. Payments (MazPay), still waiting on the church

From the church or MazPay:

- [ ] MazPay API documentation
- [ ] Sandbox credentials and live credentials
- [ ] Webhook/callback details and signature method
- [ ] Which methods to offer: MTN, Airtel, bank?

Then we build the online Give form, the payment webhook, the "attach a seed" option on prayer requests and a payments report. Until then, "How to give" in Site Settings covers giving.

---

## 4. Server / deploy steps (us)

Pushing `main` deploys automatically. Before merging `client-editable-content`, make sure `~/deploy.sh` on the server runs:

```bash
php artisan migrate --force                     # 6 new tables; branches + ministries arrive pre-filled
php artisan storage:link                        # once. Without it, uploaded photos 404
php artisan shield:generate --all --panel=admin # permissions for the new admin screens
```

- [ ] **Editor role**: in Admin → Roles, create "Editor". Tick Branches, Leaders, Ministries, Videos, Gallery, Announcements, Events and the About Pages page. Leave Users, Roles and Payments unticked. Give it to church staff instead of super admin.
- [ ] **Mail**: set real SMTP in production `.env`, or prayer and contact emails go nowhere.
- [ ] **Handover video for the church**: a 5-minute screen recording of adding an event, a branch, a leader and a video.

---

## 5. Cleanup (us, when happy)

- [ ] Delete `miracle_of_salvation/`. Its assets live in `public/site/` now.
- [ ] Delete the unused Flux-era views: `resources/views/{welcome,announcements,events,live,prayer-requests}.blade.php` and `partials/public-nav.blade.php`.
- [ ] Update `HANDOVER.md`. Its leadership, branches, contact and WIP-page items are done.
