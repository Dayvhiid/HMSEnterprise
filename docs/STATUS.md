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
