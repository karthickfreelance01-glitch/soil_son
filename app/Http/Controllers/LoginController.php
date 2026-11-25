<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use DB;

use Carbon\Carbon;


class LoginController extends Controller
{
   public function login_form() {

     return view('auth.login');

   }

  public function register(Request $request)
{
    $data = [
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ];

    // Insert and get inserted ID
    $id = DB::table('user')->insertGetId($data);

    // Fetch the user model (needed for Auth::login)
    $user = User::find($id);

    // Login
    Auth::login($user);

    return redirect('/dashboard')->with('success', 'Registered & Logged in!');
}

    public function register_form() {

        return view('auth.register');
    }

   public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:4',
    ]);

    if (Auth::attempt($request->only('email', 'password'))) {
        $request->session()->regenerate();

        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->intended('dashboard')->with('success', 'Welcome Admin!');
        } elseif ($user->role === 'staff') {
            return redirect()->intended('dashboard')->with('success', 'Welcome Staff!');
        } else {
            return redirect()->intended('/home')->with('success', 'Welcome!');
        }
    }

    return back()->withErrors([
        'email' => 'Invalid credentials, please try again.',
    ])->onlyInput('email');
}



    // ✅ Logout Function
   public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('admin.login'); // SSWF: login page is /admin/login ("/" is the public website)
}

public function dashboard()
{    
      
    return view('dashboard');
}

public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = auth()->user();

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Current password is incorrect'
            ], 422);
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Password changed successfully'
        ]);
    }



}
