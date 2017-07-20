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
    public function getPaginate(int $limit): LengthAwarePaginator;
    public function getDetail(int $id): User;
    public function create($data): User;
    public function update(int $id, $data): User;
    public function delete($id);
    public function attachProduct(Product $product);
}