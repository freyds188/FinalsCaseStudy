<?php

namespace App\Policies;

use App\Models\Cart;
use App\Models\User;

class CartPolicy
{
    public function cartOwner(User $user, Cart $cart)
    {
        return $user->id === $cart->user_id;
    }
}