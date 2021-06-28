<?php

namespace App\Actions\Cart;

use App\Contracts\Cart\CartInterface;

abstract class CartAction
{
    protected $cart;

    public function __construct(CartInterface $cartInstance)
    {
        $this->cart = $cartInstance;
    }
}
