<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role === 'parent') {
                return redirect()->route('parent.progress');
            }
            return redirect()->route('dashboard');
        }

        // 3 Key Logins requested: Admin, Therapist, Parent
        $threeLogins = [
            [
                'key' => 'admin',
                'role' => 'Administrator',
                'title' => 'Admin Login',
                'name' => 'Admin Director',
                'email' => 'admin@specialcare.com',
                'desc' => 'Full access: enquiries, admissions, reports, staff management',
                'color' => 'indigo',
                'badge' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
                'btn_bg' => 'bg-indigo-600 hover:bg-indigo-700 text-white',
            ],
            [
                'key' => 'therapist',
                'role' => 'Therapist',
                'title' => 'Therapist Login',
                'name' => 'Dr. Priya Sharma',
                'email' => 'priya@specialcare.com',
                'desc' => 'Diagnostics, CARS evaluations, IEP goals, clinical SOAP notes',
                'color' => 'teal',
                'badge' => 'bg-teal-100 text-teal-800 border-teal-200',
                'btn_bg' => 'bg-teal-600 hover:bg-teal-700 text-white',
            ],
            [
                'key' => 'parent',
                'role' => 'Parent',
                'title' => 'Parent Login',
                'name' => 'Rajesh Gupta (Father of Aarav)',
                'email' => 'parent@specialcare.com',
                'desc' => 'Parent Progress Portal: milestones, daily care sheets, home therapy',
                'color' => 'purple',
                'badge' => 'bg-purple-100 text-purple-800 border-purple-200',
                'btn_bg' => 'bg-purple-600 hover:bg-purple-700 text-white',
            ],
        ];

        return view('auth.login', compact('threeLogins'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            if ($user->role === 'parent') {
                return redirect()->intended(route('parent.progress'))->with('success', "Welcome back, {$user->name}!");
            }

            return redirect()->intended(route('dashboard'))->with('success', "Welcome back, {$user->name}!");
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function quickLogin($email)
    {
        $user = User::where('email', $email)->first();
        if ($user) {
            Auth::login($user);
            request()->session()->regenerate();

            if ($user->role === 'parent') {
                return redirect()->route('parent.progress')->with('success', "Signed in as {$user->name} (Parent Portal)");
            }

            return redirect()->route('dashboard')->with('success', "Signed in as {$user->name} ({$user->role})");
        }

        return redirect()->route('login')->with('error', 'User account not found.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out. Sign in to view data.');
    }
}
