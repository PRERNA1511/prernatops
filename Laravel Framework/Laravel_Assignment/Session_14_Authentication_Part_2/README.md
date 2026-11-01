# Session 14: Login Customization & Wishlist Protection

## Session Overview
Session 14 demonstrates customizing user login to allow authentication by either username or email address, session invalidation on logout, password resets, and protecting wishlist / favorite interactions so only authenticated users can save items.

---

## Practical Tasks & Implementation

### Task 1: Dual Login (Username or Email)
- Handled in `SessionElevenToFifteenController::session14Login()`:
  ```php
  $loginField = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
  Auth::attempt([$loginField => $credentials['login'], 'password' => $credentials['password']]);
  ```

### Task 2: Secure Session Logout
- Invalidates and regenerates the session token on logout:
  ```php
  Auth::logout();
  $request->session()->invalidate();
  $request->session()->regenerateToken();
  ```

### Task 3: Wishlist Protection Demonstration
- Route `/session-14/wishlist/{id}` checks `Auth::check()`.
- If a guest attempts to add an item to their wishlist, they are redirected with an authentication required warning.
- Authenticated users toggle items into the `playlist_likes` table.

---

## Files Created & Referenced
- `app/Http/Controllers/SessionElevenToFifteenController.php` (`session14`, `session14Login`, `session14Logout`, `session14ToggleWishlist`)
- `resources/views/assignment/sessions/session14.blade.php`
- `routes/web.php` (`/session-14`, `/session-14/login`, `/session-14/logout`, `/session-14/wishlist/{id}`)

---

## How to Test
1. Visit `http://localhost:8000/session-14`.
2. Login using username `student` and password `password123`.
3. Click "Add to Wishlist" on any playlist to save it to your account.
4. Click "Log Out" and try adding to wishlist again to observe guest protection.
