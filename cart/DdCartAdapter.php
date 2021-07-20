<?php

namespace App\Fmm\Cart;

use App\Fmm\Cart\Contracts\Fulfillable;
use App\Fmm\Cart\Cart;
use App\Fmm\Cart\Contracts\{CartInterface, PersistentCartInterface, SessionCartInterface};
use App\Exceptions\FmmException;
use App\Models\Vendor;
use Darryldecode\Cart\CartCondition;

class DdCartAdapter implements CartInterface, SessionCartInterface, PersistentCartInterface
{
    /**
     * Do not access $cart property directly!
     * 
     * Use 'instance()' method to get current user's cart.
     * 
     */
    private $cart;

    private $session_id;

    public function __construct(Cart $cartInstance)
    {
        $this->cart = $cartInstance;
    }

    public function add(Cartable $cartable)
    {
        $this->instance()->add((array) $cartable);
    }

    public function addFulfillment(Fulfillable $fulfillment)
    {
        $conditionItem = $fulfillment->item();

        if ($this->hasCondition($conditionItem['name'])) {
            throw new FmmException('Fulfillment already added to cart.');
        }

        $this->instance()->condition(new CartCondition($conditionItem));
    }

    public function destroy()
    {
        $this->instance()->clear();

        $this->instance()->clearCartConditions();
    }

    public function fillFrom(CartInterface $cart)
    {
        $cart->items()->each(function ($item) {
            $this->instance()->add($item->all());
        });
    }

    public function fillConditionsFrom(CartInterface $cart)
    {
        $cart->fulfillments()->each(function ($fulfillment) {
            $this->instance()->condition($fulfillment);
        });
    }

    public function fulfillments()
    {
        return $this->instance()->getConditions();
    }

    public function has(int $id): bool
    {
        return $this->items()->has($id);
    }

    public function hasFulfillmentFrom(Vendor $vendor)
    {
        return $this->hasCondition($vendor->name);
    }

    public function hasProductsFrom(Vendor $vendor)
    {
        $items = $this->items()->filter(function ($item) use ($vendor) {
            return $item->attributes->vendor->name === $vendor->name;
        });

        return $items->count() !== 0;
    }

    public function instance()
    {
        return $this->cart->session($this->session_id ?: request()->user()->id);
    }

    public function item(int $id)
    {
        return $this->items()->get($id);
    }

    public function items()
    {
        return $this->instance()->getContent();
    }

    public function itemsByVendor()
    {
        return $this->items()->groupBy(function ($item, $key) {
            return $item->attributes->vendor->id;
        });
    }

    public function remove(int $id)
    {
        $this->instance()->remove($id);
    }

    public function removeFulfillment(Fulfillable $fulfillable)
    {
        $this->instance()->removeCartCondition($fulfillable->vendor->name);
    }

    public function removeFulfillments(Vendor $vendor)
    {
        $this->instance()->removeCartCondition($vendor->name);
    }

    public function setSession(string $id)
    {
        $this->session_id = $id;

        return $this;
    }

    public function subtotal()
    {
        return $this->instance()->getSubTotal();
    }

    public function update(Cartable $cartable, float $quantity)
    {
        if (! $this->has($cartable->id)) {
            throw new FmmException('Item not found in cart.');
        }

        $this->instance()->update($cartable->id, (array) $cartable);
    }

    public function updateFulfillment(Fulfillable $fulfillment)
    {
        if (! $this->hasCondition($fulfillment->vendor->name)) {
            throw new FmmException('No fulfillment for vendor found in cart.');
        }

        $this->removeFulfillment($fulfillment);

        $this->addFulfillment($fulfillment);
    }

    public function total()
    {
        return $this->instance()->getTotal();
    }

    public function vendors()
    {
        return $this->items()->map(function ($item) {
            return $item->attributes->vendor;
        })->unique();
    }

    private function hasCondition(string $name)
    {
        return ! is_null($this->instance()->getCondition($name));
    }
}

