# Architecture Decision Log

Record each meaningful decision here. Newest entries go first.

## ADR-005 — Clinic branding comes from configuration
- Status: Accepted (2026-11-04).
- Decision: Clinic name, address, phone, product name and SMS sender come from `config/clinic.php` (`CLINIC_*` in `.env`). The neutral defaults are "ClearSight EMR" / "ClearSight Eye Clinic". `/` is a neutral welcome page; the original clinic's marketing pages are kept but not routed.
- Consequence: Each installation sets its own branding without code changes. Unfinished modules are hidden behind `clinic.features.*` flags.

## ADR-004 — Staff accounts are created by administrators
- Status: Accepted (2026-11-04).
- Decision: Public self-registration (`/register`, Fortify registration) is disabled. Admins add staff at `/admin/staff`. Each role (`admin`, `user` = clinician, `reception`, `optician`) has its own home screen after login.
- Consequence: Only admin-only routes are restricted by role so far. Full per-module permissions and an audit log are Tier 1 work.

## ADR-001 — Shared data architecture
- Status: Accepted as a requirement; implementation details pending proof of concept.
- Context: Multiple computers are on the same local Wi-Fi and must use shared data without public internet.
- Decision: One dedicated host will run Laravel and MySQL. Client computers will access the host through Laravel. Clients will not connect directly to MySQL.
- Consequences: The host must remain on and reachable for shared workflows. Host backups and recovery are essential. If the host is unavailable, clients cannot perform shared operations.

## ADR-002 — Desktop packaging strategy
- Status: Pending proof of concept.
- Context: Existing app is Laravel 11 with Blade. Desired clients are Windows and macOS installers. NativePHP Desktop is under consideration.
- Options:
  1. Desktop shell opens the centrally hosted Laravel/Blade app over the LAN.
  2. NativePHP app runs locally and communicates with a central Laravel API.
  3. Continue with a LAN browser/PWA if an installer is not essential.
- Decision criteria: reuse of current Blade flows, login/session compatibility, uploads/downloads, offline-LAN behavior, security, installer quality, and maintenance burden.
- Rule: Do not make broad architecture changes until one option passes the proof-of-concept criteria in `ARCHITECTURE.md`.

## ADR-003 — Database choice
- Status: Accepted for the initial release.
- Decision: Keep MySQL as the authoritative shared database on the host.
- Reason: The project needs shared records across computers. A separate SQLite database on each client would require a synchronization system and introduce conflict-resolution work.
- Consequence: Keep database credentials on the host. Clients interact through Laravel only.
