<?php

namespace App\Exceptions;

use Exception;

class MustBeLoggedInToCompleteCheckoutException extends Exception
{
    public function __construct($message = 'You must be logged in to complete a checkout')
    {
        parent::__construct($message);
    }
}
