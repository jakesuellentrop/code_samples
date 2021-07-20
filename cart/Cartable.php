<?php

namespace App\Fmm\Cart;

class Cartable
{
    public $id;
    public $name;
    public $price;
    public $quantity;
    public $attributes = [];
    public $associatedModel;

    public function __construct( $id, string $name, float $price, float $quantity, array $attributes = [], string $model = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->attributes = $attributes;
        $this->associatedModel = $model;
    }
}