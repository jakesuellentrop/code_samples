<?php

namespace App\Services;

use App\Models\Fulfillment;
use Darryldecode\Cart\{Cart, CartCollection, CartCondition};
use Darryldecode\Cart\Facades\CartFacade;

class CartService
{
    /**
     * Add an item to the user's cart
     * 
     * @return \Darryldecode\Cart\Cart
     */
    public static function add(...$args): Cart
    {
        return static::fetch()->add(...$args);
    }

    /**
     * Clear all items from the user's cart
     * 
     * @return bool
     */
    public static function destroy(): bool
    {
        return static::fetch()->clear();
    }

    /**
     * Retrieve the user's cart
     * 
     * @return \Darryldecode\Cart\Cart
     */
    public static function fetch(string $id = null): Cart
    {
        if (is_null($id)) {
            $id = static::getCartId();
        }

        return CartFacade::session($id);
    }

    /**
     * Add a fulfillment method to the user's cart
     */
    public static function fulfill(Fulfillment $fulfillment)
    {
        $condition = new CartCondition([
            'name' => "{$fulfillment->vendor->name} Fulfillment",
            'type' => $fulfillment->type,
            'target' => 'total',
            'value' => "+{$fulfillment->price}"
        ]);

        return static::fetch()->condition($condition);
    }

    private static function getCartId()
    {
        if ($user = request()->user()) {
            return $user->id;
        }

        $cartId = session('cart');

        if (is_null($cartId)) {
            $cartId = md5(time());
            session(['cart' => $cartId]);
        }

        return $cartId;
    }

    /**
     * Check if an item is already in the cart
     * 
     * @return bool
     */
    public static function has(int $id): bool
    {
        return static::items()->has($id);
    }

    /**
     * Shortcut to retrieve all items from the user's cart
     * 
     * @return \Darryldecode\Cart\CartCollection
     */
    public static function items(string $id = null): CartCollection
    {
        return static::fetch($id)->getContent();
    }

    /**
     * Remove an individual item from the user's cart
     * 
     * @return bool
     */
    public static function yeet(int $id): bool
    {
        if (! static::has($id)) {
            return false;
        }

        return static::fetch()->remove($id);
    }
}