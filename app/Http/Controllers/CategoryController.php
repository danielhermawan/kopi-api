<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Repositories\CategoryRepository;
use App\Transformer\ProductCategoryTransformer;

class CategoryController extends Controller
{

    /**
     * @var CategoryRepository
     */
    private $repository;

    /**
     * CategoryController constructor.
     */
    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $categories = $this->repository->getAll();
        $result = $this->transformCollection($categories, new ProductCategoryTransformer, 'data');
        return $this->jsonReponse($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $category = $this->repository->create($request->input('name'));
        return $this->jsonReponse($this->transformItem($category, new ProductCategoryTransformer), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = $this->repository->getDetail($id);
        $result = $this->transformItem($category, new ProductCategoryTransformer);
        return $this->jsonReponse($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        $category = $this->repository->create($request->input('name'));
        return $this->jsonReponse($this->transformItem($category, new ProductCategoryTransformer), 201);
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
