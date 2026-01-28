<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Filier;

class AuthController extends Controller
{

    public function showRegisterForm()
    {
        return view('register');
    }


    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => [
                'required',
                'email',
                'regex:/^[A-Za-z0-9._%+-]+@uit\.ac\.ma$/'
            ],
            'password' => 'required|min:8|confirmed',
            'role' => 'required|string',
            'matricule' => 'nullable|string',
        ]);

        // Check if email already exists
        if (User::where('email', $request->email)->exists()) {
            return back()->withErrors(['email' => 'This email is already exist'])->withInput();
        }


        $name = $request->first_name . ' ' . $request->last_name;

        // Check matricule prefix and assign role accordingly
        $role = $request->role;
        if ($request->role === 'teatcher') {
            if (!$request->matricule || !Str::startsWith($request->matricule, 'TCH123@FacultyEdu')) {
                return back()->withErrors(['matricule' => 'invalid matricule for teatcher'])->withInput();
            } else {
                $role = 'teatcher';
            }
        }



        $user = User::create([
            'first_name'     => $request->first_name,
            'last_name'      => $request->last_name,
            'email'           => $request->email,
            'role'            => $role,
            'matricule'       => $request->matricule,
            'password'        => Hash::make($request->password),
        ]);

        Auth::login($user);
        return redirect()->route('achivement')->with('success', 'Registration successful');
    }


    public function courses()
    {

        return redirect()->route('courses.index');
    }


    // Show the login form
    public function showLoginForm()
    {
        return view('login');
    }

    // Handle login POST
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            // Redirect based on user role
            // if (Auth::user()->role == 'student') {
            //     return redirect()->route('student.dashboard');
            // } elseif (Auth::user()->role == 'teatcher') {
            //     return redirect()->route('teatcher.courses');
            // }

            return redirect()->intended('achivement')->with('success', 'Welcome back!');
        }

        return back()->withErrors([
            'login_error' => 'Incorrect email or password.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if (Filier::count() > 0) {
            return redirect('/')->with('success', 'You logged out successfully');
        } else {
            return redirect('/');
        }
    }
}
