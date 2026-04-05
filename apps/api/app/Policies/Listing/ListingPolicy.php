<?php

namespace App\Policies\Listing;

use App\Models\Listing\Listing;
use App\Models\User;

class ListingPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['provider', 'admin', 'super-admin'], true);
    }

    public function update(User $user, Listing $listing): bool
    {
        return $user->id === $listing->provider_id || in_array($user->role, ['admin', 'super-admin'], true);
    }

    public function moderate(User $user): bool
    {
        return in_array($user->role, ['admin', 'super-admin'], true);
    }
}
