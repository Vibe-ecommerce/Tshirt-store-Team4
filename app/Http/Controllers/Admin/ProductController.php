<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $rawSearch = trim($request->search);
            // Clean up if search starts with '#' or 'id:' or 'id '
            $cleanId = preg_replace('/^(?:#|id\s*[:=\s]?\s*)/i', '', $rawSearch);
            $cleanId = trim($cleanId);

            $query->where(function ($q) use ($rawSearch, $cleanId) {
                $q->where('name', 'like', "%{$rawSearch}%")
                  ->orWhere('color', 'like', "%{$rawSearch}%")
                  ->orWhere('category', 'like', "%{$rawSearch}%")
                  ->orWhere('description', 'like', "%{$rawSearch}%")
                  ->orWhere('sizes', 'like', "%{$rawSearch}%");

                if (is_numeric($cleanId)) {
                    $q->orWhere('id', (int) $cleanId);
                }
            });
        }

        $products = $query->orderBy('id', 'desc')->paginate(12)->withQueryString();
        $categories = Product::CATEGORIES;

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Product::CATEGORIES;
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'color' => 'required|string|max:100',
            'sizes' => 'required|string',
            'description' => 'required|string',
            'image_url' => 'nullable|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:10240',
            'in_stock' => 'boolean',
            'is_featured' => 'boolean',
            'is_bestseller' => 'boolean',
            'is_latest' => 'boolean',
        ]);

        $stock = isset($validated['stock']) ? (int) $validated['stock'] : 25;
        $inStock = $stock > 0 && $request->has('in_stock');

        $imagePath = $request->input('image_url') ?: '/images/products/tee-black.jpg';

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $extension = $file->getClientOriginalExtension() ?: 'jpg';
            $safeBase = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
            $fileName = time() . '_' . ($safeBase ?: 'product') . '.' . $extension;
            
            $destination = public_path('images/products');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }
            $file->move($destination, $fileName);
            $imagePath = '/images/products/' . $fileName;
        }

        $gallery = [];
        if ($request->hasFile('gallery_files')) {
            $files = $request->file('gallery_files');
            $labels = $request->input('gallery_labels', []);
            $defaultLabels = ['Side angle', 'Charging box', 'On wrist', 'Sensor back', 'Detail view', 'Packaging'];

            foreach ($files as $i => $gFile) {
                if ($gFile && $gFile->isValid()) {
                    $ext = $gFile->getClientOriginalExtension() ?: 'jpg';
                    $safeBase = Str::slug(pathinfo($gFile->getClientOriginalName(), PATHINFO_FILENAME));
                    $gName = time() . '_' . $i . '_' . ($safeBase ?: 'gallery') . '.' . $ext;
                    $destination = public_path('images/products');
                    if (!file_exists($destination)) {
                        mkdir($destination, 0755, true);
                    }
                    $gFile->move($destination, $gName);

                    $lbl = !empty($labels[$i]) ? trim($labels[$i]) : ($defaultLabels[$i % count($defaultLabels)]);
                    $gallery[] = [
                        'image' => '/images/products/' . $gName,
                        'label' => $lbl,
                        'title' => $lbl,
                    ];
                }
            }
        }

        Product::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'category' => $validated['category'],
            'price' => $validated['price'],
            'original_price' => $validated['original_price'] ?? null,
            'stock' => $stock,
            'color' => $validated['color'],
            'sizes' => $validated['sizes'],
            'description' => $validated['description'],
            'image' => $imagePath,
            'gallery' => !empty($gallery) ? $gallery : null,
            'in_stock' => $inStock,
            'is_featured' => $request->has('is_featured'),
            'is_bestseller' => $request->has('is_bestseller'),
            'is_latest' => $request->has('is_latest'),
            'rating' => 5.0,
            'review_count' => 0,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully with image gallery and stock!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Product::CATEGORIES;
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'color' => 'required|string|max:100',
            'sizes' => 'required|string',
            'description' => 'required|string',
            'image_url' => 'nullable|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:10240',
        ]);

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $extension = $file->getClientOriginalExtension() ?: 'jpg';
            $safeBase = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
            $fileName = time() . '_' . ($safeBase ?: 'product') . '.' . $extension;
            
            $destination = public_path('images/products');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }
            $file->move($destination, $fileName);
            $product->image = '/images/products/' . $fileName;
        } elseif ($request->filled('image_url')) {
            $product->image = $request->input('image_url');
        }

        // Gallery handling
        $gallery = [];
        if ($request->has('existing_gallery_images')) {
            $existingImages = $request->input('existing_gallery_images', []);
            $existingLabels = $request->input('existing_gallery_labels', []);
            foreach ($existingImages as $idx => $img) {
                if (!empty($img)) {
                    $lbl = !empty($existingLabels[$idx]) ? trim($existingLabels[$idx]) : 'Angle view';
                    $gallery[] = [
                        'image' => $img,
                        'label' => $lbl,
                        'title' => $lbl,
                    ];
                }
            }
        }

        if ($request->hasFile('gallery_files')) {
            $files = $request->file('gallery_files');
            $labels = $request->input('gallery_labels', []);
            $defaultLabels = ['Side angle', 'Charging box', 'On wrist', 'Sensor back', 'Detail view', 'Packaging'];

            foreach ($files as $i => $gFile) {
                if ($gFile && $gFile->isValid()) {
                    $ext = $gFile->getClientOriginalExtension() ?: 'jpg';
                    $safeBase = Str::slug(pathinfo($gFile->getClientOriginalName(), PATHINFO_FILENAME));
                    $gName = time() . '_' . $i . '_' . ($safeBase ?: 'gallery') . '.' . $ext;
                    $destination = public_path('images/products');
                    if (!file_exists($destination)) {
                        mkdir($destination, 0755, true);
                    }
                    $gFile->move($destination, $gName);

                    $lbl = !empty($labels[$i]) ? trim($labels[$i]) : ($defaultLabels[$i % count($defaultLabels)]);
                    $gallery[] = [
                        'image' => '/images/products/' . $gName,
                        'label' => $lbl,
                        'title' => $lbl,
                    ];
                }
            }
        }

        if ($request->has('gallery_files') || $request->has('existing_gallery_images') || $request->has('gallery_updated')) {
            $product->gallery = !empty($gallery) ? $gallery : null;
        }

        $stock = isset($validated['stock']) ? (int) $validated['stock'] : $product->stock;

        $product->name = $validated['name'];
        $product->slug = Str::slug($validated['name']);
        $product->category = $validated['category'];
        $product->price = $validated['price'];
        $product->original_price = $validated['original_price'] ?? null;
        $product->stock = $stock;
        $product->color = $validated['color'];
        $product->sizes = $validated['sizes'];
        $product->description = $validated['description'];
        $product->in_stock = ($stock > 0 && $request->has('in_stock'));
        $product->is_featured = $request->has('is_featured');
        $product->is_bestseller = $request->has('is_bestseller');
        $product->is_latest = $request->has('is_latest');
        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }

    public function inventory()
    {
        $products = Product::orderBy('id', 'asc')->get();
        return view('admin.products.inventory', compact('products'));
    }

    public function toggleStock($id)
    {
        $product = Product::findOrFail($id);
        if ($product->in_stock) {
            $product->in_stock = false;
        } else {
            $product->in_stock = true;
            if ($product->stock <= 0) {
                $product->stock = 25;
            }
        }
        $product->save();

        $statusStr = $product->in_stock ? "In Stock ({$product->stock} units)" : "Stockout / Out of Stock";
        return redirect()->back()->with('success', "Stock status updated for {$product->name}: {$statusStr}.");
    }

    public function updateStock(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $validated = $request->validate([
            'stock' => 'required|integer|min:0',
        ]);

        $newStock = (int) $validated['stock'];
        $product->stock = $newStock;
        $product->in_stock = ($newStock > 0);
        $product->save();

        $statusMsg = $newStock > 0 
            ? "Stock updated to {$newStock} units for {$product->name}." 
            : "{$product->name} has been set to 0 and marked as Stockout.";

        return redirect()->back()->with('success', $statusMsg);
    }
}
