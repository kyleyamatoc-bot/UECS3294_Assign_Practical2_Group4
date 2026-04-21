<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = [
            'password' => $request->password,
        ];

        $login = $request->input('login');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $credentials[$field] = $login;

        if (!Auth::attempt($credentials)) {
            return back()->withInput()->withErrors(['login' => 'Invalid login credentials.']);
        }

        $request->session()->regenerate();

        return redirect()->route('home')->with('status', 'Welcome back!');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home')->with('status', 'Registration successful.');
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('home');
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        session(['password_reset_email' => $request->email]);

        return redirect()->route('auth.reset.show')->with('status', 'Email verified. Set your new password.');
    }

    public function showResetPassword()
    {
        $email = session('password_reset_email');
        if (!$email) {
            return redirect()->route('auth.forgot.show')->withErrors(['email' => 'Session expired. Please verify your email again.']);
        }

        return view('auth.reset-password', ['email' => $email]);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $email = session('password_reset_email');
        if (!$email) {
            return redirect()->route('auth.forgot.show')->withErrors(['email' => 'Session expired. Please verify your email again.']);
        }

        $user = User::where('email', $email)->firstOrFail();
        $user->password = Hash::make($request->password);
        $user->save();

        session()->forget('password_reset_email');

        return redirect()->route('auth.login.show')->with('status', 'Password reset successful. Please log in.');
    }
}
