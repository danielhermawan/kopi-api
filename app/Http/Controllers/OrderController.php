<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 7/26/2017
 * Time: 6:16 PM
 */

namespace App\Http\Controllers;


use App\Repositories\Contracts\OrderContract;
use App\Transformer\SellerOrderTransformer;
use App\Transformer\UserProductTransformer;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    /**
     * @var OrderContract
     */
    private $repository;

    /**
     * UserController constructor.
     * @param $repository
     */
    public function __construct(OrderContract $repository)
    {
        $this->repository = $repository;
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $request = $this->repository->getDetail($id);
        $result = $this->transformItem($request, new SellerOrderTransformer());
        return $this->jsonReponse($result);
    }
}