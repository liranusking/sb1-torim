<?php

namespace App\Policies;

use App\Models\BusinessHours;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BusinessHoursPolicy
{
    use HandlesAuthorization;

    public function update(User $user, BusinessHours $businessHours)
    {
        return $user->id === $businessHours->user_id;
    }

    public function delete(User $user, BusinessHours $businessHours)
    {
        return $user->id === $businessHours->user_id;
    }
}