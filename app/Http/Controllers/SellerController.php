<?php

namespace App\Http\Controllers;

use App\Repositories\SellerRepository;
use App\Transformer\UserTransformer;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    /**
     * @var SellerRepository
     */
    private $repository;

    /**
     * UserController constructor.
     * @param $repository
     */
    public function __construct(SellerRepository $repository)
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
        $paginate = $request->get('paginate' , 0);
        if($paginate == 0) {
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
    public function store(Request $request)
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
    public function update(Request $request, $id)
    {
        $product = $this->repository->update($id, $request->all());
        return $this->jsonReponse($this->transformItem($product, new UserTransformer()), 201);
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
}
