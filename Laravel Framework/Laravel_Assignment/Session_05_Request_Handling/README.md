# Session 5: Request Handling, Forms & CSRF

## Session Overview
Session 5 covers the HTTP request lifecycle, receiving user data via `Illuminate\Http\Request`, protecting forms using `@csrf`, performing inline controller validation, repopulating old inputs, and flashing success alerts.

---

## Practical Tasks & Implementation

### Task 1: Building a Form with CSRF Protection
- HTML form containing `@csrf` token directive.
- Prevents cross-site request forgery attacks by verifying the CSRF session token.

### Task 2: Inline Controller Validation
- Invoked `$request->validate([...])` inside `SessionOneToFiveController::session5Submit()`:
  ```php
  $validated = $request->validate([
      'student_name'  => 'required|string|min:3|max:50',
      'student_email' => 'required|email',
      'feedback'      => 'required|string|min:10|max:500',
  ]);
  ```

### Task 3: Displaying Validation Errors
- Used `@error('field_name')` directives in Blade to display inline error text and apply `is-invalid` Bootstrap classes.
- Used `old('field_name')` helper to preserve user input on validation failure.

### Task 4: Flash Success Messages
- Stored temporary flash notification using `redirect()->with('success', '...')` and rendered in the master layout.

---

## Files Created & Referenced
- `app/Http/Controllers/SessionOneToFiveController.php` (`session5`, `session5Submit`)
- `resources/views/assignment/sessions/session05.blade.php`
- `routes/web.php` (`GET /session-05`, `POST /session-05/submit`)

---

## How to Test
1. Visit `http://localhost:8000/session-05`.
2. Try submitting the form empty to observe real-time validation error alerts.
3. Fill valid details (name, email, feedback > 10 characters) and submit to view the success message.
