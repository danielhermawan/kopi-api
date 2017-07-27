<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 7/26/2017
 * Time: 5:31 PM
 */

namespace App\Transformer;


use App\Models\Request;
use League\Fractal\TransformerAbstract;

class SellerRequestTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['product', 'seller'];
    protected $defaultIncludes = [];

    public function transform($request): array
    {
        return [
            "id" => $request->id,
            "is_done" => $request->is_done,
            "created_at" => $request->created_at,
            "updated_at" => $request->updated_at
        ];
    }

    public function includeSeller(Request $request)
    {
        $user = $request->user;
        return $this->item($user, new UserTransformer);
    }

}