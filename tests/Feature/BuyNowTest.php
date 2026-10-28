<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BuyNowTest extends TestCase
{
    use RefreshDatabase;

    public function test_buy_now_route_adds_product_to_cart_and_redirects_to_checkout()
    {
        $user = User::create([
            'name' => 'John Buyer',
            'email' => 'buyer@example.com',
            'password' => bcrypt('password123'),
            'role' => 'user',
        ]);

        $product = Product::create([
            'name' => 'Essential Heavyweight Oversized Tee',
            'slug' => 'essential-heavyweight-oversized-tee',
            'description' => 'Architectural cut streetwear tee.',
            'price' => 38.00,
            'stock' => 15,
            'category' => 'Custom T-Shirts',
            'color' => 'Obsidian Black',
            'sizes' => 'S,M,L,XL',
            'image' => '/images/products/tee-black.jpg',
            'in_stock' => true,
        ]);

        $response = $this->actingAs($user)->post(route('cart.buyNow', $product->id), [
            'size' => 'XL',
            'color' => 'Obsidian Black',
            'quantity' => 2,
        ]);

        $response->assertRedirect(route('checkout.index'));
        $response->assertSessionHas('success');

        $cart = session('cart', []);
        $this->assertNotEmpty($cart);

        $cartKey = "{$product->id}_XL_obsidianblack";
        $this->assertArrayHasKey($cartKey, $cart);
        $this->assertEquals(2, $cart[$cartKey]['quantity']);
        $this->assertEquals('XL', $cart[$cartKey]['size']);
        $this->assertEquals(38.00, $cart[$cartKey]['price']);
    }

    public function test_buy_now_with_action_param_redirects_to_checkout()
    {
        $user = User::create([
            'name' => 'Jane Buyer',
            'email' => 'jane@example.com',
            'password' => bcrypt('password123'),
            'role' => 'user',
        ]);

        $product = Product::create([
            'name' => 'Minimalist Acid Wash Tee',
            'slug' => 'minimalist-acid-wash-tee',
            'description' => 'Acid wash streetwear drop.',
            'price' => 42.00,
            'stock' => 10,
            'category' => 'Custom T-Shirts',
            'color' => 'Charcoal',
            'sizes' => 'M,L',
            'image' => '/images/products/tee-cream.jpg',
            'in_stock' => true,
        ]);

        $response = $this->actingAs($user)->post(route('cart.add', $product->id), [
            'action' => 'buy_now',
            'size' => 'M',
            'quantity' => 1,
        ]);

        $response->assertRedirect(route('checkout.index'));
    }

    public function test_buy_now_cannot_purchase_out_of_stock_product()
    {
        $product = Product::create([
            'name' => 'Sold Out Archived Tee',
            'slug' => 'sold-out-archived-tee',
            'description' => 'Archived item.',
            'price' => 50.00,
            'stock' => 0,
            'category' => 'Graphic T-Shirts',
            'color' => 'White',
            'sizes' => 'L',
            'image' => '/images/products/tee-cyberpunk.jpg',
            'in_stock' => false,
        ]);

        $response = $this->post(route('cart.buyNow', $product->id), [
            'size' => 'L',
            'quantity' => 1,
        ]);

        $response->assertSessionHas('error');
        $this->assertEmpty(session('cart', []));
    }
}
