<?php

namespace App\Contracts\Cart;

use App\Contracts\Cartable;

interface AddsToCart
{
    public function add(Cartable $cartable, float $quantity);
}

