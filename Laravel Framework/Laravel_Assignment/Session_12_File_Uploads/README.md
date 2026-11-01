# Session 12: File Uploads, Validation & Storage

## Session Overview
Session 12 demonstrates handling multipart form data, validating file types and sizes, generating cryptographically secure unique filenames, storing files on Laravel's `public` disk, and serving images in an image gallery using `php artisan storage:link`.

---

## Practical Tasks & Implementation

### Task 1: Multipart Form
- Form configured with `enctype="multipart/form-data"` and POST method with `@csrf`.

### Task 2: File Validation & Storage
- Validation: `'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048'`.
- Unique filename generation using timestamp + unique identifier:
  ```php
  $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
  $path = $file->storeAs('gallery', $filename, 'public');
  ```

### Task 3: Public Storage Symlink
- Connected storage to web root via: `php artisan storage:link`.
- Files stored in `storage/app/public/gallery` are accessible via `asset('storage/gallery/' . $filename)`.

### Task 4: Image Gallery Display
- Dynamically retrieves files using `Storage::disk('public')->files('gallery')` and renders an image grid with captions.

---

## Files Created & Referenced
- `app/Http/Controllers/SessionElevenToFifteenController.php` (`session12`, `session12Upload`)
- `resources/views/assignment/sessions/session12.blade.php`
- `routes/web.php` (`/session-12`, `/session-12/upload`)
- `storage/app/public/gallery/`

---

## How to Test
1. Visit `http://localhost:8000/session-12`.
2. Choose an image file (PNG/JPG/WEBP < 2MB) and click "Upload Image".
3. The image is saved to `storage/app/public/gallery` and appears in the gallery grid.
