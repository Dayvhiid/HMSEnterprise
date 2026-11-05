# Demo Guide — ClearSight EMR

The demo runs against its **own database** (`clearsight_demo`) using `.env.demo`.
Your normal `.env` / `hms_enterprise` database is not touched.

## Start the demo

```bash
# from the project folder
APP_ENV=demo php artisan serve --host=127.0.0.1 --port=8010
```

Open http://127.0.0.1:8010. In PowerShell, use `$env:APP_ENV='demo'; php artisan serve --host=127.0.0.1 --port=8010`.

`.env.demo` has `APP_DEBUG=false`, so errors show a plain error page instead of code and settings.

## Reset demo data (before each demo)

This wipes and refills **only** the demo database:

```bash
php artisan migrate:fresh --env=demo --seed --force
```

Check it says `clearsight_demo` first: `php artisan tinker --env=demo --execute="echo config('database.connections.mysql.database');"`

## Logins (password for all: `Demo-2026!`)

| Role | Email | Lands on |
|---|---|---|
| Administrator | admin@clearsight.demo | Admin dashboard (analytics, staff) |
| Clinician | doctor@clearsight.demo | Clinical dashboard |
| Front desk | frontdesk@clearsight.demo | Patient registration |
| Optician | optician@clearsight.demo | Optician dashboard |

The top bar on every main screen shows who is signed in, links to each module and **Log out**.

## Suggested demo script (≈15 minutes)

1. **Homepage** (`/`): neutral clinic page with *Book an appointment* and *Staff sign in*. Public sign-up is gone.
2. **Front desk**: sign in → register a new patient → you land on the new patient card → **Check in**.
3. **Clinician**: sign in → the dashboard shows the check-in notification → *Vitals* → record VA, refraction, Final RX, P.D., IOP → you land on the visit list → **Print spectacle Rx**.
4. **Clinician**: *Treatment* → save the plan → you land on the treatment history with a confirmation.
5. **Optician**: sign in → *Billing* → add items + 10% discount → **receipt for that invoice** (receipt number, patient name, discount, total) → Print / PDF.
6. **Admin**: sign in → *Invoice analytics* (net revenue after discounts, discounts given in naira, gross sales) → *Inventory analytics* (low stock) → *Demographics* → **Staff** (add a staff member live and show role-based landing).

## Avoid during the demo

- **Telemedicine**: unfinished and hidden (`CLINIC_FEATURE_TELEMEDICINE=false`).
- **Case-file images list**: seeded image rows point at files that don't exist, so they show as broken. Upload a real image first if you want to show it.
- **SMS**: only works if you add the *rotated* NigeriaBulkSMS credentials to `.env.demo`. Without them it says "SMS is not set up yet". It doesn't pretend to send.
- **Payment page / legacy sign-in screens**: stubs. Admin-only and not linked.
- Don't claim: NDPA/HIPAA compliance, audit trail, HMO billing, ICD-10 diagnoses. Present these as roadmap (see `ENTERPRISE_READINESS.md` §4–5).

## Branding

Everything clinic-specific comes from `CLINIC_*` values in `.env.demo` (see `config/clinic.php`).
To demo under a prospect's name, change `CLINIC_NAME`, `CLINIC_ADDRESS` and `CLINIC_PHONE`, then run `php artisan config:clear`.

## Needs internet

Pages still load Bootstrap, Tailwind, fonts, Chart.js, FullCalendar and the PDF library from CDNs. With internet at the venue this is fine. Self-hosting them is still needed for the offline-LAN goal.
