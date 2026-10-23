<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Show the form for creating a new account.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Create a new account and log the user in.
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        $user = User::create([
            'username' => $request->validated('username'),
            'name' => $request->validated('username'),
            'password' => $request->validated('password'),
        ]);

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()
            ->route('dashboard')
            ->with('status', 'Je account is aangemaakt.');
    }
}
