<?php

namespace App\Policies;

use App\Models\Card;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CardPolicy
{
    public function create(\App\Models\User $user): bool
    {
        // verdadero para cualquier usuario autenticado
        return true;
    }
    public function view(User $user, Card $card)    { return $user->id === $card->user_id; }
    public function update(User $user, Card $card)  { return $user->id === $card->user_id; }
    public function delete(User $user, Card $card)  { return $user->id === $card->user_id; }
}
