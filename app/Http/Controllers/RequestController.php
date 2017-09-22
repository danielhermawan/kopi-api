<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 7/26/2017
 * Time: 5:59 PM
 */

namespace App\Http\Controllers;


use App\Repositories\Contracts\RequestContract;
use App\Transformer\RequestProductTransformer;
use App\Transformer\SellerRequestTransformer;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    /**
     * @var RequestContract
     */
    private $repository;

    /**
     * UserController constructor.
     * @param $repository
     */
    public function __construct(RequestContract $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $paginate = $request->get('paginate', 0);
        if ($paginate == 0) {
            $requestCollection = $this->repository->getAll();
            return $this->jsonReponse($this->transformCollection($requestCollection, new SellerRequestTransformer(), "data"));
        }
        else {
            $paginator = $this->repository->getPaginate();
            return $this->jsonReponse($this->paginateCollection($paginator, new SellerRequestTransformer(), "data"));
        }
    }

    public function getProducts(Request $request, $id)
    {
        $paginate = $request->get('paginate', 0);
        if($paginate == 0) {
            $products = $this->repository->getProducts($id);
            return $this->jsonReponse($this->transformCollection($products, new RequestProductTransformer(), 'data'));
        }
        else {
            $paginator = $this->repository->getProductsPaginate($id);
            return $this->jsonReponse($this->paginateCollection($paginator, new RequestProductTransformer(), "data"));
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
        $result = $this->transformItem($request, new SellerRequestTransformer());
        return $this->jsonReponse($result);
    }

    public function requestSent($id)
    {
        $this->repository->requestSent($id);
        return $this->jsonReponse(null, 204);
    }
}