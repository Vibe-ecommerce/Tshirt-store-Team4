<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAccountController extends Controller
{
    public function profile()
    {
        $admin = Auth::user();
        return view('admin.account.profile', compact('admin'));
    }

    public function updateProfile(Request $request)
    {
        $admin = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $admin->id,
            'phone' => 'nullable|string|max:30',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
        ]);

        // Process avatar upload
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $fileName = 'admin_' . $admin->id . '_' . time() . '.' . ($file->getClientOriginalExtension() ?: 'png');
            $destPath = public_path('uploads/avatars');
            if (!file_exists($destPath)) {
                mkdir($destPath, 0755, true);
            }
            // Remove previous custom avatar if exists
            if ($admin->avatar && file_exists(public_path($admin->avatar)) && !str_contains($admin->avatar, 'default')) {
                @unlink(public_path($admin->avatar));
            }
            $file->move($destPath, $fileName);
            $admin->avatar = '/uploads/avatars/' . $fileName;
        } elseif ($request->filled('remove_avatar') && $request->input('remove_avatar') == '1') {
            if ($admin->avatar && file_exists(public_path($admin->avatar)) && !str_contains($admin->avatar, 'default')) {
                @unlink(public_path($admin->avatar));
            }
            $admin->avatar = null;
        }

        $admin->name = $validated['name'];
        $admin->email = $validated['email'];
        if ($request->has('phone')) {
            $admin->phone = $validated['phone'];
        }
        $admin->save();

        return redirect()->back()->with('success', 'Admin profile identity and credentials updated successfully (បានកែប្រែព័ត៌មានគណនីជោគជ័យ).');
    }

    public function updatePassword(Request $request)
    {
        $admin = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $admin->password)) {
            return redirect()->back()->with('error', 'Current password does not match.');
        }

        $admin->password = Hash::make($request->new_password);
        $admin->save();

        return redirect()->back()->with('success', 'Admin password changed successfully.');
    }
}
