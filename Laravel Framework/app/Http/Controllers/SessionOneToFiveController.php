<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionOneToFiveController extends Controller
{
    /**
     * Session 1: Introduction to Laravel & MVC Architecture.
     */
    public function session1()
    {
        $phpVersion = PHP_VERSION;
        $laravelVersion = app()->version();

        $artisanCommands = [
            'php artisan serve' => 'Starts the local PHP development server',
            'php artisan make:controller [Name]' => 'Generates a new controller class',
            'php artisan make:model [Name] -m' => 'Creates an Eloquent model with migration',
            'php artisan migrate' => 'Runs all outstanding database migrations',
            'php artisan db:seed' => 'Populates database tables with seed data',
            'php artisan route:list' => 'Lists all registered application routes',
        ];

        return view('assignment.sessions.session01', compact('phpVersion', 'laravelVersion', 'artisanCommands'));
    }

    /**
     * Session 2: Routing, Parameters, Constraints, Named Routes, Route Groups.
     */
    public function session2(Request $request)
    {
        $submittedData = session('session2_result');
        return view('assignment.sessions.session02', compact('submittedData'));
    }

    /**
     * Demonstration of route with parameter and constraint.
     */
    public function session2UserParam($id)
    {
        return redirect()->route('session.02')->with('session2_result', "Successfully matched numeric parameter route: User ID = {$id}");
    }

    /**
     * Demonstration of POST request handling in Session 2.
     */
    public function session2Post(Request $request)
    {
        $name = $request->input('name', 'Anonymous');
        $role = $request->input('role', 'Student');
        return redirect()->route('session.02')->with('session2_result', "POST Route Success! Received Name: {$name}, Role: {$role}");
    }

    /**
     * Session 3: Controllers and Passing Data to Blade Views.
     */
    public function session3()
    {
        // 1. Primitive variables
        $instructorName = 'Prof. Sharma';
        $courseModule = 'PHP & Laravel Web Framework';
        $semester = 4;

        // 2. Array of items
        $topicsCovered = [
            'HTTP Request & Response Lifecycle',
            'MVC Separation of Concerns',
            'Controller Action Methods',
            'Passing Data with Compact and With methods',
            'Blade View Rendering Engine',
        ];

        // 3. Associative array
        $courseStats = [
            'Total Students' => 45,
            'Practical Sessions' => 25,
            'Mini Projects' => 1,
            'Passing Grade' => '75%',
        ];

        return view('assignment.sessions.session03', compact('instructorName', 'courseModule', 'semester', 'topicsCovered', 'courseStats'));
    }

    /**
     * Session 4: Blade Syntax, Loops, Conditions, Inheritance.
     */
    public function session4()
    {
        $isLoggedIn = true;
        $userRole = 'editor';
        $score = 88;

        $items = [
            ['title' => 'Laravel Introduction', 'status' => 'Done', 'score' => 95],
            ['title' => 'Routing & Controllers', 'status' => 'Done', 'score' => 90],
            ['title' => 'Blade Templating', 'status' => 'In Progress', 'score' => 88],
            ['title' => 'Eloquent ORM', 'status' => 'Pending', 'score' => 0],
        ];

        $emptyList = [];

        return view('assignment.sessions.session04', compact('isLoggedIn', 'userRole', 'score', 'items', 'emptyList'));
    }

    /**
     * Session 5: Request Handling, Forms, CSRF, Inline Validation, Flash Messages.
     */
    public function session5()
    {
        return view('assignment.sessions.session05');
    }

    /**
     * Process Session 5 Form submission with validation and CSRF verification.
     */
    public function session5Submit(Request $request)
    {
        $validated = $request->validate([
            'student_name' => 'required|string|min:3|max:50',
            'student_email' => 'required|email',
            'feedback' => 'required|string|min:10|max:500',
        ]);

        return redirect()->route('session.05')->with('success', "Form successfully validated! Thank you, {$validated['student_name']}. Feedback recorded.");
    }
}
