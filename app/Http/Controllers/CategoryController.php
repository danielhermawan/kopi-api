<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use App\Transformer\ProductCategoryTransformer;

class CategoryController extends Controller
{
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
        $result = $this->transformCollection($categories, new ProductCategoryTransformer);
        return $this->jsonReponse($result);
    }
}
