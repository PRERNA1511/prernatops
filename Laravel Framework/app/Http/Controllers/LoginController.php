<?php

namespace App\Http\Controllers;




use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Validation
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to login
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->intended('home'); // Redirect to dashboard or home
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }
}
