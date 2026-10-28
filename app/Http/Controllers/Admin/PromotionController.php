<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index()
    {
        $promotions = Promotion::orderBy('id', 'desc')->get();
        return view('admin.promotions.index', compact('promotions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:promotions,code',
            'discount_percent' => 'required|integer|min:1|max:100',
            'min_spend' => 'nullable|numeric|min:0',
            'description' => 'nullable|string|max:255',
            'expires_at' => 'nullable|date',
            'status' => 'required|in:Active,Expired,Disabled',
        ]);

        Promotion::create([
            'code' => strtoupper(trim($validated['code'])),
            'discount_percent' => $validated['discount_percent'],
            'min_spend' => $validated['min_spend'] ?? 0,
            'description' => $validated['description'] ?? null,
            'expires_at' => $validated['expires_at'] ?? null,
            'status' => $validated['status'],
            'uses_count' => 0,
        ]);

        return redirect()->back()->with('success', 'Promotion code created successfully!');
    }

    public function update(Request $request, $id)
    {
        $promo = Promotion::findOrFail($id);

        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:promotions,code,' . $id,
            'discount_percent' => 'required|integer|min:1|max:100',
            'min_spend' => 'nullable|numeric|min:0',
            'description' => 'nullable|string|max:255',
            'expires_at' => 'nullable|date',
            'status' => 'required|in:Active,Expired,Disabled',
        ]);

        $promo->update([
            'code' => strtoupper(trim($validated['code'])),
            'discount_percent' => $validated['discount_percent'],
            'min_spend' => $validated['min_spend'] ?? 0,
            'description' => $validated['description'] ?? null,
            'expires_at' => $validated['expires_at'] ?? null,
            'status' => $validated['status'],
        ]);

        return redirect()->back()->with('success', 'Promotion updated successfully!');
    }

    public function toggleStatus($id)
    {
        $promo = Promotion::findOrFail($id);
        $promo->status = ($promo->status === 'Active') ? 'Disabled' : 'Active';
        $promo->save();

        return redirect()->back()->with('success', "Promotion '{$promo->code}' is now {$promo->status}.");
    }

    public function destroy($id)
    {
        $promo = Promotion::findOrFail($id);
        $promo->delete();
        return redirect()->back()->with('success', 'Promotion deleted successfully.');
    }
}
