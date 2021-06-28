<?php

namespace App\Actions\Cart;

use App\Contracts\Cart\AddsFulfillment;
use App\Models\Vendor;

class AddFulfillment extends CartAction implements AddsFulfillment
{
    public function fulfill(Vendor $vendor, string $fulfillmentType)
    {
        $fulfillment = $vendor->fulfillmentFor($fulfillmentType);

        if (! $this->cart->hasCondition($fulfillment->name)) {
            $this->cart->fulfill($fulfillment);
        }
    }
}
