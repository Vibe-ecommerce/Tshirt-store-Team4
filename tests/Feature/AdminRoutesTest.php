<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminRoutesTest extends TestCase
{
    use RefreshDatabase;

    protected function getAdmin()
    {
        return User::firstOrCreate([
            'email' => 'admin@test.com',
        ], [
            'name' => 'Administrator',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);
    }

    public function test_guest_is_redirected_from_admin()
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/login');
    }

    public function test_admin_dashboard_renders()
    {
        $admin = $this->getAdmin();
        $response = $this->actingAs($admin)->get('/admin');
        $response->assertStatus(200);
    }

    public function test_admin_products_pages_render()
    {
        $admin = $this->getAdmin();
        $this->actingAs($admin)->get('/admin/products')->assertStatus(200);
        $this->actingAs($admin)->get('/admin/products/create')->assertStatus(200);
        $this->actingAs($admin)->get('/admin/inventory')->assertStatus(200);

        $product = Product::create([
            'name' => 'Test Tee',
            'slug' => 'test-tee',
            'description' => 'Test description',
            'price' => 29.99,
            'category' => 'Graphic Tees',
            'color' => 'Black',
            'sizes' => 'S,M,L',
            'image' => '/images/tees/black_minimal.jpg',
            'in_stock' => true,
        ]);

        $this->actingAs($admin)->get("/admin/products/{$product->id}/edit")->assertStatus(200);
    }

    public function test_admin_orders_pages_render()
    {
        $admin = $this->getAdmin();
        $this->actingAs($admin)->get('/admin/orders')->assertStatus(200);

        $order = Order::create([
            'order_number' => 'TC-TEST-1',
            'customer_name' => 'John Doe',
            'customer_email' => 'john@test.com',
            'customer_phone' => '+1 555-1234',
            'shipping_address' => '123 Test St',
            'city' => 'Test City',
            'postal_code' => '12345',
            'delivery_method' => 'Standard',
            'payment_method' => 'Stripe',
            'subtotal' => 50,
            'shipping_fee' => 5,
            'total' => 55,
            'status' => 'pending',
        ]);

        $this->actingAs($admin)->get("/admin/orders/{$order->id}")->assertStatus(200);
    }

    public function test_admin_customers_pages_render()
    {
        $admin = $this->getAdmin();
        $this->actingAs($admin)->get('/admin/customers')->assertStatus(200);

        $customer = User::create([
            'name' => 'Customer Joe',
            'email' => 'joe@customer.com',
            'password' => bcrypt('secret123'),
            'role' => 'user',
        ]);

        $this->actingAs($admin)->get("/admin/customers/{$customer->id}")->assertStatus(200);
    }

    public function test_admin_payments_page_renders()
    {
        $admin = $this->getAdmin();
        $this->actingAs($admin)->get('/admin/payments')->assertStatus(200);
    }

    public function test_admin_promotions_page_renders()
    {
        $admin = $this->getAdmin();
        $this->actingAs($admin)->get('/admin/promotions')->assertStatus(200);
    }

    public function test_admin_reviews_page_renders()
    {
        $admin = $this->getAdmin();
        $this->actingAs($admin)->get('/admin/reviews')->assertStatus(200);
    }

    public function test_admin_content_page_renders()
    {
        $admin = $this->getAdmin();
        $this->actingAs($admin)->get('/admin/content')->assertStatus(200);
    }

    public function test_admin_reports_page_renders()
    {
        $admin = $this->getAdmin();
        $this->actingAs($admin)->get('/admin/reports')->assertStatus(200);
    }

    public function test_admin_profile_page_renders()
    {
        $admin = $this->getAdmin();
        $this->actingAs($admin)->get('/admin/account/profile')->assertStatus(200);
    }

    public function test_admin_settings_all_tabs_render()
    {
        $admin = $this->getAdmin();
        foreach (['website', 'payment', 'shipping', 'notification', 'security'] as $tab) {
            $this->actingAs($admin)->get("/admin/settings?group={$tab}")->assertStatus(200);
        }
    }
}
