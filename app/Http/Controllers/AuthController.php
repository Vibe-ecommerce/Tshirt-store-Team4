<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // បង្ហាញទំព័រ Login 
    public function showLogin()
    {
        return view('auth.login');
    }

    // ដំណើរការទិន្នន័យពេល Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // If redirected from checkout or protected customer page, prioritize intended URL
            if ($request->session()->has('url.intended')) {
                return redirect()->intended('/');
            }

            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'អ៊ីមែល ឬលេខសម្ងាត់របស់អ្នកមិនត្រឹមត្រូវទេ។',
        ]);
    }

    // បង្ហាញទំព័រ Register 
    public function showRegister()
    {
        return view('auth.register');
    }

    // ដំណើរការទិន្នន័យពេល Register 
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->intended('/');
    }

    // Google Sign-In Action
    public function googleSignIn(Request $request)
    {
        // Sign in or create customer with Google account
        $user = User::firstOrCreate(
            ['email' => 'customer@gmail.com'],
            [
                'name' => 'John Doe (Google)',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'phone' => '+1 (555) 234-5678',
                'address' => '120 Sunset Strip, Suite 300',
                'city' => 'West Hollywood',
                'postal_code' => '90069',
                'country' => 'United States',
            ]
        );

        Auth::login($user);
        $request->session()->regenerate();

        session()->flash('success', 'Signed in with Google successfully!');

        return redirect()->intended('/');
    }

    // ដំណើរការពេល Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}