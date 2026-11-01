# Session 6: Database Configuration & .env

## Session Overview
Session 6 explains database connectivity in Laravel, comparing `config/database.php` against `.env`, setting up MySQL credentials, understanding SQLite as a file-based alternative, and testing database connection health.

---

## Practical Tasks & Implementation

### Task 1: MySQL Configuration in .env
Example `.env` configuration for WAMP/XAMPP:
```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_assignment
DB_USERNAME=root
DB_PASSWORD=
```

### Task 2: Environment Variable Separation
- Sensitive credentials, API keys, and local environment variables stay in `.env` (which is excluded from Git via `.gitignore`).
- Default structures and fallback connection arrays reside in `config/database.php`.

### Task 3: Connection Health Verification
- Programmatically verified database connectivity in `SessionSixToTenController::session6()` using `DB::connection()->getPdo()`.

---

## Files Created & Referenced
- `.env` and `.env.example`
- `config/database.php`
- `app/Http/Controllers/SessionSixToTenController.php` (`session6()`)
- `resources/views/assignment/sessions/session06.blade.php`

---

## How to Test
1. Visit `http://localhost:8000/session-06`.
2. The page reports the current active driver, database host, active database file/name, and a verified connection status alert.
