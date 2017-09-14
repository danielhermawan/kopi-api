<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 7/12/2017
 * Time: 4:48 PM
 */

namespace App\Repositories\Contracts;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ProductContract
{
    public function getAll(): Collection;
    public function getPaginate(int $limit): LengthAwarePaginator;
    public function getDetail(int $id): Product;
    public function create($data): Product;
    public function update(int $id, $data): Product;
    public function updateQuantity(int $sellerId, int $productid, int $quantity);
    public function delete($id);
    public function checkStock(int $idProduct, int $idUser, int $quantity): bool;
}