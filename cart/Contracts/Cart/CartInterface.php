<?php

namespace App\Contracts\Cart;

use App\Contracts\Cartable;
use App\Contracts\Fulfillable;
use App\Models\Vendor;

interface CartInterface
{
    public function add(Cartable $cartable, float $quantity);

    public function destroy();

    public function fulfill(Fulfillable $fulfillment);

    public function fulfillments();

    public function has(int $id);

    public function hasCondition(string $name);

    public function hasProductsFrom(Vendor $vendor);

    public function items();

    public function remove(int $id);

    public function subtotal();

    public function update(Cartable $cartable, float $quantity);

    public function total();
}

