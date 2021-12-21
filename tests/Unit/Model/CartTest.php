<?php

namespace Tests\Unit\Model;

use App\Models\Cart;
use App\Services\CartServiceInterface;
use Tests\TestCase;

class CartTest extends TestCase
{
    private CartServiceInterface $cartService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cartService = $this->app->get(CartServiceInterface::class);
    }

    public function testCartServiceIsInstanceOfCartServiceInterface(): void
    {
        $this->assertInstanceOf(CartServiceInterface::class, $this->cartService);
    }

    public function testCreateCart(): void
    {
        $cart = Cart::factory()->create();

        $this->assertInstanceOf(Cart::class, $cart);
    }
}
