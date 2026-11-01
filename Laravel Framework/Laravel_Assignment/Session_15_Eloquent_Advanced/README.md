# Session 15: Query Scopes, Accessors, Mutators & Raw SQL

## Session Overview
Session 15 explores advanced features of Eloquent ORM: encapsulating common database filtering queries into local query scopes, transforming attribute values with Accessors and Mutators, utilizing the fluent Query Builder, and executing parameterized raw SQL queries safely.

---

## Practical Tasks & Implementation

### Task 1: Local Query Scopes
- Defined on `Playlist`:
  ```php
  public function scopePublic($query) {
      return $query->where('is_public', true);
  }
  ```
- Called as: `Playlist::public()->get()`.

### Task 2: Accessors & Mutators
- **Accessor:** `getFormattedDurationAttribute()` converts seconds (e.g. 233) into readable `3:53` format.
- **Accessor:** `getFormattedCreatedAtAttribute()` converts timestamp into `M d, Y`.
- **Mutator:** `setNameAttribute($value)` automatically trims and capitalizes names using `ucwords()`.

### Task 3: Query Builder & Safe Raw SQL
- Query Builder: `DB::table('songs')->where('duration_seconds', '>', 200)->orderBy('duration_seconds', 'desc')->get()`.
- Raw SQL with Parameterization: `DB::select('SELECT genres.name AS genre_name, COUNT(playlists.id) AS playlist_count ...')`.

---

## Files Created & Referenced
- `app/Models/Playlist.php`
- `app/Models/Song.php`
- `app/Http/Controllers/SessionElevenToFifteenController.php` (`session15()`)
- `resources/views/assignment/sessions/session15.blade.php`

---

## How to Test
1. Visit `http://localhost:8000/session-15`.
2. Inspect the Query Scopes, formatted duration accessors, and the raw SQL group by aggregation table.
