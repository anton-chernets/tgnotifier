<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function getSubscribedUsers(): \Illuminate\Database\Eloquent\Collection
    {
       return User::whereSubscribed(true)->get();
    }
}
