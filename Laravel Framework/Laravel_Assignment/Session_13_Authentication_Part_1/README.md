# Session 13: Authentication Setup & Custom Registration

## Session Overview
Session 13 covers the fundamental architecture of authentication in Laravel, implementing custom user registration with an extra `username` field, password hashing via `Hash::make()`, and checking authentication state.

---

## Practical Tasks & Implementation

### Task 1: Custom Registration with Username
- Migration updated `users` table to include `username` (unique) and `role` (default: 'user').
- Built registration form validating:
  - `name`: string, max 100
  - `username`: unique in `users`, alphanumeric, min 3 chars
  - `email`: unique in `users`, valid email
  - `password`: confirmed with `password_confirmation`, min 6 chars

### Task 2: Password Hashing & Immediate Login
- Saved user using `Hash::make($password)` to ensure passwords are encrypted with bcrypt before saving to the database.
- Immediately authenticated the newly registered user via `Auth::login($user)`.

### Task 3: Displaying Authentication State
- Rendered user badges and info cards when authenticated (`Auth::check()`, `Auth::user()`).

---

## Files Created & Referenced
- `app/Models/User.php`
- `app/Http/Controllers/SessionElevenToFifteenController.php` (`session13`, `session13Register`)
- `resources/views/assignment/sessions/session13.blade.php`
- `routes/web.php` (`/session-13`, `/session-13/register`)

---

## How to Test
1. Visit `http://localhost:8000/session-13`.
2. Fill out the registration form with a new username, email, and password.
3. Submit to authenticate and observe your profile appearing in the "Current Authentication State" card.
