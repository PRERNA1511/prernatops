# Session 1: Introduction to Laravel & MVC Architecture

## Session Overview
Session 1 introduces the Laravel PHP Web Framework, explaining why it is one of the most widely used web application frameworks, its design philosophy, architectural components, command-line tooling with Artisan, and directory organization.

---

## Practical Tasks & Implementation

### Task 1: Environment Verification
- **PHP Version Installed:** PHP 8.2.26
- **Laravel Framework Version:** Laravel Framework 9.52.18
- **Composer Version:** Composer 2.8.4
- **Verification Command:** `php artisan --version`

### Task 2: Folder Structure Inspection
- `app/`: Contains the core application code, including Models (`app/Models`) and HTTP Controllers/Middleware (`app/Http`).
- `bootstrap/`: Contains the framework bootstrap loader (`app.php`) and cache directories (`cache/`).
- `config/`: Contains all application configuration files (database, mail, services, session, etc.).
- `database/`: Contains database migrations, seeders, and model factories.
- `public/`: The web root containing `index.php`, compiled assets, and uploaded public storage.
- `resources/`: Contains Blade views (`resources/views`), raw CSS, and JavaScript.
- `routes/`: Contains route definitions for web (`web.php`) and APIs (`api.php`).
- `storage/`: Contains application logs (`logs/laravel.log`), file session storage, and uploaded user files.

### Task 3: Artisan CLI Commands
Common Artisan commands used throughout the assignment:
- `php artisan serve` — Starts the local PHP development server.
- `php artisan make:controller [Name]` — Creates a new controller class.
- `php artisan make:model [Name] -m` — Generates an Eloquent model with a migration.
- `php artisan migrate` — Executes outstanding database migrations.
- `php artisan db:seed` — Runs database seeders to populate sample records.
- `php artisan route:list` — Displays a table of all registered application routes.

---

## Files Created & Referenced
- **Web Route:** `Route::get('/session-01', [SessionOneToFiveController::class, 'session1'])->name('session.01');` in `routes/web.php`
- **Controller Action:** `SessionOneToFiveController::session1()` in `app/Http/Controllers/SessionOneToFiveController.php`
- **Blade Template:** `resources/views/assignment/sessions/session01.blade.php`

---

## How to Test
1. Run `php artisan serve` or access `http://localhost:8000/session-01` in your browser.
2. The page displays the real-time environment status (PHP version, Laravel version, debug status) and an Artisan command reference table.
