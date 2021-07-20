<?php

namespace App\Fmm\Cart\Contracts;

use App\Fmm\Cart\Cartable;

interface IsCartable
{
    public function cartable(float $quantity): Cartable;
}