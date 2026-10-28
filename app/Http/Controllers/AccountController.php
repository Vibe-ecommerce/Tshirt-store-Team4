<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $tab = $request->get('tab', 'profile');

        $orders = Order::with('items')->where('user_id', $user->id)->orderBy('created_at', 'desc')->get();

        $wishlistIds = Session::get('wishlist', []);
        $wishlistProducts = Product::whereIn('id', $wishlistIds)->get();

        $recommendedProducts = Product::where('in_stock', true)
            ->where('stock', '>', 0)
            ->whereNotIn('id', $wishlistIds)
            ->inRandomOrder()
            ->take(4)
            ->get();

        if ($recommendedProducts->isEmpty()) {
            $recommendedProducts = Product::where('in_stock', true)->where('stock', '>', 0)->take(4)->get();
        }

        return view('frontend.account', compact('user', 'tab', 'orders', 'wishlistProducts', 'recommendedProducts'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        if (isset($validated['phone'])) $user->phone = $validated['phone'];
        if (isset($validated['address'])) $user->address = $validated['address'];
        if (isset($validated['city'])) $user->city = $validated['city'];

        if ($request->hasFile('avatar')) {
            $avatarFile = $request->file('avatar');
            $fileName = 'avatar_' . $user->id . '_' . time() . '.' . $avatarFile->getClientOriginalExtension();
            $destinationPath = public_path('uploads/avatars');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $avatarFile->move($destinationPath, $fileName);
            $user->avatar = 'uploads/avatars/' . $fileName;
        }

        if ($request->boolean('remove_avatar')) {
            if ($user->avatar && file_exists(public_path($user->avatar))) {
                @unlink(public_path($user->avatar));
            }
            $user->avatar = null;
        }

        $user->save();

        return redirect()->route('account.index', ['tab' => 'profile'])->with('success', 'Profile and avatar updated successfully.');
    }

    public function updateAvatar(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
        ]);

        $avatarFile = $request->file('avatar');
        $fileName = 'avatar_' . $user->id . '_' . time() . '.' . $avatarFile->getClientOriginalExtension();
        $destinationPath = public_path('uploads/avatars');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }
        $avatarFile->move($destinationPath, $fileName);
        $user->avatar = 'uploads/avatars/' . $fileName;
        $user->save();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'avatar_url' => asset($user->avatar),
                'message' => 'Profile picture updated successfully!',
            ]);
        }

        return redirect()->route('account.index', ['tab' => 'profile'])->with('success', 'Profile picture updated successfully!');
    }

    public function updateAddress(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'phone' => 'nullable|string|max:30',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
        ]);

        $user->update([
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'],
            'city' => $validated['city'],
            'postal_code' => $validated['postal_code'] ?? null,
            'country' => $validated['country'] ?? 'United States',
        ]);

        return redirect()->route('account.index', ['tab' => 'addresses'])->with('success', 'Default shipping address updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->route('account.index', ['tab' => 'setting'])->with('error', 'Current password is not correct.');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('account.index', ['tab' => 'setting'])->with('success', 'Password updated successfully.');
    }
}
