<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 6/16/2017
 * Time: 6:21 PM
 */

namespace App\Repositories;


use App\Models\ProductCategory;
use App\Repositories\Contracts\CategoryContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository implements CategoryContract
{

    /**
     * @var Connection
     */
    private $db;

    /**
     * @var \Illuminate\Database\Eloquent\Builder
     */
    private $category;

    /**
     * OrderRepository constructor.
     * @param Connection $db
     */
    public function __construct(Connection $db, ProductCategory $category)
    {

        $this->db = $db;
        $this->category = $category->newQuery();
    }

    public function getAll(): Collection
    {
        return $this->category->get();
    }

    public function getDetail(int $id): ProductCategory
    {
        return ProductCategory::findorFail($id);
    }

    public function create(string $name): ProductCategory
    {
        $category = new ProductCategory;
        $category->name = $name;
        $category->save();
        return $category;
    }

    public function update(int $id, string $name): ProductCategory
    {
        $category = ProductCategory::findorFail($id);
        $category->name = $name;
        $category->save();
        return $category;
    }

    public function delete(int $id)
    {
        ProductCategory::destroy($id);
    }
}