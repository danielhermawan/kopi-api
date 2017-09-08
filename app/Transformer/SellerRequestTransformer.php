<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 7/26/2017
 * Time: 5:31 PM
 */

namespace App\Transformer;


use App\Models\Request;
use Illuminate\Support\Facades\DB;
use League\Fractal\TransformerAbstract;

class SellerRequestTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['product', 'seller'];
    protected $defaultIncludes = [];

    public function transform($request): array
    {
        $sum = DB::select('SELECT SUM (p.purchase_price * rp.quantity) AS total 
              FROM request_product rp INNER JOIN products p On p.id = rp.product_id
              WHERE request_id = ?', [$request->id])[0]->total;
        return [
            "id" => $request->id,
            "total" => $sum,
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