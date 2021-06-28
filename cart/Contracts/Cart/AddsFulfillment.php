<?php

namespace App\Contracts\Cart;

use App\Models\Vendor;

interface AddsFulfillment
{
    public function fulfill(Vendor $vendor, string $fulfillmentType);
}

