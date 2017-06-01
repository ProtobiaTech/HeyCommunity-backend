<?php

namespace App\Http\Controllers\Api\Transform;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransform extends TransformerAbstract
{
    public function transform(User $user)
    {
        // add what you need here
        return [
            'nickname'          => $user->nickname,
            'phone'             => $user->phone,
        ];
    }
}
