<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    /**
     * Central assignment dashboard displaying Sessions 1 through 25.
     */
    public function index()
    {
        $sessions = [
            1 => ['title' => 'Introduction to Laravel', 'desc' => 'Framework installation, folder structure overview, Artisan CLI, and MVC architecture.', 'route' => 'session.01', 'status' => 'Completed'],
            2 => ['title' => 'Routing & Parameters', 'desc' => 'GET/POST routes, parameters, regular expression constraints, named routes, and route groups.', 'route' => 'session.02', 'status' => 'Completed'],
            3 => ['title' => 'Controllers & Views', 'desc' => 'Generating controllers, handling requests, and passing dynamic data to Blade templates.', 'route' => 'session.03', 'status' => 'Completed'],
            4 => ['title' => 'Blade Templating', 'desc' => 'Directives, loops, template inheritance (@extends, @section, @yield), and partial includes.', 'route' => 'session.04', 'status' => 'Completed'],
            5 => ['title' => 'Request Handling & Forms', 'desc' => 'HTTP request data, CSRF security token, form validation, error messages, and flash alerts.', 'route' => 'session.05', 'status' => 'Completed'],
            6 => ['title' => 'Database Configuration', 'desc' => 'MySQL database setup, .env file management, and database connection testing.', 'route' => 'session.06', 'status' => 'Completed'],
            7 => ['title' => 'Migrations & Schema', 'desc' => 'Creating tables, foreign keys, schema modifications, and migration rollback operations.', 'route' => 'session.07', 'status' => 'Completed'],
            8 => ['title' => 'Factories & Seeders', 'desc' => 'Faker library, model factories, database seeders, and populating realistic sample data.', 'route' => 'session.08', 'status' => 'Completed'],
            9 => ['title' => 'Eloquent CRUD & Debugbar', 'desc' => 'Model creation, Create-Read-Update-Delete operations, and Debugbar database query analysis.', 'route' => 'session.09', 'status' => 'Completed'],
            10 => ['title' => 'Eloquent Relationships', 'desc' => 'One-to-One, One-to-Many, Many-to-Many relationships, and solving N+1 with eager loading.', 'route' => 'session.10', 'status' => 'Completed'],
            11 => ['title' => 'Form Request Validation', 'desc' => 'Validation rules, custom error messages, and dedicated Form Request classes.', 'route' => 'session.11', 'status' => 'Completed'],
            12 => ['title' => 'File Uploads & Gallery', 'desc' => 'File validation, secure unique filenames, public storage disk, and image gallery display.', 'route' => 'session.12', 'status' => 'Completed'],
            13 => ['title' => 'Authentication (Part 1)', 'desc' => 'User registration with custom username, password hashing, and route protection.', 'route' => 'session.13', 'status' => 'Completed'],
            14 => ['title' => 'Authentication (Part 2)', 'desc' => 'Custom login, logout session invalidation, password reset, and wishlist protection.', 'route' => 'session.14', 'status' => 'Completed'],
            15 => ['title' => 'Advanced Eloquent', 'desc' => 'Query scopes, accessors, mutators, Query Builder methods, and safe raw SQL execution.', 'route' => 'session.15', 'status' => 'Completed'],
            16 => ['title' => 'Mail & Notifications', 'desc' => 'Mail configuration, Mailable classes, Markdown/Blade templates, and email logging.', 'route' => 'session.16', 'status' => 'Completed'],
            17 => ['title' => 'Events, Listeners & Queues', 'desc' => 'Event dispatching, asynchronous listeners, and background queued jobs.', 'route' => 'session.17', 'status' => 'Completed'],
            18 => ['title' => 'Middleware & Security', 'desc' => 'Custom role middleware, CSRF token verification, XSS escaping, and email verification.', 'route' => 'session.18', 'status' => 'Completed'],
            19 => ['title' => 'RESTful Playlist API', 'desc' => 'RESTful endpoints, JSON responses, standard HTTP status codes, and error handling.', 'route' => 'session.19', 'status' => 'Completed'],
            20 => ['title' => 'Sanctum API Tokens', 'desc' => 'Sanctum authentication, token generation, protected endpoints, token revocation, and logging.', 'route' => 'session.20', 'status' => 'Completed'],
            21 => ['title' => 'jQuery AJAX Frontend', 'desc' => 'Dynamic live song search with jQuery AJAX, JSON responses, loading spinners, and empty states.', 'route' => 'session.21', 'status' => 'Completed'],
            22 => ['title' => 'Performance Optimization', 'desc' => 'Route caching, config caching, query eager loading, column selection, and benchmarking.', 'route' => 'session.22', 'status' => 'Completed'],
            23 => ['title' => 'Deployment Preparation', 'desc' => 'Production environment checklist, migration automation, file permissions, and debug settings.', 'route' => 'session.23', 'status' => 'Completed'],
            24 => ['title' => 'Mini Project: Music Playlists', 'desc' => 'Complete full-stack Playlist web application with CRUD, cover images, likes, and email triggers.', 'route' => 'playlist.index', 'status' => 'Completed'],
            25 => ['title' => 'Code Review & Documentation', 'desc' => 'Code cleanliness review, PHPDoc documentation, Git version tracking, and master guide.', 'route' => 'session.25', 'status' => 'Completed'],
        ];

        return view('assignment.index', compact('sessions'));
    }
}
