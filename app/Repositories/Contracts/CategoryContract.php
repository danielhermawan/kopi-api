<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 7/24/2017
 * Time: 6:12 PM
 */

namespace App\Repositories\Contracts;


use App\Models\ProductCategory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface CategoryContract
{
    public function getAll(): Collection;
    public function getDetail(int $id): ProductCategory;
    public function create(string $name): ProductCategory;
    public function update(int $id, string $name): ProductCategory;
    public function delete(int $id);
}