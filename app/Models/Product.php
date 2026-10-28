<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public const CATEGORIES = [
        'Graphic T-Shirts',
        'Plain T-Shirts',
        'Oversized T-Shirts',
        'Custom T-Shirts',
        'Shoes',
        'Bags',
        'Hats',
        'Headphones',
        'Watches',
        'Trousers',
    ];

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'original_price',
        'stock',
        'image',
        'gallery',
        'category',
        'color',
        'sizes',
        'rating',
        'review_count',
        'in_stock',
        'is_featured',
        'is_bestseller',
        'is_latest',
    ];

    protected $casts = [
        'stock' => 'integer',
        'in_stock' => 'boolean',
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'gallery' => 'array',
    ];

    public function isOutOfStock(): bool
    {
        return ($this->stock <= 0 || !$this->in_stock);
    }

    public function isLowStock(): bool
    {
        return (!$this->isOutOfStock() && $this->stock <= 10);
    }

    public function getSizesArrayAttribute()
    {
        if (empty($this->sizes)) {
            return ['Standard'];
        }
        return array_values(array_filter(array_map('trim', explode(',', $this->sizes))));
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getGalleryItemsAttribute(): array
    {
        $main = $this->image ?: '/images/products/tee-black.jpg';

        // 0. Custom database gallery saved by Admin for this product
        if (!empty($this->gallery) && is_array($this->gallery) && count($this->gallery) > 0) {
            $items = [
                ['image' => asset($main), 'label' => 'Main view', 'title' => $this->name],
            ];
            foreach ($this->gallery as $g) {
                if (is_array($g) && !empty($g['image'])) {
                    $items[] = [
                        'image' => str_starts_with($g['image'], 'http') ? $g['image'] : asset($g['image']),
                        'label' => $g['label'] ?? 'Angle view',
                        'title' => $g['title'] ?? ($g['label'] ?? 'View'),
                    ];
                } elseif (is_string($g) && !empty($g)) {
                    $items[] = [
                        'image' => str_starts_with($g, 'http') ? $g : asset($g),
                        'label' => 'Angle view',
                        'title' => 'Angle view',
                    ];
                }
            }
            return $items;
        }

        // 1. Smartwatch (Product 15 or newly uploaded smartwatch)
        if ($this->id == 15 || str_contains($this->image, '9d0ff1760b8a668ef63bc7adfd21a833')) {
            return [
                ['image' => asset($main), 'label' => 'Main view', 'title' => 'Smartwatch Front'],
                ['image' => asset('/images/products/smartwatch-angle.jpg'), 'label' => 'Side angle', 'title' => '4G SIM Tray & Crown'],
                ['image' => asset('/images/products/smartwatch-case.jpg'), 'label' => 'Charging box', 'title' => 'Wireless Dock & Package'],
                ['image' => asset('/images/products/smartwatch-wrist.jpg'), 'label' => 'On wrist', 'title' => 'Streetwear Fit'],
                ['image' => asset('/images/products/smartwatch-back.jpg'), 'label' => 'Sensor back', 'title' => 'Ceramic Biometrics'],
            ];
        }

        // 2. Chronos Titanium Chronograph Watch (Product 13)
        if ($this->id == 13 || ($this->category === 'Watches' && str_contains(strtolower($this->name), 'chronos'))) {
            return [
                ['image' => asset($main), 'label' => 'Main view', 'title' => 'Titanium Front'],
                ['image' => asset('/images/products/watch-angle.jpg'), 'label' => 'Dial angle', 'title' => '45° Dial Macro'],
                ['image' => asset('/images/products/watch-case.jpg'), 'label' => 'Collector box', 'title' => 'Luxury Presentation'],
                ['image' => asset('/images/products/watch-wrist.jpg'), 'label' => 'On wrist', 'title' => 'Streetwear Fit'],
                ['image' => asset('/images/products/watch-back.jpg'), 'label' => 'Caseback', 'title' => 'Machined Titanium'],
            ];
        }

        // 3. Studio Pro Wireless Headphones (Product 12)
        if ($this->id == 12 || ($this->category === 'Headphones' && str_contains(strtolower($this->name), 'studio pro'))) {
            return [
                ['image' => asset($main), 'label' => 'Main view', 'title' => 'Studio Front'],
                ['image' => asset('/images/products/headphone-angle.jpg'), 'label' => 'Angle view', 'title' => '3/4 Profile'],
                ['image' => asset('/images/products/headphone-case.jpg'), 'label' => 'Charging case', 'title' => 'Magnetic Pod'],
                ['image' => asset('/images/hero-editorial.jpg'), 'label' => 'Studio wear', 'title' => 'Editorial Fit'],
            ];
        }

        // 4. Kinetic Runner Sneakers (Product 9)
        if ($this->id == 9) {
            return [
                ['image' => asset($main), 'label' => 'Side profile', 'title' => 'Lateral View'],
                ['image' => asset('/images/lookbook-portrait.jpg'), 'label' => 'Street style', 'title' => 'Editorial Model'],
                ['image' => asset('/images/hero-editorial.jpg'), 'label' => 'Texture', 'title' => 'Sole & Mesh'],
            ];
        }

        // 5. Tactical Cargo Trousers (Product 14)
        if ($this->id == 14) {
            return [
                ['image' => asset($main), 'label' => 'Front fit', 'title' => 'Full Length'],
                ['image' => asset('/images/lookbook-portrait.jpg'), 'label' => 'Lookbook', 'title' => 'Urban Styling'],
                ['image' => asset('/images/hero-editorial.jpg'), 'label' => 'Craftsmanship', 'title' => 'Fabric Texture'],
            ];
        }

        // 6. Crossbody Bag (Product 10)
        if ($this->id == 10) {
            return [
                ['image' => asset($main), 'label' => 'Front view', 'title' => 'Ballistic Nylon'],
                ['image' => asset('/images/hero-editorial.jpg'), 'label' => 'Lifestyle', 'title' => 'Studio Fit'],
            ];
        }

        // 7. Streetwear Cap (Product 11)
        if ($this->id == 11) {
            return [
                ['image' => asset($main), 'label' => 'Front view', 'title' => 'Embroidered Cap'],
                ['image' => asset('/images/lookbook-portrait.jpg'), 'label' => 'Lookbook', 'title' => 'Model Styling'],
            ];
        }

        // Default: If user uploaded custom product without extra angles, show their own product image
        return [
            ['image' => asset($main), 'label' => 'Main view', 'title' => $this->name],
        ];
    }
}
