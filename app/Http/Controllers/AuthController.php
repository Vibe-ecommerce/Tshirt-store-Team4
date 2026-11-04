<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\ResetPasswordOtpMail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
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
            if (Auth::user()->isBanned()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'គណនីរបស់អ្នកត្រូវបានផ្អាក ឬ Block ដោយ Admin (Your account has been suspended/blocked). សូមទាក់ទងមកកាន់ផ្នែក Support។',
                ]);
            }

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
            'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/'],
        ], [
            'name.required' => 'សូមបញ្ចូលឈ្មោះពេញរបស់អ្នក។',
            'email.required' => 'សូមបញ្ចូលអាសយដ្ឋានអ៊ីមែល។',
            'email.email' => 'ទម្រង់អ៊ីមែលមិនត្រឹមត្រូវឡើយ។',
            'email.unique' => 'អ៊ីមែលនេះមានគណនីរួចហើយ សូមចូលប្រើប្រាស់ (Sign In)។',
            'password.required' => 'សូមបញ្ចូលលេខសម្ងាត់។',
            'password.min' => 'លេខសម្ងាត់ត្រូវមានយ៉ាងតិច ៨ តួអក្សរ (At least 8 characters)។',
            'password.confirmed' => 'ការបញ្ជាក់លេខសម្ងាត់មិនត្រូវគ្នាឡើយ។',
            'password.regex' => 'លេខសម្ងាត់ត្រូវតែរឹងមាំ (Strong Password) ដោយរួមបញ្ចូលទាំងអក្សរ និងលេខ (Letters & Numbers)។',
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
                if ($user->isBanned()) {
                    session()->flash('error', 'គណនីរបស់អ្នកត្រូវបានផ្អាក ឬ Block ដោយ Admin (Your account has been suspended/blocked).');
                    return redirect()->route('login');
                }

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

    // ផ្ញើលេខកូដ OTP ៦ខ្ទង់ទៅកាន់ Gmail ពិតប្រាកដសម្រាប់ Reset Password
    public function sendResetOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $email = strtolower(trim($request->email));
        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'រកមិនឃើញគណនីដែលប្រើប្រាស់អ៊ីមែលនេះទេ (No account found with this email).'
            ], 404);
        }

        if ($user->isBanned()) {
            return response()->json([
                'success' => false,
                'message' => 'គណនីរបស់អ្នកត្រូវបានផ្អាក ឬ Block ដោយ Admin។ មិនអាចស្នើសុំ Reset Password បានទេ។'
            ], 403);
        }

        // បង្កើតលេខកូដ OTP ៦ខ្ទង់ចៃដន្យ (Random 6-digit number)
        $otp = (string) random_int(100000, 999999);

        // រក្សាទុកក្នុងតារាង password_reset_tokens
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            [
                'token' => $otp,
                'created_at' => now(),
            ]
        );

        $mailSent = false;
        $mailError = null;

        try {
            Mail::mailer('smtp')->to($email)->send(new ResetPasswordOtpMail($otp, $user->name));
            $mailSent = true;
        } catch (\Throwable $e) {
            Log::error('OTP Email Sending Error: ' . $e->getMessage());
            $mailError = $e->getMessage();
        }

        return response()->json([
            'success' => true,
            'message' => $mailSent 
                ? ('យើងបានផ្ញើលេខកូដ OTP ៦ខ្ទង់ ទៅកាន់អ៊ីមែល ' . $email . ' រួចរាល់ហើយ។ សូមពិនិត្យមើល Inbox ឬ Spam folder។')
                : ('ម៉ាស៊ីនបម្រើ Cloud បានបង្កើតលេខកូដសម្ងាត់ OTP សម្រាប់អ្នក។'),
            'email' => $email,
            'mail_sent' => $mailSent,
            'fallback_otp' => (!$mailSent || app()->environment('local')) ? $otp : null,
        ]);
    }

    // ផ្ទៀងផ្ទាត់លេខកូដ OTP និងផ្លាស់ប្តូរលេខសម្ងាត់ថ្មី (Verify OTP & Reset Password)
    public function verifyAndResetPassword(Request $request)
    {
        if ($request->has('otp')) {
            $request->merge([
                'otp' => preg_replace('/\s+/', '', (string) $request->otp),
            ]);
        }

        $request->validate([
            'email' => ['required', 'email'],
            'otp' => ['required', 'string', 'size:6'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/'],
        ], [
            'otp.required' => 'សូមបញ្ចូលលេខកូដ OTP ៦ខ្ទង់។',
            'otp.size' => 'លេខកូដ OTP ត្រូវតែមាន ៦ ខ្ទង់។',
            'password.required' => 'សូមបញ្ចូលលេខសម្ងាត់ថ្មី។',
            'password.min' => 'លេខសម្ងាត់ថ្មីត្រូវមានយ៉ាងតិច ៨ តួអក្សរ (At least 8 characters)។',
            'password.confirmed' => 'ការបញ្ជាក់លេខសម្ងាត់ថ្មីមិនត្រូវគ្នាឡើយ។',
            'password.regex' => 'លេខសម្ងាត់ថ្មីត្រូវតែរឹងមាំ (Strong Password) ដោយរួមបញ្ចូលទាំងអក្សរ និងលេខ (Letters & Numbers)។',
        ]);

        $email = strtolower(trim($request->email));
        $otp = trim($request->otp);

        $record = DB::table('password_reset_tokens')->where('email', $email)->first();

        if (!$record) {
            return response()->json([
                'success' => false,
                'message' => 'សំណើសុំ Reset Password មិនត្រឹមត្រូវ ឬបានផុតកំណត់ហើយ។ សូមស្នើសុំលេខកូដថ្មីម្តងទៀត។'
            ], 422);
        }

        // ពិនិត្យសុពលភាព ១៥ នាទី (15 Minutes Expiration)
        $createdAt = Carbon::parse($record->created_at);
        if ($createdAt->addMinutes(15)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();
            return response()->json([
                'success' => false,
                'message' => 'លេខកូដ OTP នេះបានផុតកំណត់រយៈពេល ១៥ នាទីហើយ។ សូមស្នើសុំលេខកូដថ្មីម្តងទៀត។'
            ], 422);
        }

        // ផ្ទៀងផ្ទាត់លេខកូដ OTP
        if (trim($record->token) !== $otp) {
            return response()->json([
                'success' => false,
                'message' => 'លេខកូដ OTP មិនត្រឹមត្រូវទេ! សូមពិនិត្យមើលលេខកូដនៅក្នុងអ៊ីមែលរបស់អ្នកឡើងវិញ។'
            ], 422);
        }

        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'រកមិនឃើញគណនីអ្នកប្រើប្រាស់នេះទេ។'
            ], 404);
        }

        // Update password with bcrypt hash
        $user->password = Hash::make($request->password);
        $user->save();

        // សម្អាត Token ដែលបានប្រើរួច
        DB::table('password_reset_tokens')->where('email', $email)->delete();

        // ចូលគណនីដោយស្វ័យប្រវត្តិ
        Auth::login($user);
        if ($request->hasSession()) {
            $request->session()->regenerate();
            session()->flash('success', 'លេខសម្ងាត់របស់អ្នកត្រូវបានផ្លាស់ប្តូរដោយជោគជ័យ!');
        }

        return response()->json([
            'success' => true,
            'message' => 'ប្តូរលេខសម្ងាត់បានជោគជ័យ! កំពុងចូលគណនីរបស់អ្នក...',
            'redirect' => $user->role === 'admin' ? route('admin.dashboard') : url('/'),
        ]);
    }
}