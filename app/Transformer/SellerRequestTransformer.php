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
        // todo: quantity * jumlah perkarton
        $products = DB::select('SELECT purchase_price, quantity 
              FROM request_product rp INNER JOIN products p On p.id = rp.product_id
              WHERE request_id = ?', [$request->id]);
        $sum = 0;
        foreach ($products as $p) {
            if($p->purchase_price != null)
                $sum += $p->purchase_price * $p->quantity;
        }
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