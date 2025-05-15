<?php

namespace App\Policies;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReservationPolicy {
  use HandlesAuthorization;

  public function view(User $user, Reservation $reservation): bool {
    return $user->id === $reservation->user_id || $user->isAdmin();
  }

  public function update(User $user, Reservation $reservation): bool {
    return $user->id === $reservation->user_id || $user->isAdmin();
  }

  public function delete(User $user, Reservation $reservation): bool {
    return $user->id === $reservation->user_id || $user->isAdmin();
  }
}
