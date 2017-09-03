<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 7/19/2017
 * Time: 9:00 PM
 */

namespace App\Repositories\Contracts;

use App\Models\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface RequestContract
{
    /**
     * Create Request
     * @param int $userId
     * @param array $products
     * @return Request
     */
    public function create(int $userId, array $products): Request;
    public function getAll(bool $filter = false, bool $isDone = false): Collection;
    public function getDetail(int $id): Request;
    public function getPaginate(bool $filter = false, bool $isDone = false, int $limit = 15): LengthAwarePaginator;
    public function getProducts(int $id);
    public function getProductsPaginate(int $id, int $limit = 15): LengthAwarePaginator;
    public function requestDone(int $id);
}