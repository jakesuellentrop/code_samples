<?php

namespace App\Fmm\Cart;

use Darryldecode\Cart\CartCollection;

class PersistentCartStorage
{
    public function has($key)
    {
        return PersistentCartModel::find($key);
    }

    public function get($key)
    {
        if ($cart = $this->has($key)) {
            return new CartCollection($cart->cart_data);
        } else {
            return [];
        }
    }

    public function put($key, $value)
    {
        if ($cart = $this->has($key)) {
            $cart->cart_data = $value;
            $cart->save();
        } else {
            PersistentCartModel::create([
                'id'        => $key,
                'cart_data' => $value,
            ]);
        }
    }
}