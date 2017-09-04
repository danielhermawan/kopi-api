<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
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
        // todo: in request add new param named unit so we can convert it and adjust with quantity in database
        $products = $request->input("products");
        $userId = $request->user()->id;
        foreach ($products as $p) {
            $available = $this->requestRepo->checkMinStock($p['id'], $p['quantity']);
            if(!$available)
                return $this->jsonReponse([
                    "message" => "Request stock dibawah minimum stock!"
                ], 422);
        }
        $this->requestRepo->create($userId, $products);
        return $this->jsonReponse([], 201);
    }


}
