<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 6/15/2017
 * Time: 10:39 PM
 */

namespace App\Repositories;


use App\Models\Order;

class ProductRepository extends BaseRepository
{

    protected function getModel()
    {
        return new Order();
    }
}