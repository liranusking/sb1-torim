<?php

namespace App\Policies;

use App\Models\Service;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServicePolicy
{
    use HandlesAuthorization;

    public function update(User $user, Service $service)
    {
        return $user->id === $service->user_id;
    }

    public function delete(User $user, Service $service)
    {
        return $user->id === $service->user_id;
    }
}