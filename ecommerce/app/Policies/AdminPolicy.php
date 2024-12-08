<?php

namespace App\Policies;

use App\Models\User;

class AdminPolicy
{
    public function adminOnly(User $user)
    {
        return $user->role === 'admin';
    }
}