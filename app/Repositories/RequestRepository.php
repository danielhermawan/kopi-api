<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 7/19/2017
 * Time: 9:10 PM
 */

namespace App\Repositories;


use App\Models\Product;
use App\Models\Request;
use App\Repositories\Contracts\RequestContract;
use Illuminate\Database\Connection;

class RequestRepository implements RequestContract
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
     * Create Request
     * @param int $userId
     * @param array $products
     * @return Request
     */
    public function create(int $userId, array $products): Request
    {
        $this->db->beginTransaction();
        $request = new Request;
        $request->user_id = $userId;
        $request->save();
        $dataRequest = [];
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
        $request->products()->attach($dataProduct);
        $this->db->commit();
        return $request;
    }
}