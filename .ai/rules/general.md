---
paths:
  - '**'
  - .env
---

# General

## No multitenancy — ever
This is a single-church app — NEVER make it multitenant. Do not add tenant columns (tenant_id etc.), tenancy packages (stancl/tenancy, tenancy/multi-tenant), or enable tenancy/team features in plugins (e.g. Shield tenancy, Spatie permission teams). config('filament-shield.tenant_model') stays null.

## APP_NAME = "First Church" (titles + mail from name)
`APP_NAME` in .env is "First Church" (was the Laravel default). Don't revert to "Laravel" — it drives public page titles and the mail FROM_NAME for notifications. The admin panel brand name is hardcoded via `->brandName('First Church')` in AdminPanelProvider.
