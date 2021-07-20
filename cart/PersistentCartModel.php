<?php

namespace App\Fmm\Cart;

use Illuminate\Database\Eloquent\Model;

class PersistentCartModel extends Model
{
    protected $table = 'carts';

    protected $fillable = [ 'id', 'cart_data' ];

    public function setCartDataAttribute($value)
    {
        $this->attributes['cart_data'] = serialize($value);
    }

    public function getCartDataAttribute($value)
    {
        return unserialize($value);
    }
}