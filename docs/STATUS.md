# Project Status

## Current goal
Prepare the existing Laravel 11 + Blade application for use as a Windows/macOS desktop experience with one dedicated local host and multiple LAN clients.

## Confirmed requirements
- Laravel 11.
- Blade frontend.
- MySQL remains the shared source of truth.
- One dedicated host stays on.
- Client computers use the same local Wi-Fi/LAN.
- Normal operation must not need public internet.
- Windows and macOS are target platforms.
- Installers are preferred.
- Client computers must not connect directly to MySQL.

## Current phase
Phase 1 — Architecture spike. (Phase 0 complete 2026-10-23; see `docs/SYSTEM_INVENTORY.md`.)

## Next task
Compare Option A (desktop shell → LAN Blade app) vs Option B (NativePHP client →
central API) per `ARCHITECTURE.md`, prototype the winner, and record the decision
in `DECISIONS.md`.

## Open decisions
- [ ] Desktop shell approach: NativePHP Desktop vs Electron/Tauri shell vs LAN web app/PWA.
- [ ] Host operating system and service management. (Inventory note: lowercase controller filenames break on case-insensitive-filesystem-only autoload — a Windows host is indicated unless those files are renamed.)
- [ ] Host URL discovery/configuration strategy.
- [ ] LAN HTTPS/security approach based on sensitivity and deployment constraints.
- [ ] Installer signing/notarization plan.
- [ ] How file uploads, printing, and external links should behave in the desktop shell.
- [ ] Approve running `php artisan migrate` on the real `hospital` database (applies the guarded no-op date migration + new nullable `two_factor_*` columns on `users`).

## Blockers
None. The desktop client architecture must be proven before implementation.

## Recent work
- 2026-11-05: **Find invoice redesigned** (`/invoice/find`, old `/invoice/search?query=` shows the same):
  one list with search by patient name, Patient ID or receipt number (RCT-000042 / 42), Today / Last 7
  days / This month chips and a from-to range, live updates, summary strip (count, total billed, discounts
  via `Invo::totals()`), 25-per-page table (receipt, date, patient linked to chart, items, discount, total,
  View receipt). Name search also finds invoices saved with a picked Patient ID. "Invoices" added to the
  chart nav. Deleted unused `invoice/search.blade.php` and `invoice/invoicesearch.blade.php`.
  Tests: 278 passed / 8 skipped / 0 failed.
- 2026-11-05: **Billing (Generate invoice) redesigned** on the clinical layout: New invoice / Find invoice
  tabs (search no longer sits on the create screen), patient picker (universal search; picking fills
  `pid` with the Patient ID so the receipt shows the patient, walk-in names still allowed), item entry
  bar with catalogue prices and stock hint above a line-item table (editable qty, remove, duplicates
  merged), sticky payment summary using the server formula, discount defaults to 0. "Create invoice" added
  to the chart nav (`?patient=`). Removed jQuery/jQuery UI/Bootstrap CDN and the stray `//` script
  artefact. Not added (no data fields): tax/VAT, payment method, due date, drafts. Posted fields and save
  logic unchanged. Note: invoice search matches `pid`, so invoices made with a picked patient are found by
  Patient ID, not name. Tests: 269 passed / 8 skipped / 0 failed.
- 2026-11-05: **Dispensing records: Posted from removed, Card number replaced by Patient ID.** No schema
  change: the Patient ID is stored in the existing `opticians.card_number` column (form field
  `patients[n][patient_id]`); `posted_from` is no longer collected (column kept for old rows). A Patient
  ID, when given, must belong to a registered patient; typing it fills the patient name. The list shows
  Patient ID (linked to the chart when registered). Top-bar search now lists an exact patient ID first.
  Tests: 262 passed / 8 skipped / 0 failed.
- 2026-11-05: **Optician and lens pages redesigned** on the clinical layout: `/optician/records` and
  `/admin2/lens` share a new multi-row entry table (`<x-clinical.row-entry>`: add/remove rows, typed rows
  kept after a failed save, date defaults to today, SN auto-numbered); `/optician/list` (also `/find`,
  `/search`) and `/lens/list` are searchable 25-per-page tables (`<x-clinical.pager>`), with module tabs
  (`<x-clinical.tabs>`). Removed "HealthPlus" branding, stock photos and fake Home/About/Contact links.
  Fixed: the lens form Add button on rows 2+ submitted the form; the dispensing success message had no
  styling; lens list loaded Bootstrap JS without its CSS (unstyled); lens delete had no confirmation and
  crashed on a missing lens. Lens save/delete now return to the lens list with a message. Optician search
  now matches part of a card number or name (was exact card number). Deleted unrouted
  `optician/find.blade.php` and `optician/listsearch.blade.php`. Tests: 258 passed / 8 skipped / 0 failed.
- 2026-11-05: **Floating section bar** (`<x-clinical.section-bar>`) on the treatment and exam forms: stays
  under the patient banner, jumps to a section (smooth scroll, cursor placed in its first box) and
  highlights the section in view. Tests: 246 passed / 8 skipped / 0 failed.
- 2026-11-05: **Treatment plan form redesigned** (`doctors.newIndex`) on the clinical layout: patient
  pre-filled from `?patient=` with chart and context, Medication / Spectacle prescription / Lens type /
  Remarks cards, "Insert last Final Rx", Save/Cancel in the action bar, unsaved-changes warning, typed
  values kept after a failed save. Fixed: (1) Cancel was a submit button and saved the plan; (2) lens
  checkbox labels were shifted by one in Single vision, Bifocal and Special order, so the box ticked
  saved a different option (stored values unchanged; labels now match; three options that were shown
  but unsaveable added: single vision transition A/R B/C, bifocal transition A/R B/C, Special Order DTOP
  Bifocal A/R B/C); (3) Duration defaulted to "1 Day" on every plan, now "Not set" unless chosen.
  **Past plans saved before this fix may hold the wrong lens option.** Tests: 244 passed / 8 skipped / 0 failed.
- 2026-11-05: **Exam entry form redesigned** (`doctors.newVitals`, used for new and edit): clinical layout
  with banner/chart nav/context (previous exam and Rx visible while recording), sticky section jump bar,
  sectioned cards using `<x-clinical.exam-grid>`, Save/Cancel in the action bar, unsaved-changes warning,
  "Copy from subjective refraction" into empty Final Rx boxes. Fixed: "Record examination" from the chart
  passed `?patient=` but the form ignored it, so the ID had to be retyped; it now fills in (read-only) and
  shows the chart. Kept: field names, one-time token, Enter guard, Save lock. ~1,200 lines down to ~250.
  Tests: 238 passed / 8 skipped / 0 failed.
- 2026-11-05: **Patients list redesigned** (`/records`, `/records/search` now one screen): compact search
  toolbar that filters as you type (Enter also works), filters for sex / checked in today / registration
  date range, sort, and a 25-per-page table (initials, ID, DOB/age, sex, phone, last exam, check-in
  status, View/Edit/Check in). Removed the placeholder Home/About/Contact links. Name/ID/phone matching
  moved to `PatientInfo::scopeMatching`, shared with the top-bar search; phone search now ignores spaces
  and dashes. `records/publicrecords.blade.php` is now unrouted (remove in U5). Status/clinician filters
  from the review were not added: those fields do not exist. Tests: 235 passed / 8 skipped / 0 failed.
- 2026-11-05: **Front desk registration redesigned** on the clinical layout: sectioned cards on a 2-3 column
  grid, Register Patient in the page header and sticky action bar, duplicate second nav row removed,
  "search before registering" and "Registered today" side panel. Fixed: a failed save (e.g. clashing
  patient ID) wiped everything typed; now values are kept and a fresh ID is suggested. Environment label
  is now a badge in the top bar; page background slate-50. Tests: 225 passed / 8 skipped / 0 failed.
- 2026-11-05: **U2 continued: every chart-nav link now stays inside the patient chart.** Examinations
  history, Treatment & Rx history and Personal details moved to `<x-layouts.clinical>` (banner, nav,
  context panel, action bar; no CDN). Exam visits are collapsible (newest open) with a VA/IOP/Rx summary
  line; new `<x-clinical.exam-grid>` replaces ~450 lines of repeated table markup. Treatment plans are
  one card per plan (drugs + lens type + Rx together), newest first. Bugs fixed on the way: exam history
  showed three case-history boxes under the wrong headings; saving Personal details blanked `fullname`
  and, when sex was stored in lower case, silently changed it to "Male". Tests: 220 passed / 8 skipped / 0 failed.
- 2026-11-05: **UI Phase U2 started: patient card redesigned** on the clinical layout: sticky patient
  banner (real DOB/age, replaces the hard-coded "1985-08-15" and the Google-hosted stock photo), chart
  nav, context panel (last exam VA/IOP, last final Rx, last treatment), action bar with check-in state.
  Tests: 211 passed / 8 skipped / 0 failed. Remaining U2 screens await review of the card.
- 2026-11-05: **UI redesign Phase U1 (shell) done** (ADR-005). New `<x-layouts.clinical>` six-zone
  layout (Tailwind via Vite, no CDN), universal patient/screen search at `/search` in the top bar of
  every screen (Ctrl+K or `/`), DEMO/TRAINING label on non-production copies. Search results page is
  the first screen on the new layout. Tests: 203 passed / 8 skipped / 0 failed. Next: U2 patient chart.
- 2026-11-04: **Tier 0 demo prep implemented** (see `docs/ENTERPRISE_READINESS.md` §4 and
  `docs/DEMO_GUIDE.md`). Public sign-up off, open routes behind auth/admin, SMS secrets
  moved to `.env`, private case-file images, role-based landing + top bar with log out,
  correct revenue maths, real result pages, neutral `ClearSight` branding via
  `config/clinic.php`, real staff page, printable spectacle Rx and per-invoice receipt,
  separate `clearsight_demo` database via `.env.demo`. Tests: 181 passed / 8 skipped / 0 failed.
  **Action needed:** rotate the SMS credentials that were committed in git history.
- 2026-11-04: Enterprise-readiness / demo-prep assessment written to
  `docs/ENTERPRISE_READINESS.md` (no code changes). Baseline: 102 passed / 7 skipped /
  0 failed; 171 routes. Tier 0 (pre-demo) items await approval.
- 2026-10-23: Phase 0 discovery complete. Guide docs copied into repo. Fixed
  `RoomController` PSR-4 path + route; fixed test DB config (sqlite :memory:);
  unblocked test suite (guarded broken migration, added missing `two_factor_*`
  columns). Baseline: 47 passed / 7 skipped / 0 failed. `route:list` works
  (167 routes). Biggest later-phase item: ~159 CDN references must be
  self-hosted for the offline-LAN requirement.
