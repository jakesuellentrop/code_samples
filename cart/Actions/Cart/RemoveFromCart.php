<?php

namespace App\Actions\Cart;

use App\Contracts\Cart\RemovesFromCart;
use App\Exceptions\FmmException;

class RemoveFromCart extends CartAction implements RemovesFromCart
{
    public function yeet(int $id)
    {
        if (! $this->cart->has($id)) {
            throw new FmmException('Item not found in cart.');
        }

       return $this->cart->remove($id);
    }
}

