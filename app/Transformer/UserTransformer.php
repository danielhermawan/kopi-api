<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 7/20/2017
 * Time: 7:22 PM
 */

namespace App\Transformer;


use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user): array
    {
        return [
            "id" => $user->id,
            "username" => $user->username,
            "email" => $user->email,
            "name" => $user->name,
            "phone_number" => $user->phone_number,
            "gender" => $user->gender,
            "address" => $user->address,
            "created_at" => $user->created_at,
            "updated_at" => $user->updated_at
        ];
    }
}