<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AppointmentPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Appointment $appointment)
    {
        return $user->id === $appointment->user_id || $user->id === $appointment->service->user_id;
    }

    public function delete(User $user, Appointment $appointment)
    {
        return $user->id === $appointment->user_id || $user->id === $appointment->service->user_id;
    }
}