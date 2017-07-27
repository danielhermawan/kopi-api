<?php

namespace App\Http\Controllers;

use App\Http\Requests\SellerCreateRequest;
use App\Http\Requests\SellerUpdateRequest;
use App\Repositories\Contracts\SellerContract;
use App\Transformer\SellerOrderTransformer;
use App\Transformer\SellerRequestTransformer;
use App\Transformer\UserProductTransformer;
use App\Transformer\UserTransformer;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    /**
     * @var SellerContract
     */
    private $repository;

    /**
     * UserController constructor.
     * @param $repository
     */
    public function __construct(SellerContract $repository)
    {
        $this->repository = $repository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $paginate = $request->get('paginate', 0);
        if ($paginate == 0) {
            $products = $this->repository->getAll();
            return $this->jsonReponse($this->transformCollection($products, new UserTransformer(), "data"));
        }
        else {
            $paginator = $this->repository->getPaginate();
            return $this->jsonReponse($this->paginateCollection($paginator, new UserTransformer(), "data"));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SellerCreateRequest $request)
    {
        $product = $this->repository->create($request->all());
        return $this->jsonReponse($this->transformItem($product, new UserTransformer()), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = $this->repository->getDetail($id);
        $result = $this->transformItem($product, new UserTransformer());
        return $this->jsonReponse($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SellerUpdateRequest $request, $id)
    {
        $user = $this->repository->update($id, $request->all());
        return $this->jsonReponse($this->transformItem($user, new UserTransformer()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->repository->delete($id);
        return $this->jsonReponse(null, 204);
    }

    public function getProducts(Request $request, $id)
    {
        $paginate = $request->get('paginate', 0);
        if($paginate == 0) {
            $products = $this->repository->getProducts($id);
            return $this->jsonReponse($this->transformCollection($products, new UserProductTransformer(), 'data'));
        }
        else {
            $paginator = $this->repository->getProductsPaginate($id);
            return $this->jsonReponse($this->paginateCollection($paginator, new UserProductTransformer(), "data"));
        }
    }

    public function getOrders(Request $request, $id)
    {
        $paginate = $request->get('paginate', 0);
        if($paginate == 0) {
            $orders = $this->repository->getOrders($id);
            return $this->jsonReponse($this->transformCollection($orders, new SellerOrderTransformer(), 'data'));
        }
        else {
            $paginator = $this->repository->getOrdersPaginate($id);
            return $this->jsonReponse($this->paginateCollection($paginator, new SellerOrderTransformer(), "data"));
        }
    }

    public function getRequests(Request $request, $id)
    {
        $paginate = $request->get('paginate', 0);
        if($paginate == 0) {
            $orders = $this->repository->getRequests($id);
            return $this->jsonReponse($this->transformCollection($orders, new SellerRequestTransformer(), 'data'));
        }
        else {
            $paginator = $this->repository->getRequestsPaginate($id);
            return $this->jsonReponse($this->paginateCollection($paginator, new SellerRequestTransformer(), "data"));
        }
    }
}
