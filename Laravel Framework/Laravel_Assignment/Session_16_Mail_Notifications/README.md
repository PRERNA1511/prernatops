# Session 16: Mail Configuration, Mailable Classes & Notifications

## Session Overview
Session 16 demonstrates configuring email drivers in Laravel, creating Mailable classes (`WelcomeNotificationMail`), designing responsive Blade email templates, sending emails with `Mail::to()->send()`, and inspecting rendered emails via the `log` driver.

---

## Practical Tasks & Implementation

### Task 1: Mail Configuration
- Configured `.env` with `MAIL_MAILER=log` and safe default sender addresses.
- During local development, using the `log` driver guarantees zero external SMTP failures or credential leaks while writing full email contents to `storage/logs/laravel.log`.

### Task 2: Dedicated Mailable Class
- Created `app/Mail/WelcomeNotificationMail.php` via `php artisan make:mail WelcomeNotificationMail`.
- Binds user model and custom message, rendering `resources/views/emails/welcome.blade.php`.

### Task 3: Sending Mail & Log Stream
- Dispatches email via `Mail::to($email)->send(new WelcomeNotificationMail($user, $message))`.
- Displays real-time log stream on the demo page.

---

## Files Created & Referenced
- `app/Mail/WelcomeNotificationMail.php`
- `resources/views/emails/welcome.blade.php`
- `app/Http/Controllers/SessionSixteenToEighteenController.php` (`session16`, `session16Send`)
- `resources/views/assignment/sessions/session16.blade.php`
- `storage/logs/laravel.log`

---

## How to Test
1. Visit `http://localhost:8000/session-16`.
2. Enter an email address and custom message, then click "Dispatch Mailable".
3. Check the "Mail Log Stream" card to verify the full RFC email headers and body.
