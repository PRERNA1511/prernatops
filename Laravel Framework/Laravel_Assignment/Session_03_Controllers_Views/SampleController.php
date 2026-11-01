<?php

namespace LaravelAssignment\Session03;

use App\Http\Controllers\Controller;

class SampleController extends Controller
{
    /**
     * Demonstrate passing primitive, indexed, and associative data to Blade views.
     */
    public function showCourseDetails()
    {
        $instructorName = 'Prof. Sharma';
        $courseModule = 'PHP & Laravel Framework';
        $semester = 4;

        $topicsCovered = [
            'Request Lifecycle',
            'MVC Architecture',
            'Passing Data with compact()',
            'Blade View Rendering Engine',
        ];

        $courseStats = [
            'Total Students' => 45,
            'Total Sessions' => 25,
            'Passing Grade' => '75%',
        ];

        return view('assignment.sessions.session03', compact(
            'instructorName',
            'courseModule',
            'semester',
            'topicsCovered',
            'courseStats'
        ));
    }
}
