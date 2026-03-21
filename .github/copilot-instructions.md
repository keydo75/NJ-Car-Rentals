# GitHub Copilot / AI Agent Instructions for NJ-Car-Rentals

## 🚀 Quick Start (most useful commands)

- **Setup (install everything)**: `composer setup` — installs PHP deps, creates `.env`, generates app key, runs migrations, installs Node deps, builds frontend.
- **Dev (full stack)**: `composer dev` — runs `php artisan serve`, queue listener, `php artisan pail` (live logs), and Vite dev server (concurrently). Requires `npm install -g concurrently`.
- **Tests**: `composer test` — clears config cache and runs the test suite (uses SQLite in-memory, see `phpunit.xml`).
- **Seed demo data**: `php artisan db:seed --class=NJCarRentalsSeeder` — creates Admin/Staff/Customer accounts + sample vehicles.
- **Windows setup**: Run `.\\setup-env.ps1` to configure XAMPP paths, install deps, and build frontend automatically.

## 🧭 Core Architecture

**Multi-tenant user model** (three separate tables + guards):
- `admins` (table) → `auth:admin` guard → `AdminLoginController` → `/admin/*` routes
- `staff` (table) → `auth:staff` guard → `StaffLoginController` → `/staff/*` routes  
- `customers` (table) → `auth:customer` guard → `CustomerLoginController` → `/customer/*` routes

Each guard is configured in `config/auth.php` and uses its own Eloquent model. This design separates role-specific fields (e.g., `admin_level`, `permissions` on Admin; `license_number` on Staff) and simplifies auth flows.

**Route structure** (see `routes/web.php`):
- Public routes: `/vehicles` (browsing), `/contact`, `/subscribe` (newsletter)
- Protected routes: `/admin/vehicles` (CRUD), `/staff/dashboard`, `/customer/profile`
- Lightweight API: `/api/gps`, `/api/messages`, `/api/transactions` (stateless endpoints in `app/Http/Controllers/Api/*`)

**Domain logic patterns**:
- Vehicle scopes: `Vehicle::forRent()->available()->paginate(12)` (defined in `app/Models/Vehicle.php`)
- Backward compatibility: `Vehicle` has both `image_url` and `image_path` accessors for legacy templates
- Relationships: `Vehicle` → `hasMany(Rental)`, `hasMany(Inquiry)`, `hasMany(GpsPosition)` via FK

## 🔐 Data Migrations (handle with care)

Critical migration sequence (Jan 11–25, 2026):
- `2026_01_11_095941_create_admins_table.php` + `staff` + `customers` — creates new role tables
- `2026_01_11_100451_migrate_users_to_separate_tables.php` — **critical**: splits legacy `users` into three tables, preserves IDs
- `2026_01_11_101710_migrate_users_with_existing_data.php` — migrates existing records, temporarily alters FK constraints (e.g., `license_number`)
- `2026_01_18_105040_drop_users_table.php` — removes legacy `users` table
- `2026_01_25_make_license_number_nullable.php` + `remove_license_from_customers.php` — cleans up schema inconsistencies

**When modifying user schema**: Update `database/seeders/NJCarRentalsSeeder.php` and add tests that verify migration logic. Seeders detect SQLite vs MySQL and disable FK checks as needed (SQLite has quirks).

## 📌 Project-Specific Conventions

**Authentication & guards**:
```php
// In controllers
Auth::guard('admin')->attempt(['email' => $email, 'password' => $password]);
Auth::guard('customer')->logout();

// In tests
$this->actingAs($admin, 'admin');  // Logs in as admin guard
```

**Model scopes (prefer over where-chains)**:
```php
Vehicle::forRent()->available()->paginate(12);  // Not: Vehicle::where('type', 'rental')->where('status', 'available')...
```

**API validation**: `GpsPositionController@store` validates `vehicle_id` exists. Seed test vehicles when testing GPS endpoints.

**Eloquent relationships**: Always use explicit foreign keys if non-standard. Example: `GpsPosition` belongs to `Vehicle` via `vehicle_id`.

## 🧪 Testing & CI

- **In-memory SQLite**: `phpunit.xml` sets `DB_CONNECTION=sqlite` and `DB_DATABASE=:memory:`. Migrations + seeders run per test suite.
- **Test structure**: `tests/Feature/*` for integration tests (controllers, auth), `tests/Unit/*` for model logic.
- **Auth in tests**: Use `$this->actingAs($user, 'guard_name')` to simulate logged-in state for any guard (admin/staff/customer).
- **If you add schema**: Update seeder (`database/seeders/NJCarRentalsSeeder.php`), add test cases, run `composer test` to validate.

## 🔧 Dev & Debugging

- **Real-time logs**: `php artisan pail --timeout=0` — streams all app activity live (useful during `composer dev`).
- **Full stack (Windows)**: `composer dev` runs server, queue, logs, and Vite all at once (requires `concurrently` globally installed).
- **Frontend tooling**: `npm run dev` (Vite dev server, TailwindCSS 4), `npm run build` (production minified build).
- **Quick checks**: 
  - `php artisan route:list` — see all routes + guards
  - `php artisan migrate:status` — check migration state
  - `php artisan tinker` — REPL for testing code snippets

## 🔎 Quick File Map

| Purpose | Files |
|---------|-------|
| Auth & routing | `routes/web.php`, `config/auth.php`, `app/Http/Controllers/{Admin,Staff,Customer}/Auth/LoginController.php` |
| Domain models | `app/Models/Vehicle.php`, `app/Models/{Admin,Staff,Customer}.php`, `app/Models/Rental.php`, `app/Models/GpsPosition.php` |
| Schema & seeding | `database/migrations/*`, `database/seeders/NJCarRentalsSeeder.php` |
| API endpoints | `app/Http/Controllers/Api/{GpsPositionController,MessageController,TransactionController}.php` |
| Tests | `tests/Feature/*`, `tests/Unit/*`, `phpunit.xml` |
| Frontend | `resources/js/*`, `resources/css/*`, `vite.config.js` |

## ✅ Checklist Before PRs

- [ ] **Schema changes**: Update `NJCarRentalsSeeder.php` (defensive checks for SQLite), add test coverage for migration logic.
- [ ] **Guard-aware auth**: Use `Auth::guard(...)` in controllers, `actingAs(..., 'guard')` in tests — never assume default guard.
- [ ] **Model scopes**: Use `Vehicle::forRent()->available()` instead of chained `where()` clauses.
- [ ] **Run tests locally**: `composer test` must pass (SQLite in-memory, same as CI).
- [ ] **Avoid legacy code**: Don't manually edit `migrate_users_to_separate_tables.php` or `migrate_users_with_existing_data.php` unless preserving historical data.
- [ ] **API validation**: Seed test vehicles before testing GPS/Message/Transaction endpoints.

---

**Last updated**: January 27, 2026 | Comprehensive and tested against current codebase state.
