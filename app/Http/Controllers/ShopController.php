<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Filter by category
        $category = $request->get('category');
        if ($category && !in_array($category, ['all', 'All Products', 'All T-Shirts'], true)) {
            $catLower = strtolower(trim($category));
            $matchedCategory = collect(Product::CATEGORIES)->first(function ($c) use ($catLower) {
                $cLower = strtolower($c);
                return $cLower === $catLower 
                    || rtrim($cLower, 's') === rtrim($catLower, 's')
                    || ($catLower === 'watch' && $cLower === 'watches')
                    || ($catLower === 'watches' && $cLower === 'watch')
                    || ($catLower === 'pants' && $cLower === 'trousers')
                    || ($catLower === 'pant' && $cLower === 'trousers');
            });
            if ($matchedCategory) {
                $query->where('category', $matchedCategory);
                $category = $matchedCategory;
            } else {
                $query->where('category', $category);
            }
        } else {
            $category = null;
        }

        // Search query
        $search = $request->get('search');
        if ($request->filled('search')) {
            $trimmedSearch = trim($search);
            $query->where(function ($q) use ($trimmedSearch) {
                $q->where('name', 'like', "%{$trimmedSearch}%")
                  ->orWhere('category', 'like', "%{$trimmedSearch}%")
                  ->orWhere('description', 'like', "%{$trimmedSearch}%")
                  ->orWhere('color', 'like', "%{$trimmedSearch}%");
            });
        }

        // Sorting
        $sort = $request->get('sort', 'featured');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            case 'latest':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->orderBy('is_featured', 'desc')->orderBy('id', 'desc');
                break;
        }

        $products = $query->paginate(9)->withQueryString();

        $categories = array_merge(['All Products'], Product::CATEGORIES);

        return view('frontend.shop', compact('products', 'categories', 'category', 'sort', 'search'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        $relatedProducts = Product::where('id', '!=', $id)
            ->where('category', $product->category)
            ->limit(3)
            ->get();

        if ($relatedProducts->isEmpty()) {
            $relatedProducts = Product::where('id', '!=', $id)->limit(3)->get();
        }

        return view('frontend.product-detail', compact('product', 'relatedProducts'));
    }

    public function liveSearch(Request $request)
    {
        $q = trim($request->get('q', ''));
        if (mb_strlen($q) < 1) {
            return response()->json(['products' => [], 'total' => 0]);
        }

        $query = Product::query();

        // Search matching
        $query->where(function ($sub) use ($q) {
            $sub->where('name', 'like', "%{$q}%")
                ->orWhere('category', 'like', "%{$q}%")
                ->orWhere('color', 'like', "%{$q}%")
                ->orWhere('description', 'like', "%{$q}%");
        });

        $total = $query->count();
        $products = $query->orderBy('is_featured', 'desc')
            ->orderBy('id', 'desc')
            ->limit(6)
            ->get(['id', 'name', 'price', 'original_price', 'category', 'image', 'stock', 'in_stock']);

        $formatted = $products->map(function ($p) {
            return [
                'id' => $p->id,
                'name' => $p->name,
                'category' => $p->category,
                'image' => asset($p->image),
                'price' => '$' . number_format($p->price, 2),
                'original_price' => $p->original_price ? '$' . number_format($p->original_price, 2) : null,
                'in_stock' => $p->stock > 0 && $p->in_stock,
                'url' => route('product.detail', $p->id),
            ];
        });

        return response()->json([
            'products' => $formatted,
            'total' => $total,
            'view_all_url' => route('shop.index', ['search' => $q]),
        ]);
    }

    public function storeReview(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'reviewer_name' => 'required|string|max:100',
            'reviewer_email' => 'required|email|max:150',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:5|max:1000',
        ]);

        \App\Models\Review::create([
            'product_id' => $product->id,
            'reviewer_name' => $validated['reviewer_name'],
            'reviewer_email' => $validated['reviewer_email'],
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'status' => 'Approved',
        ]);

        // Recalculate product rating & count
        $approvedReviews = $product->reviews()->where('status', 'Approved')->get();
        if ($approvedReviews->count() > 0) {
            $product->rating = round($approvedReviews->avg('rating'), 1);
            $product->review_count = $approvedReviews->count();
            $product->save();
        }

        return redirect()->back()->with('success', 'Thank you! Your review has been submitted successfully.');
    }
}
