<?php

namespace App\Contracts;

interface Cartable
{
    public function item(float $quantity): array;
}

