<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;  // Add this line
use PhpParser\Node\Stmt\Return_;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class PageController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function index()
    {
        return view('index');
    }

    public function about()
    {
        return view('about');
    }

    public function classes()
    {
        return view('classes');
    }

    public function contact()
    {
        return view('contact');
    }

    public function facility()
    {
        return view('facility');
    }

    public function team()
    {
        return view('team');
    }

    public function calltoAction()
    {
        return view('call-to-action');
    }

    public function appointment()
    {
        return view('appointment');
    }

    public function testimonial()
    {
        return view('testimonial');
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function signup()
    {
        return view('signup');
    }

    public function userSignup(Request $request)
    {
        // Validate the input
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Validating uploaded image
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        // Save uploaded photo
        $photoPath = $request->file('photo')->store('public/photos');

        // Create a new user in the database
        User::create([
            'photo' => $photoPath,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash the password
        ]);

        return redirect()->route('signup')->with('success', 'Account created successfully!');
    }

    // extra
    public function userSignin(Request $request)
    {
        // Validate the input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        // Attempt to log in the user
        if (Auth::guard('user')->attempt($request->only('email', 'password'))) {
            return redirect()->route('home')->with('success', 'Logged in successfully!');
        }

        return back()->withErrors(['email' => 'Invalid email or password.']);
    }

    public function logout()
    {
        Auth::guard('user')->logout();
        return redirect()->route('signup')->with('success', 'Logged out successfully!');
    }
}
