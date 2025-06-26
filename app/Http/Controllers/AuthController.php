<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
  public function showLoginForm(Request $request)
{
    if (Auth::check()) {
        $level = Auth::user()->level;

        // Arahkan sesuai level
        if ($level === 'admin') {
            return redirect()->route('dashboard');
        } elseif ($level === 'guide') {
            return redirect('/halamanguide');
        } elseif ($level === 'pelanggan') {
            return redirect('/customer/packages');
        } else {
            // Jika level tidak dikenali, logout dan kembali ke login
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/login')->withErrors(['email' => 'Level user tidak valid.']);
        }
    }

    return view('login');
}


     public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        $level = Auth::user()->level;

        if ($level === 'admin') {
            return redirect()->intended('/dashboard');
        } elseif ($level === 'guide') {
            return redirect()->intended('/halamanguide');
        } elseif ($level === 'pelanggan') {
            return redirect()->intended('/customer/packages');
        } else {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors(['email' => 'Level user tidak valid.']);
        }
    }

    // ✅ Error handling login gagal
    return back()->withInput()->withErrors([
        'email' => 'Incorrect email or password',
    ]);
}




   public function logout(Request $request)
{
    Auth::logout();

    // Invalidate session yang lama biar benar-benar bersih
    $request->session()->invalidate();

    // Regenerate token CSRF agar fresh session
    $request->session()->regenerateToken();

    return redirect('/login');
}

public function showRegisterForm()
{
    return view('register');
}


public function register(Request $request)
{
    try {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            // 'g-recaptcha-response'=>'recaptcha',
            'level'    => 'nullable|in:pelanggan',  // hanya pelanggan, nullable
        ]);

        // Jika level tidak diisi, set default 'pelanggan'
        $level = $validated['level'] ?? 'pelanggan';

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'level'    => $level,
        ]);

        Auth::login($user);

        // Redirect sesuai level
        if ($user->level === 'pelanggan') {
            return redirect('/customer/packages');
        } elseif ($user->level === 'guide') {
            return redirect('/halamanguide');
        }

        return redirect('/');

    } catch (\Exception $e) {
        Log::error('Register error: '.$e->getMessage());
        return back()->withInput()->withErrors(['register' => 'An error occurred while registering the account or verifying the captcha. Please try again.']);
    }
}





}
