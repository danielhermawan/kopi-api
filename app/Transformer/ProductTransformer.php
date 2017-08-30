<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 7/20/2017
 * Time: 4:36 PM
 */

namespace App\Transformer;


use App\Models\Product;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['category'];
    protected $defaultIncludes = ['category'];

    public function transform(Product $product): array
    {
        return [
            "id" => $product->id,
            "name" => $product->name,
            "price" => $product->price,
            "currency" => $product->currency,
            "min_stock" => $product->min_stock,
            "per_stock" => $product->per_stock,
            "purchase_price" => $product->purchase_price,
            "image_url" => $product->image_url,
            "created_at" => $product->created_at,
            "updated_at" => $product->updated_at
        ];
    }

    public function includeCategory(Product $product)
    {
        $category = $product->category;
        return $this->item($category, new ProductCategoryTransformer());
    }
}