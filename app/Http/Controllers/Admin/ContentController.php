<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function index()
    {
        $settings = [
            'announcement_text' => SiteSetting::get('announcement_text', '✨ Free Worldwide Express Shipping on Orders Over $50 • 30-Day Hassle-Free Returns'),
            'hero_tagline' => SiteSetting::get('hero_tagline', 'Wear Your Everyday Story. Premium Crafted T-Shirts.'),
            'about_story' => SiteSetting::get('about_story', 'Founded in 2024, THREADCRAFT began as a revolt against paper-thin fast-fashion shirts that shrink and deform after two washes.'),
            'support_email' => SiteSetting::get('support_email', 'support@threadcraft.store'),
            'phone' => SiteSetting::get('phone', '+1 (800) 555-TEES'),
            'address' => SiteSetting::get('address', 'Studio 4A, Street 123, Sangkat Boeung Keng Kang 1, Khan Boeung Keng Kang, Phnom Penh, Cambodia'),
            // Editorial Campaign / Lookbook Banner Settings
            'lookbook_banner_image' => SiteSetting::get('lookbook_banner_image', '/images/hero-editorial.jpg'),
            'lookbook_badge' => SiteSetting::get('lookbook_badge', 'EDITORIAL CAMPAIGN / AW26'),
            'lookbook_title' => SiteSetting::get('lookbook_title', 'The Concrete Canvas.'),
            'lookbook_subtitle' => SiteSetting::get('lookbook_subtitle', 'Subversive Streetwear.'),
            'lookbook_desc' => SiteSetting::get('lookbook_desc', 'Engineered in our studio for the high-density urban landscape. Oversized drop-shoulder silhouettes meet brutalist architectural aesthetics.'),
            'lookbook_btn_text' => SiteSetting::get('lookbook_btn_text', 'Shop The Lookbook Collection →'),
            'lookbook_btn_url' => SiteSetting::get('lookbook_btn_url', '/shop'),
        ];

        $featuredProducts = Product::where('is_featured', true)->get();
        $allProducts = Product::all();

        return view('admin.content.index', compact('settings', 'featuredProducts', 'allProducts'));
    }

    public function update(Request $request)
    {
        $fields = [
            'announcement_text', 'hero_tagline', 'about_story', 'support_email', 'phone', 'address',
            'lookbook_badge', 'lookbook_title', 'lookbook_subtitle', 'lookbook_desc', 'lookbook_btn_text', 'lookbook_btn_url',
        ];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                SiteSetting::set($field, $request->input($field), 'content');
            }
        }

        // Handle Lookbook Banner Image Upload
        if ($request->hasFile('lookbook_image_file')) {
            $file = $request->file('lookbook_image_file');
            $extension = $file->getClientOriginalExtension() ?: 'jpg';
            $fileName = 'banner_' . time() . '.' . $extension;
            $destination = public_path('images/banners');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }
            $file->move($destination, $fileName);
            SiteSetting::set('lookbook_banner_image', '/images/banners/' . $fileName, 'content');
        } elseif ($request->filled('lookbook_banner_image')) {
            SiteSetting::set('lookbook_banner_image', $request->input('lookbook_banner_image'), 'content');
        }

        // Update featured products if submitted
        if ($request->has('featured_ids')) {
            $ids = $request->input('featured_ids', []);
            Product::query()->update(['is_featured' => false]);
            Product::whereIn('id', $ids)->update(['is_featured' => true]);
        }

        return redirect()->back()->with('success', 'Storefront content and homepage banner updated successfully!');
    }
}
