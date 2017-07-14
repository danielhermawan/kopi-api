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
use Illuminate\Database\Connection;

class OrderRepository implements OrderContract
{
    /**
     * @var Connection
     */
    private $db;

    /**
     * OrderRepository constructor.
     * @param Connection $db
     */
    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    /**
     * Create Order
     * @param int $userId
     * @param array $products
     * @return Order
     */
    public function create(int $userId, array $products): Order
    {
        $this->db->beginTransaction();
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
            $this->db->table('product_user')->where([
                'user_id' => $userId,
                'product_id' => $p["id"]
            ])->decrement("quantity", $p["quantity"]);
        }
        $order->products()->attach($dataProduct);
        $this->db->commit();
        return $order;
    }
}