<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StockInventoryTest extends TestCase
{
    use RefreshDatabase;

    protected function getAdmin()
    {
        return User::create([
            'name' => 'Admin Manager',
            'email' => 'admin@test.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);
    }

    public function test_admin_can_update_numeric_stock_quantity()
    {
        $admin = $this->getAdmin();
        $product = Product::create([
            'name' => 'Heavyweight Streetwear Tee',
            'slug' => 'heavyweight-streetwear-tee',
            'description' => 'Heavyweight tee description',
            'price' => 35.00,
            'stock' => 20,
            'category' => 'Plain T-Shirts',
            'color' => 'Black',
            'sizes' => 'S,M,L',
            'image' => '/images/products/tee-black.jpg',
            'in_stock' => true,
        ]);

        $response = $this->actingAs($admin)->post("/admin/products/{$product->id}/update-stock", [
            'stock' => 50,
        ]);

        $response->assertSessionHas('success');
        $this->assertEquals(50, $product->fresh()->stock);
        $this->assertTrue($product->fresh()->in_stock);
    }

    public function test_setting_stock_to_zero_marks_as_stockout()
    {
        $admin = $this->getAdmin();
        $product = Product::create([
            'name' => 'Vintage Graphic Tee',
            'slug' => 'vintage-graphic-tee',
            'description' => 'Vintage tee description',
            'price' => 40.00,
            'stock' => 10,
            'category' => 'Graphic T-Shirts',
            'color' => 'Cream',
            'sizes' => 'M,L',
            'image' => '/images/products/tee-cream.jpg',
            'in_stock' => true,
        ]);

        $this->actingAs($admin)->post("/admin/products/{$product->id}/update-stock", [
            'stock' => 0,
        ]);

        $fresh = $product->fresh();
        $this->assertEquals(0, $fresh->stock);
        $this->assertFalse((bool) $fresh->in_stock);
        $this->assertTrue($fresh->isOutOfStock());
    }

    public function test_customer_cannot_add_stockout_product_to_cart()
    {
        $product = Product::create([
            'name' => 'Sold Out Tee',
            'slug' => 'sold-out-tee',
            'description' => 'Sold out item',
            'price' => 25.00,
            'stock' => 0,
            'category' => 'Plain T-Shirts',
            'color' => 'White',
            'sizes' => 'L',
            'image' => '/images/products/tee-white.jpg',
            'in_stock' => false,
        ]);

        $response = $this->post("/cart/add/{$product->id}", [
            'size' => 'L',
            'quantity' => 1,
        ]);

        $response->assertSessionHas('error');
        $this->assertEmpty(session('cart', []));
    }

    public function test_checkout_decrements_stock_and_marks_stockout_when_zero()
    {
        $product = Product::create([
            'name' => 'Limited Drop Tee',
            'slug' => 'limited-drop-tee',
            'description' => 'Limited edition item',
            'price' => 30.00,
            'stock' => 2,
            'category' => 'Custom T-Shirts',
            'color' => 'Sage',
            'sizes' => 'L',
            'image' => '/images/products/tee-sage.jpg',
            'in_stock' => true,
        ]);

        // Place 2 items in cart
        $cartKey = "{$product->id}_L_sage";
        session(['cart' => [
            $cartKey => [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'size' => 'L',
                'color' => 'Sage',
                'quantity' => 2,
            ]
        ]]);

        $user = User::create([
            'name' => 'Customer Test',
            'email' => 'customer@test.com',
            'password' => bcrypt('password123'),
            'role' => 'user',
        ]);

        $response = $this->actingAs($user)->post('/checkout', [
            'customer_name' => 'John Doe',
            'customer_email' => 'john@example.com',
            'customer_phone' => '+123456789',
            'shipping_address' => '123 Fashion Street',
            'city' => 'Phnom Penh',
            'postal_code' => '12000',
            'delivery_method' => 'Standard',
            'payment_method' => 'Cash on Delivery',
        ]);

        $response->assertRedirect();
        
        $fresh = $product->fresh();
        $this->assertEquals(0, $fresh->stock);
        $this->assertFalse((bool) $fresh->in_stock);
        $this->assertTrue($fresh->isOutOfStock());
    }
}
