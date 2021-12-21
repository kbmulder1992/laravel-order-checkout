<?php

namespace App\Exceptions;

use Exception;

class CartAlreadyHasCouponApplied extends Exception
{
    public function __construct(string $message = 'Cart already has a coupon applied')
    {
        parent::__construct($message);
    }
}
