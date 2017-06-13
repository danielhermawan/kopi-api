<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 6/12/2017
 * Time: 9:14 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $fillable = ['name'];

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }
}