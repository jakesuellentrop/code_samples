<?php

namespace App\Fmm\Cart\Contracts;

use App\Fmm\Cart\Cartable;
use App\Fmm\Cart\Contracts\Fulfillable;
use App\Models\User;
use App\Models\Vendor;

interface CartInterface
{
    public function add(Cartable $cartable);

    public function addFulfillment(Fulfillable $fulfillment);

    public function destroy();

    public function fillFrom(CartInterface $cart);

    public function fillConditionsFrom(CartInterface $cart);

    public function fulfillments();

    public function has(int $id);

    public function hasFulfillmentFrom(Vendor $vendor);

    public function hasProductsFrom(Vendor $vendor);

    public function instance();

    public function item(int $id);

    public function items();

    public function itemsByVendor();

    public function remove(int $id);

    public function removeFulfillment(Fulfillable $fulfillable);

    public function removeFulfillments(Vendor $vendor);

    public function setSession(string $id);

    public function subtotal();

    public function update(Cartable $cartable, float $quantity);

    public function updateFulfillment(Fulfillable $fulfillment);

    public function total();

    public function vendors();
}

