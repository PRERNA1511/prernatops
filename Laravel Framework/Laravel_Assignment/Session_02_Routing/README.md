# Session 2: Routing, Parameters, Constraints & Route Groups

## Session Overview
Routing maps incoming HTTP requests (URLs and HTTP methods like GET, POST, PUT, DELETE) to specific controller action methods or closures. Session 2 demonstrates route parameters, constraints with regular expressions, named routes, and route groups.

---

## Practical Tasks & Implementation

### Task 1: Basic GET and POST Routes
- Defined in `routes/web.php` for handling GET page views and POST form submissions.

### Task 2: Route Parameters with Numeric Constraints
- Defined route with mandatory ID parameter:
  ```php
  Route::get('/session-02/user/{id}', [SessionOneToFiveController::class, 'session2UserParam'])
      ->whereNumber('id')
      ->name('session.02.user');
  ```
- Any non-numeric string passed to `{id}` returns an automatic 404 Not Found error by Laravel.

### Task 3: Route Groups with Prefix
- Grouped routes under `/session-02` prefix to avoid repeating URL segments:
  ```php
  Route::prefix('session-02')->group(function () {
      Route::get('/', [SessionOneToFiveController::class, 'session2'])->name('session.02');
      Route::get('/user/{id}', [SessionOneToFiveController::class, 'session2UserParam'])->whereNumber('id');
      Route::post('/post-demo', [SessionOneToFiveController::class, 'session2Post'])->name('session.02.post');
  });
  ```

### Task 4: Interactive Test Form for POST Requests
- Created a Blade form sending a POST request to `/session-02/post-demo` with `@csrf` token and displaying the received input upon redirect.

---

## Files Created & Referenced
- `routes/web.php` (Session 2 routes group)
- `app/Http/Controllers/SessionOneToFiveController.php` (`session2`, `session2UserParam`, `session2Post`)
- `resources/views/assignment/sessions/session02.blade.php`

---

## How to Test
1. Visit `http://localhost:8000/session-02`.
2. Click the parameter buttons (`/session-02/user/42`) to test numeric route parameters.
3. Submit the POST test form to verify POST routing and `@csrf` token validation.
