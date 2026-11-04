<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->get('role', 'all');

        $query = User::withCount('orders')
            ->withSum('orders', 'total');

        if ($role === 'banned') {
            $query->where('status', 'banned');
        } elseif ($role && $role !== 'all') {
            $query->where('role', $role);
        }

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        $customers = $query->orderBy('id', 'desc')->paginate(15)->withQueryString();

        $roleCounts = [
            'all' => User::count(),
            'user' => User::where('role', 'user')->count(),
            'admin' => User::where('role', 'admin')->count(),
            'banned' => User::where('status', 'banned')->count(),
        ];

        return view('admin.customers.index', compact('customers', 'role', 'roleCounts'));
    }

    public function show($id)
    {
        $customer = User::with('orders.items')->findOrFail($id);
        $totalSpent = $customer->orders()->sum('total');
        return view('admin.customers.show', compact('customer', 'totalSpent'));
    }

    public function toggleStatus(Request $request, $id)
    {
        if (auth()->id() == $id) {
            return redirect()->back()->with('error', 'You cannot ban or block your own currently logged-in account (មិនអាច Block គណនី Admin ផ្ទាល់ខ្លួនបានទេ)!');
        }

        $customer = User::findOrFail($id);

        if ($customer->status === 'banned') {
            $customer->status = 'active';
            $customer->banned_at = null;
            $customer->ban_reason = null;
            $customer->save();

            return redirect()->back()->with('success', "គណនី '{$customer->name}' ({$customer->email}) ត្រូវបានដោះលែង / Unblock ជោគជ័យ (Account unblocked successfully).");
        } else {
            $reason = $request->input('reason', 'Blocked by store administrator');
            $customer->status = 'banned';
            $customer->banned_at = now();
            $customer->ban_reason = $reason;
            $customer->save();

            return redirect()->back()->with('success', "គណនី '{$customer->name}' ({$customer->email}) ត្រូវបាន Block / Ban ជោគជ័យ (Account blocked successfully).");
        }
    }

    public function statement($id)
    {
        $customer = User::with(['orders.items'])->findOrFail($id);
        $orders = $customer->orders()->with('items')->orderBy('created_at', 'desc')->get();
        $totalSpent = $orders->sum('total');
        $totalItems = $orders->sum(function($o) { return $o->items->sum('quantity'); });

        $storeInfo = [
            'name' => \App\Models\SiteSetting::get('store_name', 'THREADCRAFT Store'),
            'tagline' => \App\Models\SiteSetting::get('store_tagline', 'Premium Streetwear & Graphic T-Shirts'),
            'email' => \App\Models\SiteSetting::get('support_email', 'admin@tshirtstore.com'),
            'phone' => \App\Models\SiteSetting::get('phone', '+1 (800) 555-TEES'),
            'currency' => \App\Models\SiteSetting::get('currency', 'USD'),
            'address' => 'Studio 4A, Street 123, Sangkat Boeung Keng Kang 1, Phnom Penh, Cambodia',
        ];

        return view('admin.customers.statement', compact('customer', 'orders', 'totalSpent', 'totalItems', 'storeInfo'));
    }

    public function destroy($id)
    {
        if (auth()->id() == $id) {
            return redirect()->back()->with('error', 'You cannot delete your own currently logged-in account (មិនអាចលុបគណនី Admin ផ្ទាល់ខ្លួនដែលកំពុង Login បានទេ).');
        }

        $customer = User::findOrFail($id);
        $customerName = $customer->name;
        $customerEmail = $customer->email;

        // Clean up avatar image if custom upload exists
        if (!empty($customer->avatar) && file_exists(public_path($customer->avatar))) {
            @unlink(public_path($customer->avatar));
        }

        // Delete customer account
        $customer->delete();

        return redirect()->route('admin.customers.index')
            ->with('success', "Customer account '{$customerName}' ({$customerEmail}) has been deleted successfully (បានលុបគណនីអតិថិជនជោគជ័យ).");
    }
}
