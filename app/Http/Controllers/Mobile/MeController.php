<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Transformer\ProductCategoryTransformer;
use App\Transformer\SellerRequestTransformer;
use App\Transformer\UserProductTransformer;
use Illuminate\Http\Request;

class MeController extends Controller
{

    private $repository;

    /**
     * ProductController constructor.
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getproducts(Request $request)
    {
        $products = $this->repository->getProducts($request->user()->id);
        $result = $this->transformCollection($products, new UserProductTransformer());
        return $this->jsonReponse($result);
    }

    public function getProductOrders(Request $request)
    {
        $products = $this->repository->getOrderProducts($request->user()->id);
        $result = $this->transformCollection($products, new UserProductTransformer());
        return $this->jsonReponse($result);
    }

    public function getStockOrders(Request $request)
    {
        $products = $this->repository->getStockProducts($request->user()->id);
        $result = $this->transformCollection($products, new UserProductTransformer());
        return $this->jsonReponse($result);
    }

    public function getCategories(Request $request)
    {
        $products = $this->repository->getCategoriedProduct($request->user()->id);
        $result = $this->transformCollection($products, new ProductCategoryTransformer());
        return $this->jsonReponse($result);
    }

    public function getSendedRequests(Request $request)
    {
        $requests = $this->repository->getRequest($request->user()->id);
        $result = $this->transformCollection($requests, new SellerRequestTransformer());
        return $this->jsonReponse($result);
    }

}
