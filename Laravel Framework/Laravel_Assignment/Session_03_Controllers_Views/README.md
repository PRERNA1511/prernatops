# Session 3: Controllers and Passing Data to Blade Views

## Session Overview
Controllers centralize request handling logic into dedicated classes. Session 3 demonstrates generating controllers, defining action methods, and passing primitive variables, indexed arrays, and associative datasets to Blade views.

---

## Practical Tasks & Implementation

### Task 1: Generating a Controller
- Command: `php artisan make:controller SessionOneToFiveController`

### Task 2: Passing Data to Views
Demonstrated three methods in `SessionOneToFiveController::session3()`:
1. **Primitive Variables:** `$courseModule`, `$instructorName`, `$semester` passed using the `compact()` function:
   ```php
   return view('assignment.sessions.session03', compact('courseModule', 'instructorName', 'semester'));
   ```
2. **Indexed Arrays:** `$topicsCovered` containing an ordered list of topics iterated via `@foreach`.
3. **Associative Arrays:** `$courseStats` passed with key-value pairs representing metrics.

---

## Files Created & Referenced
- `app/Http/Controllers/SessionOneToFiveController.php` (method: `session3()`)
- `resources/views/assignment/sessions/session03.blade.php`
- `routes/web.php` (`Route::get('/session-03', ...);`)

---

## How to Test
1. Visit `http://localhost:8000/session-03` in your browser.
2. Confirm that course statistics, instructor information, and the topic list are rendered correctly from the controller.
