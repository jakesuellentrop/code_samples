<?php

namespace App\Actions\Cart;

use App\Contracts\Cart\DestroysCart;

class DestroyCart extends CartAction implements DestroysCart
{
    public function destroy()
    {
        $this->cart->destroy();
    }
}
