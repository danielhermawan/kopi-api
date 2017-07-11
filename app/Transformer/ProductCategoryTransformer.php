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
    protected $availableIncludes = ['products'];
    protected $defaultIncludes = ['products'];

    public function transform($category): array
    {
        return [
            "id" => $category->id,
            "name" => $category->name
        ];
    }

    public function includeProducts($category)
    {
        $products = $category->products;
        return $this->collection($products, new UserProductTransformer());
    }
}