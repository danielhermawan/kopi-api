<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 7/20/2017
 * Time: 7:09 PM
 */

namespace App\Repositories\Contracts;


use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface SellerContract
{
    public function getAll(): Collection;
    public function getPaginate(int $limit = 15): LengthAwarePaginator;
    public function getDetail(int $id): User;
    public function create($data): User;
    public function update(int $id, $data): User;
    public function delete($id);
    public function attachProduct(Product $product);
    public function getProducts(int $id): Collection;
    public function getOrders(int $id): Collection;
    public function getOrdersPaginate(int $id, int $limit = 15): LengthAwarePaginator;
    public function getRequests(int $id): Collection;
    public function getRequestsPaginate(int $id, int $limit = 15): LengthAwarePaginator;
    public function getProductsPaginate(int $id, int $limit = 15): LengthAwarePaginator;
}