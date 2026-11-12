# Hosting on Namecheap Shared Hosting (cPanel + MySQL)

A step-by-step guide to putting this Laravel app (public site + Filament admin at `/admin`) on a
Namecheap shared hosting plan, using MySQL.

> Replace these placeholders throughout:
> - `CPANELUSER`: your cPanel username (shown on the right of the cPanel home page)
> - `yourdomain.com`: the church's domain
> - `firstchurch`: the folder the app will live in on the server

---

## 0. What this app needs from the host

| Requirement | Why |
| --- | --- |
| **PHP 8.4** | `composer.lock` pins packages to PHP ≥ 8.4.1. 8.3 will **not** work. |
| PHP extensions: `pdo_mysql`, `mysqlnd`, `intl`, `mbstring`, `fileinfo`, `openssl`, `tokenizer`, `ctype`, `curl`, `dom`, `xml`, `xmlwriter`, `zip`, `gd`, `bcmath` | Laravel + Filament (`intl` is required by Filament) |
| MySQL 5.7+ or MariaDB 10.3+ | Namecheap provides this |
| SSH access | To run `php artisan …` commands. Namecheap shared plans include it on **port 21098** |
| **No** queue worker, **no** cron | Emails send immediately and nothing is scheduled, so shared hosting is fine |

---

## 1. Prepare the code on your computer

### 1.1 Build the frontend assets
The settings/dashboard pages use Vite. The shared server can't run `npm`, so build locally:

```bash
npm ci
npm run build          # creates public/build/
rm -f public/hot       # IMPORTANT: if this file is uploaded, pages try to load CSS from your laptop
```

### 1.2 Decide how you'll get `vendor/` onto the server

- **Option A (recommended): run Composer on the server.** Namecheap shared hosting normally has
  `composer` available over SSH. You can check later with `composer -V`. Then **don't** upload `vendor/`.
- **Option B: upload `vendor/` yourself.** Use this only if `composer` is missing on the server. Do it
  in a **copy** of the project so your dev setup isn't changed:
  ```bash
  cp -r firstchurch /tmp/firstchurch-deploy && cd /tmp/firstchurch-deploy
  composer install --no-dev --optimize-autoloader
  ```

### 1.3 Make the upload zip
Run this from the project root. It leaves out local-only and dev-only files:

```bash
rm -f bootstrap/cache/*.php     # these cache your DEV packages (e.g. Boost) and crash production

zip -r ../firstchurch.zip . \
  -x "node_modules/*" "vendor/*" ".env" "database/database.sqlite" \
     "public/hot" "public/storage" \
     "storage/logs/*.log" "storage/framework/sessions/*" "storage/framework/views/*" "storage/framework/cache/data/*" \
     "miracle_of_salvation/*" "tests/*" \
     ".claude/*" ".codex/*" ".grok/*" ".pi/*" ".zed/*" ".agents/*" ".git/*"
```

> With Option B, remove `"vendor/*"` from the exclude list so `vendor/` is included.

---

## 2. cPanel setup

Log in to Namecheap → **Hosting List** → **Go to cPanel**.

### 2.1 Set PHP to 8.4
cPanel → **Select PHP Version** (CloudLinux selector):
1. Set **Current PHP version** to **8.4** and click **Set as current**.
2. On the **Extensions** tab, tick every extension in the table in section 0. Changes save automatically.
3. On the **Options** tab, set these (gallery uploads are up to 5 MB):
   - `memory_limit` = `256M`
   - `upload_max_filesize` = `10M`
   - `post_max_size` = `12M`
   - `max_execution_time` = `120`

### 2.2 Create the MySQL database
cPanel → **MySQL® Databases**:
1. **Create New Database**: e.g. `church`. It becomes `CPANELUSER_church`.
2. **Add New User**: e.g. `church`, which becomes `CPANELUSER_church`. Use the password generator and **save the password**.
3. **Add User To Database**: pick that user and database, then tick **ALL PRIVILEGES**.

DB host is `localhost`.

### 2.3 Enable SSH
cPanel → **SSH Access** → **Manage SSH Keys**:
1. **Import Key**: paste your public key (`~/.ssh/id_ed25519.pub`), or generate one there.
2. Click **Manage** → **Authorize**.

Connect from your computer:
```bash
ssh -p 21098 CPANELUSER@yourdomain.com
```
(If SSH is greyed out, open a ticket with Namecheap live chat and ask them to enable SSH for the account.)

---

## 3. Upload the code

The app must live **outside** `public_html`, so `.env` and source code are never web-accessible.

1. cPanel → **File Manager** → go to your home folder (`/home/CPANELUSER`).
2. Create the folder `firstchurch`.
3. Open it, **Upload** `firstchurch.zip`, then right-click it → **Extract**. Delete the zip afterwards.

You should now have `/home/CPANELUSER/firstchurch/artisan`, `/home/CPANELUSER/firstchurch/public/index.php`, and so on.

---

## 4. Point the domain at `firstchurch/public`

Only Laravel's `public/` folder should be served. Choose the case that matches your domain.

### Case 1: The church site is an **addon domain or subdomain** (easiest)
cPanel → **Domains** → click **Manage** next to the domain → set **Document Root** to
`firstchurch/public` → **Update**. Then skip to section 5.

### Case 2: The church site is the account's **main domain** (uses `public_html`)
Replace `public_html` with a symlink to the app's `public/` folder. Over SSH:

```bash
cd ~
mv public_html public_html_backup                 # keep the old one, just in case
ln -s /home/CPANELUSER/firstchurch/public public_html
ls -la | grep public_html                         # should show: public_html -> /home/CPANELUSER/firstchurch/public
```

### Case 3: Fallback, if the symlink gives "403 Forbidden"
1. Copy everything **inside** `firstchurch/public/` into `public_html/`. That includes the hidden `.htaccess`, so enable "Show Hidden Files" in File Manager settings.
2. Edit `public_html/index.php` and change the two paths:
   ```php
   // before:
   require __DIR__.'/../vendor/autoload.php';
   $app = require_once __DIR__.'/../bootstrap/app.php';
   // after:
   require __DIR__.'/../firstchurch/vendor/autoload.php';
   $app = require_once __DIR__.'/../firstchurch/bootstrap/app.php';
   ```
   Also change the maintenance line near the top, from `__DIR__.'/../storage/framework/maintenance.php'` to `__DIR__.'/../firstchurch/storage/framework/maintenance.php'`.
3. In step 5.4, run this instead of `php artisan storage:link`:
   ```bash
   ln -s /home/CPANELUSER/firstchurch/storage/app/public /home/CPANELUSER/public_html/storage
   ```
4. ⚠️ In this case, every deploy must re-copy `public/` into `public_html/`, because assets like `public/site/` and `public/build/` live there.

---

## 5. Configure and install (over SSH)

```bash
ssh -p 21098 CPANELUSER@yourdomain.com
cd ~/firstchurch
php -v        # must say 8.4.x
```

> If `php -v` shows an older version, use the full path to PHP 8.4 instead of `php`.
> On Namecheap that's usually `/opt/alt/php84/usr/bin/php`. Use it the same way below, e.g. `/opt/alt/php84/usr/bin/php artisan migrate --force`.

### 5.1 Install PHP dependencies (Option A only)
```bash
composer install --no-dev --optimize-autoloader
```
If you get a PHP version error here, run it as `/opt/alt/php84/usr/bin/php $(which composer) install --no-dev --optimize-autoloader`.

### 5.2 Create the production `.env`
```bash
cp .env.example .env
nano .env
```
Set these values. Everything else can stay as in `.env.example`:

```dotenv
APP_NAME="Miracle of Salvation Church"   # or "First Church", see HANDOVER.md §3
APP_ENV=production
APP_DEBUG=false                          # NEVER true in production: it shows passwords on error pages
APP_URL=https://yourdomain.com

LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=CPANELUSER_church
DB_USERNAME=CPANELUSER_church
DB_PASSWORD="the-password-from-step-2.2"

SESSION_DRIVER=database
SESSION_SECURE_COOKIE=true
CACHE_STORE=database
QUEUE_CONNECTION=sync                    # no queue worker on shared hosting
FILESYSTEM_DISK=local                    # keep: public images use the "public" disk explicitly

MAIL_MAILER=smtp
MAIL_SCHEME=smtps
MAIL_HOST=mail.yourdomain.com
MAIL_PORT=465
MAIL_USERNAME=noreply@yourdomain.com
MAIL_PASSWORD="mailbox-password"
MAIL_FROM_ADDRESS="noreply@yourdomain.com"
MAIL_FROM_NAME="${APP_NAME}"
```
Save with `Ctrl+O`, `Enter`, then exit with `Ctrl+X`. Then protect the file:
```bash
chmod 600 .env
```

### 5.3 Create the mailbox used in `.env`
cPanel → **Email Accounts** → **Create** → `noreply@yourdomain.com`. Use the same password as `MAIL_PASSWORD`.
The prayer request and contact form emails are sent from this address.

### 5.4 Run the install commands
```bash
php artisan key:generate --force
php artisan migrate --force
php artisan storage:link                 # skip if you used Case 3 (you made the link by hand)

chmod -R 755 storage bootstrap/cache
```

### 5.5 Create the admin account
⚠️ **Do NOT run `php artisan db:seed` in production.** It creates fake announcements and events,
plus an admin account with the password `password`.

Instead:
```bash
php artisan shield:generate --all --panel=admin --option=permissions   # creates the permission rows for the Roles screen
php artisan make:filament-user                                         # asks for name, email, password
php artisan shield:super-admin --user=1 --panel=admin                  # 1 = the ID of the user you just created
```
Turn on prayer/contact emails for that admin, and add the giving types:
```bash
php artisan tinker --execute 'App\Models\User::find(1)->update(["receives_prayer_emails" => true, "email_verified_at" => now()]);'
php artisan tinker --execute 'foreach (["Tithe","Offertory","Seed","Building Fund"] as $i => $n) { App\Models\PaymentType::updateOrCreate(["name" => $n], ["sort_order" => $i, "is_active" => true]); }'
```

### 5.6 Cache everything for speed
```bash
php artisan optimize           # caches config, routes, views, events
php artisan filament:optimize  # caches Filament components + icons
```
> After **any** later `.env` change, run `php artisan optimize` again. Until you do, the old cached values stay in use.

---

## 6. HTTPS

1. cPanel → **SSL/TLS Status**. Make sure the domain and `www.` have a valid certificate. Namecheap's AutoSSL issues one free; click **Run AutoSSL** if needed.
2. cPanel → **Domains**. Turn on **Force HTTPS Redirect** for the domain.
3. Open `https://yourdomain.com`. The padlock should show, and `http://` should redirect to it.

---

## 7. Smoke test

| Check | Expected |
| --- | --- |
| `https://yourdomain.com` | Miracle of Salvation home page with logo and styling |
| `/events`, `/live`, `/ministries/gallery` | Pages load (with empty states until content is added) |
| `/admin` | Filament login. Sign in with the account from 5.5 |
| Admin → Gallery → upload a photo | Photo appears on `/ministries/gallery` |
| Submit `/contact` and `/prayer-requests` | Saved in the admin **and** an email arrives in the admin inbox |

If emails don't arrive, test the mail settings directly:
```bash
php artisan tinker --execute 'Illuminate\Support\Facades\Mail::raw("Test from the church site", fn ($m) => $m->to("you@example.com")->subject("Mail test"));'
```

---

## 8. Deploying updates later

On your computer:
```bash
npm run build && rm -f public/hot
rm -f bootstrap/cache/*.php
# zip only what changed, or re-make the full zip from step 1.3
```
Upload and extract over `~/firstchurch` (with Case 3, also copy `public/*` into `public_html/` again). Then over SSH:

```bash
cd ~/firstchurch
php artisan down                                  # shows a maintenance page
composer install --no-dev --optimize-autoloader   # only if composer.json/lock changed (Option A)
php artisan migrate --force
php artisan optimize:clear && php artisan optimize && php artisan filament:optimize
php artisan up
```

> Never overwrite the server's `.env`, `storage/app/public/` (uploaded photos) or `public/storage`.
> The zip excludes them, so keep it that way.

**Backups:** cPanel → **Backup** (or **JetBackup**, if your plan has it). Download a MySQL backup of
`CPANELUSER_church` and a copy of `storage/app/public/` before every update.

---

## 9. Troubleshooting

| Symptom | Fix |
| --- | --- |
| **500 error / blank page** | Read `~/firstchurch/storage/logs/laravel.log` (`tail -50 storage/logs/laravel.log`). Never turn on `APP_DEBUG` to debug in production. |
| `Class "Laravel\Boost\..." not found` or another dev package | You uploaded `bootstrap/cache/packages.php` / `services.php` from your PC. Delete `bootstrap/cache/*.php`, then run `php artisan optimize`. |
| Pages unstyled, browser console shows `localhost:5173` | `public/hot` was uploaded. Delete it. |
| `Vite manifest not found` | `public/build/` is missing. Run `npm run build` locally and upload `public/build/`. |
| Uploaded images show broken | Re-run `php artisan storage:link` (Case 3: re-create the manual symlink). Check that `public/storage` exists. |
| `SQLSTATE[HY000] [1045] Access denied` | The DB name and user need the `CPANELUSER_` prefix. Check that the user was added to the DB with ALL PRIVILEGES. Run `php artisan optimize` after editing `.env`. |
| `Specified key was too long` during migrate | Very old MySQL. Ask Namecheap support which MySQL/MariaDB version you're on; it must be MySQL 5.7+ or MariaDB 10.3+. |
| `composer` / `artisan` complains about the PHP version | The SSH `php` isn't 8.4. Use `/opt/alt/php84/usr/bin/php` (see section 5). |
| 403 Forbidden on the whole site | The symlink isn't being followed. Use section 4 Case 3. |
| Livewire forms don't submit | Check `APP_URL` matches the real `https://` address, then run `php artisan optimize`. |
| Logged out constantly / "Page expired" (419) | `SESSION_SECURE_COOKIE=true` needs HTTPS working (section 6). Make sure the `sessions` table exists (`php artisan migrate --force`). |

---

## 10. Later: when payments (MazPay) are added

- Put the MazPay keys in the server `.env` only, then run `php artisan optimize`.
- Give MazPay the webhook URL as `https://yourdomain.com/...`. It must be HTTPS, and it only works once section 6 is done.
- No cron or queue is needed unless the integration adds scheduled jobs. If it does, add this in cPanel → **Cron Jobs**:
  ```
  * * * * * cd /home/CPANELUSER/firstchurch && /opt/alt/php84/usr/bin/php artisan schedule:run >> /dev/null 2>&1
  ```
