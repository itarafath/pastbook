<?php

namespace App\Repositories;


use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserRepository
 *
 * @package \App\Repositories
 */
class UserRepository
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function insert($facebook_user)
    {
        return $this->user->create([
            'name' => $facebook_user->getName(),
            'email' => $facebook_user->getEmail(),
            'password' => Hash::make('password'),
            'facebook_id' => $facebook_user->getId(),
        ]);
    }
}
