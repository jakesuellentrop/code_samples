<?php

namespace App\Contracts\Cart;

use App\Contracts\{Cartable, Fulfillable};
use App\Exceptions\FmmException;
use App\Models\Vendor;
use Darryldecode\Cart\{Cart, CartCondition};

class DdCartAdapter implements CartInterface
{
    private $cart;

    public function __construct(Cart $cartInstance)
    {
        $this->cart = $cartInstance;
    }

    public function add(Cartable $cartable, float $quantity)
    {
        $this->cart->add($cartable->item($quantity))
                   ->associate(get_class($cartable));
    }

    public function destroy()
    {
        $this->cart->clear();
    }

    public function fulfill(Fulfillable $fulfillment)
    {
        $conditionItem = $fulfillment->item();

        if ($this->hasCondition($conditionItem['name'])) {
            throw new FmmException('Fulfillment already added to cart.');
        }

        $this->cart->condition(new CartCondition($conditionItem));
    }

    public function fulfillments()
    {
        return $this->cart->getConditions();
    }

    public function has(int $id): bool
    {
        return $this->items()->has($id);
    }

    public function hasCondition(string $name)
    {
        return ! is_null($this->cart->getCondition($name));
    }

    public function hasProductsFrom(Vendor $vendor)
    {
        
    }

    public function items()
    {
        return $this->cart->getContent();
    }

    public function remove(int $id)
    {
        if (! $this->has($id)) {
            throw new FmmException('Item not found in cart.');
        }

        $this->cart->remove($id);
    }

    public function subtotal()
    {
        return $this->cart->getSubTotal();
    }

    public function update(Cartable $cartable, float $quantity)
    {
        if (! $this->has($cartable->id)) {
            throw new FmmException('Item not found in cart.');
        }

        $this->cart->update($cartable->id, $cartable->item($quantity));
    }

    public function total()
    {
        return $this->cart->getTotal();
    }
}

