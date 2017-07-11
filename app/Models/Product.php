<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 6/12/2017
 * Time: 9:15 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'price', 'currency', 'image_url', 'category_id'];

    public function category()
    {
        return $this->belongsTo('App\Models\ProductCategory');
    }

    public function users()
    {
        return $this->belongsToMany('App\Models\User')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function orders()
    {
        return $this->belongsToMany('App\Models\Order')
            ->withPivot('quantity', 'price');
    }
}