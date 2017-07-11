<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 6/16/2017
 * Time: 6:21 PM
 */

namespace App\Repositories;


use App\Models\ProductCategory;

class CategoryRepository extends BaseRepository
{

    protected function getModel()
    {
        return new ProductCategory();
    }

}