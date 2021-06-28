<?php

namespace App\Actions\Cart;

use App\Contracts\Cart\UpdatesCart;
use App\Contracts\Cartable;

class UpdateCart extends CartAction implements UpdatesCart
{
    public function update(Cartable $cartable, float $quantity)
    {
        $this->cart->update($cartable->id, $cartable->item);
    }
}

