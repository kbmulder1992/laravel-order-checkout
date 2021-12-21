<?php

namespace App\Exceptions;

use Exception;

class NotEnoughProductStockException extends Exception
{
    public function __construct($message = 'Product does not have the requested amount of stock')
    {
        parent::__construct($message);
    }
}
