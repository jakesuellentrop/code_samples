<?php

namespace App\Fmm\Cart\Contracts;

interface Fulfillable
{
    public function item(): array;
}

