<?php

namespace App\Fmm\Cart;

use Darryldecode\Cart\Cart as CartCart;

class Cart extends CartCart
{
    // The only reason for this subclass is so we can expose one method to retrieve the cart's session key
    public function getSessionKey()
    {
        return $this->sessionKey;
    }
}