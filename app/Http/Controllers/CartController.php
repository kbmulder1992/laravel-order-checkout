<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Services\CartServiceInterface;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{
    private CartServiceInterface $cartService;

    public function __construct(CartServiceInterface $cartService)
    {
        $this->cartService = $cartService;
    }

    public function show(): Response
    {
        return response()->json($this->getCurrentUsersCart());
    }

    public function addItem(Cart $cart, Product $product): Response
    {
        $cart = $this->cartService->addItem($this->getCurrentUsersCart(), $product, request()->get('quantity', 1));

        $cart->refresh();

        return response()->json($cart);
    }

    public function removeItem(Cart $cart, Product $product): Response
    {
        $cart = $this->cartService->removeItem($this->getCurrentUsersCart(), $product, request()->get('quantity', 1));

        $cart->refresh();

        return response()->json($cart);
    }

    public function completeCheckout(): Response
    {
        $order = $this->cartService->completeCheckout($this->getCurrentUsersCart());

        return response()->json($order);
    }

    private function getCurrentUsersCart(): Cart
    {
        return $this->cartService->getUsersCart(request()->session()->get('cartKey'));
    }
}
