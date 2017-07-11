<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 7/11/2017
 * Time: 5:08 PM
 */

namespace App\Repositories;


use App\Models\Order;
use App\Models\Product;
use App\Repositories\Contracts\OrderContract;
use Illuminate\Support\Facades\DB;

class OrderRepository implements OrderContract
{
    public function create(int $userId, array $products): Order
    {
        DB::beginTransaction();
        $order = new Order;
        $order->user_id = $userId;
        $order->save();
        $dataProduct = [];
        foreach ($products as $p) {
            $entity = Product::find($p["id"]);
            $dataProduct[$p["id"]] = [
                "quantity" => $p["quantity"],
                "price" => $entity->price
            ];
            DB::table('product_user')->decrement("quantity", $p["quantity"], [
                'user_id' => $userId,
                'product_id' => $p["id"]
            ]);
        }
        //print_r($dataProduct);die();
        //$order->products()->attach([121 => ['quantity' => 1, 'price' => 38910]]);
        $order->products()->attach($dataProduct);
        DB::commit();
        return $order;
    }
}