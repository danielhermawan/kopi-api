<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 8/31/2017
 * Time: 6:57 PM
 */

namespace App\Transformer;


use League\Fractal\TransformerAbstract;

class RequestProductTransformer extends TransformerAbstract
{

    public function transform($product): array
    {
        return [
            "id" => $product->id,
            "name" => $product->name,
            "price" => $product->price,
            "quantity" => $product->quantity,
            "user_stock" => $product->user_stock,
            "min_stock_unit" => $product->min_stock_unit,
            "purchase_price" => $product->purchase_price,
            "type" => $product->type
        ];
    }
}