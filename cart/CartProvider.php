<?php

namespace App\Fmm\Cart;

use App\Fmm\Cart\Contracts\PersistentCartInterface;
use App\Fmm\Cart\Contracts\SessionCartInterface;
use Illuminate\Support\ServiceProvider;

class CartProvider extends ServiceProvider
{
    protected $cart;

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerSessionCart();
        $this->registerPersistentCart();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // 
    }

    private function registerPersistentCart()
    {
        $this->app->singleton(PersistentCartInterface::class, function ($app) {            
            $cart = new Cart(
                $storage = new PersistentCartStorage,
                $events = app('events'),
                $instanceName = 'persistent_cart',
                $session_key = uniqid(),
                config('shopping_cart')
            );

            return new DdCartAdapter($cart);
        });
    }

    private function registerSessionCart()
    {
        $this->app->singleton(SessionCartInterface::class, function ($app) {
			$cart = new Cart(
				$storage = app('session'),
				$events = app('events'),
				$instanceName = 'session_cart',
				$session_key = uniqid(),
				config('shopping_cart')
			);

            return new DdCartAdapter($cart);
        });
    }
}
