<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'min:4'],
        ]);

        if (! Auth::attempt($credentials)) {
            return back()->withErrors(['email' => 'Invalid credentials, please try again.'])->onlyInput('email');
        }

        $user = Auth::user();
        if (! $user->isActive()) {
            Auth::logout();
            return back()->withErrors(['email' => 'Your account is inactive. Please contact the admin.'])->onlyInput('email');
        }

        $request->session()->regenerate();

        // Same landing page as gh.hms: the hospital dashboard.
        return redirect()->intended(url('dashboard'))
            ->with('success', $user->isAdmin() ? 'Welcome Admin!' : 'Welcome '.$user->name.'!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'new_password'     => ['required', 'min:6', 'confirmed'],
        ]);

        $user = $request->user();
        if (! Hash::check($request->current_password, $user->password)) {
            return response()->json(['status' => false, 'message' => 'Current password is incorrect'], 422);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['status' => true, 'message' => 'Password changed successfully']);
    }
}
