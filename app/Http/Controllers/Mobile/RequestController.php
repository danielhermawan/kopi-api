<?php

namespace App\Http\Controllers\Mobile;

use App\Events\RequestChange;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Repositories\RequestRepository;
use App\Transformer\SellerRequestTransformer;
use Auth;

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
        $request = $this->requestRepo->create($userId, $products);
        event(new RequestChange($request));
        return $this->jsonReponse([], 201);
    }

    public function requestFinish($id)
    {
        $rqst = $this->requestRepo->getDetail($id);
        if(Auth::user()->can('finish', $rqst) and $rqst->status == '1') {
            $request = $this->requestRepo->requestDone($id);
            event(new RequestChange($request));
            return $this->jsonReponse(null, 204);
        }
        else
            return $this->jsonReponse(['message'=>'Forbidden'], 403);
    }

    // todo: private, push mobile
    public function showRequest($id)
    {
        $request = $this->requestRepo->getDetail($id);
        if(Auth::user()->can('finish', $request))
            return $this->jsonReponse($this->transformItem($request, new SellerRequestTransformer()));
        else
            return $this->jsonReponse(['message'=>'Forbidden'], 403);
    }

}
