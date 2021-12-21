<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;

interface CartServiceInterface
{
    public function addItem(Cart $cart, Product $product, int $quantity): Cart;
    public function removeItem(Cart $cart, Product $product, int $quantity): Cart;
    public function applyCoupon(Cart $cart, Coupon $coupon): Cart;
    public static function calculateTotal(Cart $cart): float;
    public function completeCheckout(Cart $cart): Order;
}
