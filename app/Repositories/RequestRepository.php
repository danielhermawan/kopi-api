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
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class RequestRepository implements RequestContract
{
    /**
     * @var Connection
     */
    private $db;

    private $request;

    /**
     * OrderRepository constructor.
     * @param Connection $db
     */
    public function __construct(Connection $db, Request $request)
    {
        $this->db = $db;
        $this->request = $request->newQuery();
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

    public function getAll(bool $filter = false, bool $isDone = false): Collection
    {
        $query = $this->request;
        if($filter)
            $query->where('is_done', $isDone);
        return $this->request->get();
    }

    public function getPaginate(bool $filter = false, bool $isDone = false, int $limit = 15): LengthAwarePaginator
    {
        $query = $this->request;
        if($filter)
            $query->where('is_done', $isDone);
        return $this->request->paginate();
    }

    public function getProducts(int $id): Collection
    {
        return Request::findorfail($id)->products;
    }

    public function getProductsPaginate(int $id, int $limit = 15): LengthAwarePaginator
    {
        return Request::findorfail($id)->products()->paginate($limit);
    }

    public function getDetail(int $id): Request 
    {
        return Request::findorfail($id);
    }

    public function requestDone(int $id)
    {
        $this->db->beginTransaction();
        $request = Request::findorfail($id);
        $request->is_done = true;
        $request->save();
        $products = $request->products;
        foreach ($products as $p) {
            DB::table('product_user')->where('user_id', $request->user_id)
                ->where('product_id', $p->id)->increment('quantity', $p->pivot->quantity);
        }
        $this->db->commit();

    }
}