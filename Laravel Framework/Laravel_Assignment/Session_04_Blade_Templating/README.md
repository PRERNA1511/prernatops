# Session 4: Blade Templating Engine

## Session Overview
Blade is Laravel's lightweight templating engine. Unlike raw PHP views, Blade files are compiled into plain PHP and cached for performance. Session 4 demonstrates directives, template inheritance, loops, and loop control variables.

---

## Practical Tasks & Implementation

### Task 1: Conditional Directives
- `@if ($condition)`, `@elseif`, `@else`, `@endif` for multi-branch branching.
- `@unless ($condition)` which executes when the expression is false.

### Task 2: Loops & Loop Variables
- `@foreach ($items as $item)`
- Automatic `$loop` variable:
  - `$loop->iteration` (1-based counter)
  - `$loop->first` (boolean: is first iteration)
  - `$loop->last` (boolean: is last iteration)

### Task 3: Handling Empty Data with @forelse
- `@forelse ($list as $item) ... @empty ... @endforelse` to cleanly render an empty fallback view without nested `if (count > 0)` checks.

### Task 4: Template Inheritance
- `@extends('layouts.assignment')` inherits the master HTML shell.
- `@section('content')` injects content into `@yield('content')`.

---

## Files Created & Referenced
- `resources/views/layouts/assignment.blade.php` (Master layout)
- `resources/views/assignment/sessions/session04.blade.php`
- `app/Http/Controllers/SessionOneToFiveController.php` (`session4()`)
- `routes/web.php` (`/session-04`)

---

## How to Test
1. Visit `http://localhost:8000/session-04`.
2. Inspect the conditional badges, the `$loop` first/last flags in the table, and the `@forelse` empty state message.
