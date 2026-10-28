<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        $featuredProducts = Product::where('is_featured', true)->take(4)->get();
        $latestProducts = Product::where('is_latest', true)->take(4)->get();
        $bestSellers = Product::where('is_bestseller', true)->take(4)->get();

        $categories = [
            [
                'name' => 'Graphic T-Shirts',
                'description' => 'Bold artistic prints & retro screen-printed visuals',
                'count' => Product::where('category', 'Graphic T-Shirts')->count(),
                'image' => '/images/products/tee-cream.jpg',
            ],
            [
                'name' => 'Plain T-Shirts',
                'description' => 'Heavyweight luxury everyday minimal essentials',
                'count' => Product::where('category', 'Plain T-Shirts')->count(),
                'image' => '/images/products/tee-white.jpg',
            ],
            [
                'name' => 'Oversized T-Shirts',
                'description' => 'Relaxed streetwear drape with mineral acid washes',
                'count' => Product::where('category', 'Oversized T-Shirts')->count(),
                'image' => '/images/products/tee-oversized.jpg',
            ],
            [
                'name' => 'Custom T-Shirts',
                'description' => 'Artisanal high-density embroidery & bespoke tees',
                'count' => Product::where('category', 'Custom T-Shirts')->count(),
                'image' => '/images/products/tee-sage.jpg',
            ],
            [
                'name' => 'Shoes',
                'description' => 'Urban streetwear sneakers, chunky soles & designer kicks',
                'count' => Product::where('category', 'Shoes')->count(),
                'image' => '/images/products/shoes-sneaker.jpg',
            ],
            [
                'name' => 'Bags',
                'description' => 'Tactical crossbody slings, tech packs & everyday utility',
                'count' => Product::where('category', 'Bags')->count(),
                'image' => '/images/products/bag-crossbody.jpg',
            ],
            [
                'name' => 'Hats',
                'description' => 'Vintage washed dad hats, structured caps & embroidered headwear',
                'count' => Product::where('category', 'Hats')->count(),
                'image' => '/images/products/hat-streetwear.jpg',
            ],
            [
                'name' => 'Headphones',
                'description' => 'Active noise cancelling, studio sound & audiophile craft',
                'count' => Product::where('category', 'Headphones')->count(),
                'image' => '/images/products/headphone-pro.jpg',
            ],
            [
                'name' => 'Watches',
                'description' => 'Minimalist automatic titanium chronographs & precision timepieces',
                'count' => Product::where('category', 'Watches')->count(),
                'image' => '/images/products/watch-chrono.jpg',
            ],
            [
                'name' => 'Trousers',
                'description' => 'Relaxed pleated tech trousers, wide-leg cargos & everyday twills',
                'count' => Product::where('category', 'Trousers')->count(),
                'image' => '/images/products/trousers-cargo.jpg',
            ],
        ];

        $homePromo = \App\Models\Promotion::where('status', 'Active')
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })
            ->latest()
            ->first();

        return view('frontend.home', compact('featuredProducts', 'latestProducts', 'bestSellers', 'categories', 'homePromo'));
    }

    public function about()
    {
        return view('frontend.about');
    }

    public function contact()
    {
        return view('frontend.contact');
    }

    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        return redirect()->back()->with('success', 'Thank you, ' . $validated['name'] . '! Your inquiry has been received. Our team will contact you within 24 hours.');
    }
}
