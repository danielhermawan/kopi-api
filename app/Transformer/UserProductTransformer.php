<?php
namespace App\Transformer;

use App\Models\Product;
use League\Fractal\TransformerAbstract;

/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 6/15/2017
 * Time: 11:06 PM
 */
class UserProductTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['category'];
    protected $defaultIncludes = ['category'];

    public function transform($product): array
    {
        return [
            "id" => $product->id,
            "name" => $product->name,
            "price" => $product->price,
            "currency" => $product->currency,
            "image_url" => $product->image_url,
            "min_stock" => $product->min_stock,
            "min_stock_unit" => $product->min_stock_unit,
            "per_stock" => $product->per_stock,
            "purchase_price" => $product->purchase_price,
            "type" => $product->type,
            "recipe" => $product->recipe,
            "quantity" => $product->pivot->quantity
        ];
    }

    public function includeCategory(Product $product)
    {
        $category = $product->category;
        return $this->item($category, new ProductCategoryTransformer());
    }
}