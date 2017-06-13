<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 6/13/2017
 * Time: 8:29 PM
 */

namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{
    protected function getModel()
    {
        return new User();
    }
}