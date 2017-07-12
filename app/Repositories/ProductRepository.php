<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 6/15/2017
 * Time: 10:39 PM
 */

namespace App\Repositories;


use App\Models\Order;
use App\Models\Product;
use App\Repositories\Contracts\ProductContract;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository implements ProductContract
{
    /**
     * @var Connection
     */
    private $db;

    /**
     * @var \Illuminate\Database\Eloquent\Builder
     */
    private $product;

    /**
     * OrderRepository constructor.
     * @param Connection $db
     */
    public function __construct(Connection $db, Product $product)
    {

        $this->db = $db;
        $this->product = $product->newQuery();
    }

    public function getAll(): Collection
    {
        return $this->product->get();
    }

    /**
     * Check whether stock still available within order quantity
     * @param int $idProduct
     * @param int $idUser
     * @param int $orderQuantity
     * @return bool
     */
    public function checkStock(int $idProduct, int $idUser, int $orderQuantity): bool
    {
        $quantity = $this->db->table("product_user")->where('user_id', $idUser)
            ->where("product_id", $idProduct)->value("quantity");
        if($orderQuantity > $quantity)
            return false;
        else
            return true;
    }

    public function getWhere($key, $value, $isSingle = false)
    {
        $query = $this->product->where($key, $value);
        if($isSingle)
            return $query->first();
        else
            return $query->get();
    }

    public function getInclude($include)
    {
        return $this->product->eagerLoading($include)->get();
    }

    protected function getModel()
    {
        return new Order();
    }
}