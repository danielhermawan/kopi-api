<?php
namespace App\Transformer;

use League\Fractal\TransformerAbstract;

/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 6/15/2017
 * Time: 11:11 PM
 */
class ProductCategoryTransformer extends TransformerAbstract
{
    protected $availableIncludes = [];
    protected $defaultIncludes = [];

    public function transform($category): array
    {
        return [
            "id" => $category->id,
            "name" => $category->name
        ];
    }
}