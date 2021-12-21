<?php

namespace App\Services;

use App\Events\OrderCreatedEvent;
use App\Exceptions\CartAlreadyHasCouponApplied;
use App\Exceptions\MustBeLoggedInToCompleteCheckoutException;
use App\Exceptions\NotEnoughProductStockException;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Providers\AuthServiceProvider;
use Illuminate\Support\Str;

class CartService implements CartServiceInterface
{
    public function addItem(Cart $cart, Product $product, int $quantity): Cart
    {
        $cartItem = CartItem::where(['cart_id' => $cart->id, 'product_id' => $product->id])->first();

        $this->assertProductHasEnoughStock($cart, $product, $quantity);

        if (empty($cartItem)) {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $quantity
            ]);
        } else {
            $cartItem->quantity = $cartItem->quantity + $quantity;
            $cartItem->save();
        }

        return $cart;
    }

    public function removeItem(Cart $cart, Product $product, int $quantity): Cart
    {
        $cartItem = CartItem::where(['cart_id' => $cart->id, 'product_id' => $product->id])->first();

        if (! empty($cartItem)) {
            if (0 >= ($cartItem->quantity - $quantity)) {
                $cartItem->delete();
            } else {
                $cartItem->quantity = $cartItem->quantity - $quantity;
                $cartItem->save();
            }
        }


        return $cart;
    }

    public function applyCoupon(Cart $cart, Coupon $coupon): Cart
    {
        if (! empty($cart->coupon)) {
            throw new CartAlreadyHasCouponApplied();
        }

        return $cart;
    }

    public static function calculateTotal(Cart $cart): float
    {
        $cart->refresh();

        $total = $cart->items->sum(function (CartItem $item) {
            $product = Product::where(['id' => $item->product_id])->first();

            return $product->price * $item->quantity;
        });

        if (! empty($cart->coupon)) {
            $total = max(0, $total - $cart->coupon->amount);
        }

        return $total;
    }

    public function completeCheckout(Cart $cart): Order
    {
        $customer = auth()->user();

        if (empty($customer)) {
            throw new MustBeLoggedInToCompleteCheckoutException();
        }

        $order = Order::create([
            'user_id' => $customer->id,
        ]);

        $cart->items->each(function (CartItem $cartItem) use ($order) {
            OrderItem::create([
                'order_id' => $order->id,
                '',
            ]);
        });

        $order->save();

        event(new OrderCreatedEvent($order));

        return $order;
    }

    public function getUsersCart(?string $cartKey): Cart
    {
        $cart = Cart::where(['user_key' => $cartKey])->with('items')->first();

        if (empty($cart)) {
            $cart = Cart::create([
                'user_key' => Str::uuid()->toString()
            ]);
            $cart->save();

            request()->session()->put('cartKey', $cart->user_key);
        }

        return $cart;
    }

    private function assertProductHasEnoughStock(Cart $cart, Product $product, int $quantity): void
    {
        $totalQuantity = $cart->items->sum(fn(CartItem $cartItem) => $cartItem->quantity) + $quantity;

        if (0 > ($product->stock - $totalQuantity)) {
            throw new NotEnoughProductStockException();
        }
    }
}
