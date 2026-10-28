<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status');
        $query = Review::with('product')->orderBy('created_at', 'desc');

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        $reviews = $query->paginate(12)->withQueryString();

        $counts = [
            'All' => Review::count(),
            'Approved' => Review::where('status', 'Approved')->count(),
            'Pending' => Review::where('status', 'Pending')->count(),
            'Hidden' => Review::where('status', 'Hidden')->count(),
        ];

        return view('admin.reviews.index', compact('reviews', 'status', 'counts'));
    }

    public function updateStatus(Request $request, $id)
    {
        $review = Review::findOrFail($id);
        $review->status = $request->input('status', 'Approved');
        $review->save();

        return redirect()->back()->with('success', "Review updated to {$review->status}.");
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();
        return redirect()->back()->with('success', 'Review deleted successfully.');
    }
}
