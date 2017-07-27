<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 7/26/2017
 * Time: 5:11 PM
 */

namespace App\Transformer;


use App\Models\Order;
use DB;
use League\Fractal\TransformerAbstract;

class SellerOrderTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['product', 'seller'];
    protected $defaultIncludes = [];

    public function transform($order): array
    {
        $sum = DB::select('SELECT SUM (price * quantity) AS total FROM order_product WHERE order_id = ?'
            , [$order->id])[0]->total;
        return [
            "id" => $order->id,
            "total" => $sum,
            "created_at" => $order->created_at,
            "updated_at" => $order->updated_at
        ];
    }

    public function includeSeller(Order $order)
    {
        $user = $order->user;
        return $this->item($user, new UserTransformer);
    }

    public function includeProduct(Order $order)
    {
        $products = $order->products;
        return $this->collection($products, new ProductTransformer);
    }
}