<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function userSignup(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'number' => 'required|numeric',
            'password' => 'required|confirmed|min:6',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Save profile photo
        $photoPath = $request->file('photo')->store('profile_photos', 'public');

        // Save user data
        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'number' => $request->number,
            'password' => Hash::make($request->password),
            'photo' => $photoPath,
        ]);

        return redirect()->route('home')->with('success', 'Signup Successful!');
    }

    // User Login
    public function userLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('user')->attempt($credentials)) {
            return redirect()->route('home');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    // Admin Login
    public function adminLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('dashboard');
        }

        return back()->withErrors(['email' => 'Invalid admin credentials']);
    }
}
