<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Repositories\RequestRepository;

class RequestController extends Controller
{
    /**
     * @var RequestRepository
     */
    private $requestRepo;

    /**
     * RequestController constructor.
     * @param RequestRepository $requestRepo
     */
    public function __construct(RequestRepository $requestRepo)
    {
        $this->requestRepo = $requestRepo;
    }

    public function create(OrderRequest $request)
    {
        $products = $request->input("products");
        $userId = $request->user()->id;
        $this->requestRepo->create($userId, $products);
        return $this->jsonReponse([], 201);
    }


}
