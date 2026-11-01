<?php

namespace App\Http\Controllers;

use App\Models\appointment;

use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'name' => 'required|string|max:255',    
            'email' => 'required|email|max:255',
            'number' => 'required|string|max:255',
            'mname' => 'string|max:255',
            'fname' => 'string|max:255',
            'cage' => 'required|integer|min:1|max:18',
            'message' => 'required|string',
        ]);
        Appointment::create($request->all());

        // Redirect with a success message
        return redirect()->back()->with('success', 'Message sent successfully!');
    }
}

