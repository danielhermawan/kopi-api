<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 7/19/2017
 * Time: 9:10 PM
 */

namespace App\Repositories;

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
        $dataProduct = [];
        foreach ($products as $p) {
            $dataProduct[$p["id"]] = [
                "quantity" => $p["quantity"],
            ];
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

    public function getProducts(int $id)
    {
        return DB::table('request_product as rp')
            ->join('requests as r', 'rp.request_id', '=', 'r.id')
            ->join('product_user as pu', function ($join) {
                $join->on('pu.user_id', '=', 'r.user_id')
                    ->on('pu.product_id', '=','rp.product_id');
            })
            ->join('products as p', 'p.id', '=', 'rp.product_id')
            ->select('rp.*', 'pu.quantity AS user_stock', 'p.name', 'p.price', 'p.id')
            ->where('rp.request_id', $id)->get();
    }

    public function getProductsPaginate(int $id, int $limit = 15): LengthAwarePaginator
    {
        return DB::table('request_product')
            ->join('requests', 'request_product.request_id', '=', 'requests.id')
            ->join('product_user', function ($join) {
                $join->on('product_user.user_id', '=', 'requests.user_id')
                    ->where('product_user.product_id', '=','request_product.product_id');
            })
            ->select('request_product.*', 'product_user.quantity AS user_stock')
            ->where('request_product.request_id', $id)->get();
        //return Request::findorfail($id)->products()->paginate($limit);
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