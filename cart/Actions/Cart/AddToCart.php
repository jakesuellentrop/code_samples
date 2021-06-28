<?php

namespace App\Actions\Cart;

use App\Contracts\Cart\AddsToCart;
use App\Contracts\Cartable;
use App\Exceptions\FmmException;

class AddToCart extends CartAction implements AddsToCart
{
    public function add(Cartable $cartable, float $quantity)
    {
        if ($this->cart->has($cartable->id)) {
            throw new FmmException("Item already in cart.");
        }

        $this->cart->add($cartable, $quantity);
    }
}
