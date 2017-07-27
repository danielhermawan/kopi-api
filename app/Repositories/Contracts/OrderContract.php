<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 7/11/2017
 * Time: 5:37 PM
 */

namespace App\Repositories\Contracts;


use App\Models\Order;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface OrderContract
{
    /**
     * Create Order
     * @param int $userId
     * @param array $products
     * @return Order
     */
    public function create(int $userId, array $products): Order;
    public function getDetail(int $id): Order;
    public function getProducts(int $id): Collection;
    public function getProductsPaginate(int $id, int $limit = 15): LengthAwarePaginator;
}