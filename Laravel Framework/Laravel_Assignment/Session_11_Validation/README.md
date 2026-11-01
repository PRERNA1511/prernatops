# Session 11: Validation Rules, Custom Messages & Form Requests

## Session Overview
Session 11 covers advanced validation in Laravel, comparing inline `$request->validate()` with dedicated Form Request classes (`StorePlaylistRequest`), customizing validation error messages, and structuring clean controllers.

---

## Practical Tasks & Implementation

### Task 1: Dedicated Form Request Class
- Created `app/Http/Requests/StorePlaylistRequest.php` via `php artisan make:request StorePlaylistRequest`.
- Contains:
  - `authorize()`: Checks if user has permission to submit the form (`auth()->check()`).
  - `rules()`: Declares field validation requirements.
  - `messages()`: Customizes beginner-friendly error messages.

### Task 2: Validation Rules Used
- `required`: Field must not be empty.
- `min:3`, `max:100`: String length boundaries.
- `exists:genres,id`: Ensures the submitted genre ID exists in the database `genres` table.
- `image`: Verifies file is a genuine graphic image.
- `mimes:jpeg,png,jpg,webp`: Restricts accepted file extensions.
- `max:2048`: Limits file size to 2 megabytes.

### Task 3: Error Display in Blade
- Uses `@error('field_name')` and Bootstrap `is-invalid` classes to display red validation feedback borders and text directly under the invalid field.

---

## Files Created & Referenced
- `app/Http/Requests/StorePlaylistRequest.php`
- `app/Http/Controllers/SessionElevenToFifteenController.php` (`session11`, `session11Store`)
- `resources/views/assignment/sessions/session11.blade.php`

---

## How to Test
1. Visit `http://localhost:8000/session-11`.
2. Submit the form with an invalid single character title to see custom error messages like *"The playlist title must be at least 3 characters."*
3. Provide valid inputs and submit to see the success flash alert.
