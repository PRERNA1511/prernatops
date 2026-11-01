# Session 9: Eloquent CRUD & Debugbar Query Analysis

## Session Overview
Eloquent is Laravel's ActiveRecord Object-Relational Mapper (ORM). Each database table has a corresponding "Model" used to interact with that table. Session 9 demonstrates the fundamental CRUD operations (Create, Read, Update, Delete) and explains Laravel Debugbar's query inspection capabilities.

---

## Practical Tasks & Implementation

### Task 1: Eloquent Create
- Form submission calls `Playlist::create([...])` with mass-assignment protection using `$fillable`.

### Task 2: Eloquent Read
- Fetched all playlists using `Playlist::with('user', 'genre')->latest()->get()`.

### Task 3: Eloquent Update & Delete
- Updated records using `$playlist->update([...])`.
- Deleted records using `$playlist->delete()` via a DELETE route with confirmation.

### Task 4: Debugbar Queries Tab Demonstration
- Enabled Laravel query logging via `DB::enableQueryLog()` and `DB::getQueryLog()`.
- Displayed each executed SQL query statement, execution time in milliseconds, and parameter bindings.

---

## Files Created & Referenced
- `app/Models/Playlist.php`
- `app/Http/Controllers/SessionSixToTenController.php` (`session9`, `session9Store`, `session9Delete`)
- `resources/views/assignment/sessions/session09.blade.php`
- `routes/web.php` (`/session-09`, `/session-09/store`, `/session-09/delete/{id}`)

---

## How to Test
1. Visit `http://localhost:8000/session-09`.
2. Create a new playlist using the form on the left.
3. Observe the newly created playlist appear instantly in the table.
4. Delete a playlist using the red delete icon.
5. Review the Debugbar Queries table at the bottom showing exact SQL execution times.
