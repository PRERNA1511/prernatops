<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Session25Controller extends Controller
{
    /**
     * Session 25: Code Review, README, PHPDoc, Git, Version Tracking.
     */
    public function index()
    {
        $codeReviewChecklist = [
            'PSR-12 PHP Coding Standard' => [
                'status' => 'Passed',
                'notes' => 'Code follows standard indentation, class naming (PascalCase), method naming (camelCase), and visibility modifiers.',
            ],
            'DRY (Don\'t Repeat Yourself)' => [
                'status' => 'Passed',
                'notes' => 'Shared Blade layout, Form Request reusability, Eloquent relationships, and centralized API responses.',
            ],
            'Database Integrity & Foreign Keys' => [
                'status' => 'Passed',
                'notes' => 'Cascade deletes configured on foreign keys; relationships defined on Eloquent models.',
            ],
            'Security & Vulnerability Mitigation' => [
                'status' => 'Passed',
                'notes' => '@csrf directives on all POST forms, prepared statements for raw queries, automatic Blade HTML escaping against XSS.',
            ],
            'Form Request Validation' => [
                'status' => 'Passed',
                'notes' => 'Explicit validation rules on all user input, file size & mime restrictions on uploads.',
            ],
            'PHPDoc & Comments' => [
                'status' => 'Passed',
                'notes' => 'Comprehensive DocBlocks on all controller action methods, models, and migrations.',
            ],
        ];

        $gitSummary = [
            'Current Branch' => 'master',
            'Total Sessions Implemented' => 'Session 1 to Session 25',
            'Mini Project' => 'Session 24 Music Playlist Application',
            'Documentation' => 'Structured Markdown and task notes inside Laravel_Assignment/ directory',
        ];

        return view('assignment.sessions.session25', compact('codeReviewChecklist', 'gitSummary'));
    }
}
