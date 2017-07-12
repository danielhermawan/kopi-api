<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Repositories\Contracts\OrderContract;
use App\Repositories\Contracts\ProductContract;

class OrderController extends Controller
{
    /**
     * @var OrderContract
     */
    private $orderRepo;

    /**
     * @var ProductContract
     */
    private $productRepo;

    /**
     * OrderController constructor.
     * @param OrderContract $contract
     */
    public function __construct(OrderContract $contract, ProductContract $productContract)
    {
        $this->orderRepo = $contract;
        $this->productRepo = $productContract;
    }

    public function create(OrderRequest $request)
    {
        $products = $request->input("products");
        $userId = $request->user()->id;
        foreach ($products as $p) {
            $available = $this->productRepo->checkStock($p['id'], $userId, $p['quantity']);
            if(!$available)
                return $this->jsonReponse([
                    "message" => "Order melebihi quantity yang ada distock!"
                ], 422);
        }
        $this->orderRepo->create($userId, $products);
        return $this->jsonReponse([], 201);
    }
}
