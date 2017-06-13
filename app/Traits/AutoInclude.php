<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 8/23/2016
 * Time: 5:29 PM
 */

namespace App\Traits;


trait AutoInclude
{
    public function getPossibleRelations()
    {
        return [];
    }

    public function scopeEagerLoading($query, $include)
    {
        $eagerLoad = array_keys(array_intersect($this->getPossibleRelations(), $include));
        return $query->with($eagerLoad);
    }
}