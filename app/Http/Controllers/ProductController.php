<?php

namespace App\Http\Controllers;

use App\Events\ProductCreated;
use App\Http\Requests\ProductRequest;
use App\Repositories\ProductRepository;
use App\Transformer\ProductTransformer;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @var ProductRepository
     */
    private $productRepo;

    /**
     * ProductController constructor.
     */
    public function __construct(ProductRepository $repository)
    {
        $this->productRepo =  $repository;
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
            $products = $this->productRepo->getAll();
            return $this->jsonReponse($this->transformCollection($products, new ProductTransformer(), "data"));
        }
        else {
            $paginator = $this->productRepo->getPaginate();
            return $this->jsonReponse($this->paginateCollection($paginator, new ProductTransformer(), "data"));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $data = $request->except(['image']);
        $product = $this->productRepo->create($data);
        event(new ProductCreated($product));
        return $this->jsonReponse($this->transformItem($product, new ProductTransformer()), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = $this->productRepo->getDetail($id);
        $result = $this->transformItem($product, new ProductTransformer());
        return $this->jsonReponse($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductTransformer $request, $id)
    {
        $data = $request->except(['image']);
        $product = $this->productRepo->update($id, $data);
        return $this->jsonReponse($this->transformItem($product, new ProductTransformer()), 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->productRepo->delete($id);
        return $this->jsonReponse(null, 204);
    }
}
