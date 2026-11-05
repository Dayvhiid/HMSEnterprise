# Enterprise Readiness & Demo Preparation Assessment

Date: 2026-11-04. Based on reading the code at commit `470fe107`. No code was changed for this assessment.
Baseline: `php artisan test` → 102 passed, 7 skipped, 0 failed. `php artisan route:list` → 171 routes.

## 1. The honest picture

The app has a real, useful core for an **eye clinic**: patient registration, a detailed
ophthalmic exam (VA, lensometry, auto-ref, retinoscopy, subjective, final Rx, IOP,
anterior/posterior segment), treatment/spectacle prescription, optician dispatch,
inventory (drugs/frames/lenses/services), invoicing with stock deduction, appointments,
and admin analytics. Recent work (editable visits, double-submit protection, patient
summary, check-in) is good quality and tested.

But underneath, it is not yet an enterprise EMR:

- **No "visit/encounter" record.** Vitals, treatment, invoice, optician record and images
  are separate tables loosely linked by a typed-in patient-ID string. Vitals are split
  across `vitals` + `vital2s` and re-paired by timestamp (`Vital::pairedVital2`).
- **Zero foreign keys, no soft deletes, no audit trail.** Anything can be edited or hard-deleted, by anyone logged in, with no record of who did it.
- **Two roles only** (`admin`, `user`). Every non-admin user can do everything clinical and financial.
- **Billing records charges, not payments.** No paid/unpaid, payment method, balance, receipt numbering, void/refund, or end-of-day closing.

For the demo, **don't try to fix the foundations** — polish the main path, hide what's
unfinished, and have a credible roadmap for what managers will ask about.

## 2. What clinic/hospital managers will care about (in priority order)

| # | Manager concern | What they'll ask | Where we stand today |
|---|---|---|---|
| 1 | **Revenue leakage / staff fraud** | "Can staff change prices, give discounts or delete bills? Can I see today's cash vs. what was billed?" | Invoice prices come from the browser form and can be edited; any discount % is accepted; no payment recording; no void reason; no daily close. Revenue analytics overstate income (see 3.2). **Biggest commercial gap.** |
| 2 | **Accountability** | "Who registered/edited/deleted this? Who saw this patient?" | No audit log. Only patient summary and notifications record a user name. |
| 3 | **Data security & privacy** (NDPA 2023 in Nigeria; HIPAA-style expectations elsewhere) | "Who can see patient records? Is data encrypted? Can a junior staffer export everything?" | Public self-registration creates a working staff account; several public, unauthenticated routes; case-file images are publicly reachable by URL; secrets in source. |
| 4 | **Downtime & data loss** | "What if the server PC dies? What if there's no internet?" | No backup/restore yet (Phase 2 in roadmap). LAN-only is a strong selling point **but** the UI loads ~229 assets from CDNs, so it breaks without internet. |
| 5 | **Inventory shrinkage** | "Can I trust the stock count? Expired drugs?" | Stock deducted by matching item *name*; can go negative silently; manual stock ledger (`inventories`) is separate from real stock; no batch/expiry; no supplier/purchase records. |
| 6 | **Patient flow / waiting time** | "Can I see who's waiting and where each patient is?" | Check-in creates a notification only. No queue or status (waiting → vitals → doctor → optician → billing → done). |
| 7 | **Reports** | "Daily/monthly revenue, patients seen per doctor, new vs. returning, top diagnoses." | Some analytics exist (demographics, inventory, invoice). No per-staff, per-diagnosis or period-close reports. No export. |
| 8 | **Clinical quality & medico-legal** | "Diagnosis codes? Allergies? Can a doctor change a record after the fact?" | No structured diagnosis (ICD-10), no allergies/medications list, records editable forever with no history, no sign-off/lock. |
| 9 | **HMO / insurance** (very relevant in Nigeria: HMOs, NHIA) | "Can we bill HMOs and track claims?" | Not supported. |
| 10 | **Ease of use / training** | "Will my staff manage it?" | Inconsistent UI (Bootstrap + Tailwind + mockups), 46 pages titled "Document", blank "Go Back" success pages. |

## 3. Verified defects and gaps

### 3.1 Security (fix before any client data goes in; several also before the demo)

| Severity | Finding | Location |
|---|---|---|
| Critical | **Live SMS credentials committed to source** (Infobip API key; NigeriaBulkSMS username/password). Anyone with repo access can send SMS on the account. **Rotate the keys** and move them to `.env`. They stay in git history. | `app/Http/Controllers/SendSMSController.php`, `SmsController.php` |
| Critical | **Anyone can self-register a staff account.** `GET/POST /register` is public; new users get role `user`, which opens every clinical and billing screen. Fortify `registration()` is also enabled. | `routes/auth.php`, `config/fortify.php`, `RegisteredUserController` |
| High | **Unauthenticated routes:** `POST /import-users` (bulk-creates users from Excel), `POST /lenses/import`, `DELETE /inventory/{item}/delete`, `GET /inventory/store` (stock ledger listing), `GET /sendsms`, `GET /admin-entry`, `GET /payment-index` (contains payment test keys), `/client` video pages. | `routes/web.php:251-287` |
| High | **No role-based authorization** beyond the admin analytics group. Any logged-in user can delete patients, edit drug prices, change inventory, issue invoices. `/admin2`, `/admin/drug`, etc. are *not* inside the `admin` middleware. | `routes/web.php:141-153` |
| High | **Patient images are public.** Stored on the `public` disk; anyone who knows or guesses the URL can view them without logging in. Linked to patient only by a free-text "title". | `ImageUpload::store` |
| High | `APP_DEBUG=true` — any error during the demo shows a full stack trace with code and environment. | `.env` |
| Medium | Three legacy plaintext/side-door login tables (`doctors`, `registers`, `adminpasswords`/`adpasswords`) with their own sign-in screens that bypass Laravel auth; the demo seeder puts plaintext passwords into them. | `DoctorsController`, `Admin2Controller`, `HmsDemoSeeder` |
| Medium | Session lifetime 120 min, no idle lock; no login throttling check beyond Breeze default; 2FA available but not enforced for admins. | `config/session.php` |

### 3.2 Money and data-integrity bugs

| Finding | Effect | Location |
|---|---|---|
| Discount is saved as a **percentage**, but analytics treat it as a naira amount (`max(total - discount, 0)`), and the invoice analytics page ignores it (adds up gross line totals). The net total is already stored in `invos.amount` and not used. | **Revenue figures on the admin dashboard are wrong** (overstated). A manager comparing to cash will spot this. | `InvoiceController::getAllInvoices`, `AdminController::invoiceAnalytics` (~line 485) |
| Invoice price per line comes from the form, not from the price list. | A cashier can sell at any price. | `InvoiceController::save` |
| Stock deduction matches by item name, not ID; not in a transaction with the invoice. Duplicate names deduct from the first match. | Stock counts drift. | `InvoiceController::save` |
| `treats.duration` is NOT NULL but the controller doesn't require it; `patient_id` isn't validated or checked to exist. | Blank duration → server error; treatment can be saved for a patient who doesn't exist. | `TreatmentController::store` |
| Patient update/delete use `find()` without checking null, have no role check, and delete is permanent. | 500 errors on bad IDs; any user can permanently erase a patient. | `PagesController::update/destroy` |
| Patient-card update has no validation at all. | Bad data, blanked fields. | `PatientCardController::update` |
| Appointments aren't linked to patients (name + phone only); phone formatting replaces the first digit with `234` regardless of input. | Can't see a patient's appointment history; malformed numbers. | `MessagingController::store` |
| Scheduler calls `TwilioSmsController::test()` every minute and `playing()` every 15 s; `test()` ends in `dd()` and Twilio SDK isn't installed. | If the scheduler is ever started, it errors constantly. | `routes/console.php` |

### 3.3 Things that will look bad in a demo

- After login, users land on the stock Breeze **"Dashboard → Click to Proceed / Admin Portal"** page.
- Successes go to a blank page titled "Document" with a message and **Go Back** (`history.go(-1)`) — feels unfinished and invites resubmission. Wrong messages: deleting a patient says *"Product deleted Sucesfully"*; saving a treatment says *"Patient's vitals recorded successfully"*.
- `/admin/staff` is a static mockup showing **"Acme Health"** with fake rows. The admin inventory page title is **"Stitch Design"**.
- **"Ola-Oluwa Eye Clinic" is hard-coded** ~25 times across 7 files, so prospects see another clinic's name.
- 46 pages have `<title>Document</title>`.
- Telemedicine is half-built (empty `join` controller, needs internet). Payment page is a test stub.
- Mixed visual styles (Bootstrap pages, Tailwind pages, design mockups).
- With no internet at the venue, most pages lose their styling, fonts, charts and calendar (CDN assets).

### 3.4 Clinical/EMR feature gaps (vs. a standard EMR)

1. **Encounter/visit model** tying together check-in, vitals, diagnosis, treatment, orders, billing and sign-off.
2. **Structured diagnosis** (ICD-10, with eye-specific favorites: myopia, presbyopia, cataract, glaucoma, conjunctivitis…) and a **problem list**.
3. **Allergies and current medications**, shown as a banner on every clinical screen.
4. **Record locking & amendments**: a signed note becomes read-only; later corrections are added as amendments with who/when/why.
5. **Printable documents** with the clinic letterhead: spectacle Rx, drug prescription, invoice/receipt, referral letter, medical report. Spectacle Rx printing is essential for an optical practice.
6. **Patient timeline**: every visit, Rx, invoice and image on one screen.
7. **Duplicate-patient detection** (same phone + DOB) and auto-generated MRN instead of typing the patient ID by hand.
8. **Orders and results** (e.g., OCT, visual fields, biometry) with image attachments tied to the visit.
9. **Consent capture** (procedures, data processing — NDPA).
10. **Follow-up/recall** (the `rtc` field exists — it should create an appointment and an SMS reminder).

## 4. Recommended plan

### Tier 0 status (2026-11-04)

Done: items 1–7, 9 and 10, plus fixes found along the way (receipt showed the newest invoice
instead of the saved one; `/invoices-api` crashed; search pages crashed without `?query=`;
uploaded images never displayed; public booking crashed on missing fields; the demo seeder's
dates of birth and discounts were wrong). Item 8 (self-hosting CDN assets) is deferred because
the demo venue has internet. Remaining manual action: **rotate the SMS credentials**.
How to run the demo: `docs/DEMO_GUIDE.md`.

### Tier 0 — Before the demo (low risk, high impact, ~2–4 working days)

These are mostly UI/config changes and don't touch the schema or existing data.

1. **Demo environment**: separate demo database seeded with realistic data (`HmsDemoSeeder`), `APP_DEBUG=false`, demo accounts per role. Rehearse with **internet switched off**.
2. **Lock the obvious holes**: disable public `/register` and Fortify registration; put the unauthenticated routes (`/import-users`, `/lenses/import`, `/inventory/*`, `/sendsms`, `/admin-entry`, `/payment-index`, `/client*`) behind `auth` (and `admin` where it fits); move `/admin2`, `/admin/*` into the `admin` group. Rotate and move the SMS keys to `.env`.
3. **Role-based landing after login**: admin → admin dashboard; clinician → doctors dashboard; optician → optician dashboard. Replace the Breeze dashboard.
4. **White-label**: replace the hard-coded clinic name with a single config value (`config('app.name')` / a `clinic.php` config with name, address, phone, logo). Fix page titles.
5. **Fix revenue numbers**: analytics use the stored net `amount` and treat discount as a percentage consistently. Add a test.
6. **Replace the "Document / Go Back" pages** with a redirect back to the relevant screen and a flash message (toast) with the right text.
7. **Hide unfinished modules** for the demo: telemedicine, payment stub, staff mockup (or replace with a real list of users from the `users` table), legacy sign-in screens.
8. **Self-host the CDN assets** used on the demo path (or at least Bootstrap, Tailwind, fonts, Chart.js, FullCalendar), so it works with no internet — which is also the main selling point.
9. **Spectacle Rx print** (and invoice/receipt print) with clinic letterhead on the demo path.
10. **Golden-path script**: Register patient → check-in → vitals/exam → treatment & spectacle Rx → optician dispatch → invoice → admin dashboard. Click through it end to end and fix anything that breaks.

### Tier 1 — First weeks after the demo (needs your approval: auth, schema, security)

1. **Roles & permissions**: receptionist, nurse/optometrist, doctor, optician, cashier, store-keeper, admin; enforce per module server-side (Laravel Policies/Gates or `spatie/laravel-permission`). Admin user-management screen (invite, deactivate, reset password, force 2FA for admins).
2. **Audit log** of create/update/delete and patient-record views (who, when, what changed). Soft deletes on patients, clinical records, invoices.
3. **Billing integrity**: prices from the price list (override only with permission + reason), discount limits by role, payments table (cash/transfer/POS/HMO, partial payments, balance), sequential receipt numbers, void with reason and approval, **end-of-day cash report per cashier**.
4. **Inventory by item ID** inside a DB transaction with the invoice; stock movements recorded automatically; negative-stock warning; batch & expiry for drugs.
5. **Backups**: scheduled `mysqldump` on the host, copied to a second drive/USB, plus a tested restore procedure (ties into roadmap Phase 2).
6. Remove legacy login tables and the overlapping auth stacks; fix the scheduler.

### Tier 2 — Enterprise EMR foundations (1–3 months)

1. **Encounter model** + migrating existing vitals/treats into it (needs a verified backup and approval).
2. Foreign keys and a single numeric `patient_id` link; merge `vitals`/`vital2s`.
3. Diagnosis (ICD-10), allergies, medications, problem list, sign/lock + amendments.
4. Patient queue / clinic flow board.
5. HMO/NHIA billing: schemes, tariffs, authorization codes, claims export.
6. Reports module with date ranges and CSV/Excel export (Maatwebsite Excel is already installed).
7. SMS reminders through a queued, configurable provider (appointments, recalls, birthdays).
8. LAN HTTPS, idle-session lock, NDPA compliance pack (privacy notice, consent, data-retention policy, breach procedure).
9. Desktop packaging per roadmap Phases 1–5.

## 5. Demo talking points (honest positioning)

- **Strength:** works on the clinic's own network with no internet or monthly cloud fees; data stays on the premises (once assets are self-hosted).
- **Strength:** a detailed ophthalmic exam built for eye clinics, not a generic EMR form.
- **Strength:** billing deducts inventory automatically; low-stock and revenue analytics.
- **Roadmap (say it, don't demo it):** role-based access with audit trail, payment reconciliation and daily close, HMO billing, ICD-10 diagnoses, backups.
- Avoid claiming "HIPAA/NDPA compliant", "fully audited" or "telemedicine" until those exist.
