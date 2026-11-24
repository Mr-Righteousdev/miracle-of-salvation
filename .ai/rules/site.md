---
paths:
  - 'resources/views/site/**'
---

# Site

## Branches are DB-managed (Branch model), not config
Church branches live in the `branches` table, edited by admins in BranchResource (Content group). config/church.php was removed. The original 6 branches are inserted by the create_branches_table migration so every environment has them without seeding. Home and /branches routes pass `Branch::published()->get()`; the slug is the #anchor used on /branches. Rationale: the client manages content through data in fixed templates, never a generic page builder.

## Client-editable content: leaders, ministries, settings
Leadership (Leader model) and ministries (Ministry model, /ministries/{slug} → site.ministry) are DB-managed; the MINISTRIES nav dropdown comes from `$navMinistries` (view composer in AppServiceProvider). Contact details, social links and giving instructions come from `$settings` (Setting::values(), key/value table, defaults in Setting::DEFAULTS), shared to layouts.site and site.* by a view composer — never View::share (it would query the DB at boot). Edited via the SiteSettings Filament page. Never hardcode these in Blade again. Ministry slugs in Ministry::RESERVED_SLUGS (e.g. 'gallery') are blocked because /ministries/gallery is a fixed route registered before the wildcard.
