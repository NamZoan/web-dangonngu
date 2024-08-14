<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */

    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }


    public function test_the_application_returns_a_successful_response(): void
    {
        // Tạo một sản phẩm giả lập
        $product = Product::factory()->create([
            'name' => 'Test Product',
            'price' => 10.99,
        ]);

        // Gửi request thêm sản phẩm vào giỏ hàng
        $response = $this->get(route('cart.add', ['id' => $product->id]));

        // Kiểm tra sản phẩm đã được thêm vào giỏ hàng
        $cartItems = session('cart');
        $this->assertCount(1, $cartItems);
        $this->assertEquals($product->id, $cartItems[0]['id']);
        $this->assertEquals($product->name, $cartItems[0]['name']);
        $this->assertEquals(1, $cartItems[0]['qty']);
        $this->assertEquals($product->price, $cartItems[0]['price']);

        // Kiểm tra được chuyển hướng đến trang giỏ hàng
        // $response->assertRedirect(route('cart.index'));
    }
}
