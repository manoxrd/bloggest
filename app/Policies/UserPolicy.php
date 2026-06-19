<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
  public function update(User $user): bool
  {
    return isset($user->id);
  }

  public function delete(User $user): bool
  {
    return isset($user->id);
  }
}
