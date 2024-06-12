<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // Show registration form
    public function register(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('users.register');
    }

    // Create new user
    public function create(Request $request): Application|Redirector|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        $form = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => 'required|confirmed|min:6',
        ]);

        // Password hashing
        $form['password'] = bcrypt($form['password']);

        // Create user
        $user = User::create($form);

        // Login
        auth()->login($user);

        return redirect()->route('home')->with('message', 'User created and logged in!');
    }

    // Show login form
    public function login(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('users.login');
    }

    // Authenticate user
    public function authenticate(Request $request): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $form = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required',
        ]);

        if (auth()->attempt($form)) {
            $request->session()->regenerate();

            return redirect()->route('home')->with('message', 'Login successful!');
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->onlyInput('email');
    }

    // Logout
    public function logout(Request $request): Application|Redirector|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('message', 'You have been logged out!');
    }
}
