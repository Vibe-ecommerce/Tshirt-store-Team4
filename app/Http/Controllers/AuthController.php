<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

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

    // Google Sign-In Action (Supports Real Google OAuth 2.0 via Socialite + Demo Fallback)
    public function googleSignIn(Request $request)
    {
        // If Google Client ID is configured, redirect to real Google OAuth
        if (!empty(config('services.google.client_id')) && !empty(config('services.google.client_secret'))) {
            return Socialite::driver('google')->redirect();
        }

        // Demo Fallback if keys are not set yet
        $user = User::firstOrCreate(
            ['email' => 'customer@gmail.com'],
            [
                'name' => 'John Doe (Google Demo)',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'phone' => '+855 12 345 678',
                'address' => 'Street 2004, Phnom Penh',
                'city' => 'Phnom Penh',
                'postal_code' => '12000',
                'country' => 'Cambodia',
            ]
        );

        Auth::login($user);
        $request->session()->regenerate();
        session()->flash('success', 'ចូលគណនីសាកល្បងដោយជោគជ័យ (Demo Google Mode)');
        return redirect()->intended('/');
    }

    // Google OAuth Callback (Handles Real Google Account Sign-In)
    public function googleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->getName() ?: 'Google User',
                    'email' => $googleUser->getEmail(),
                    'password' => Hash::make(Str::random(24)),
                    'role' => 'user',
                    'avatar' => $googleUser->getAvatar(),
                ]);
            } else {
                if ($googleUser->getAvatar() && empty($user->avatar)) {
                    $user->update(['avatar' => $googleUser->getAvatar()]);
                }
            }

            Auth::login($user, true);
            $request->session()->regenerate();

            session()->flash('success', 'ស្វាគមន៍! អ្នកបានចូលគណនីតាម Google ជោគជ័យ (' . $user->name . ')');
            return redirect()->intended('/');
        } catch (\Exception $e) {
            session()->flash('error', 'Google Sign-in failed: ' . $e->getMessage());
            return redirect()->route('login');
        }
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