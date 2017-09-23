<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 6/13/2017
 * Time: 8:29 PM
 */

namespace App\Repositories;

use App\Models\ProductCategory;
use App\Models\User;

class UserRepository extends BaseRepository
{
    protected function getModel()
    {
        return new User();
    }

    public function revokeRefreshToken($id)
    {
        $this->database->table('oauth_refresh_tokens')
            ->where('access_token_id', $id)
            ->update([
                'revoked' => true
            ]);
    }

    public function getProducts($userId)
    {
        return $this->getBuilder()->find($userId)->products()->get();
    }

    public function getCategoriedProduct($userId)
    {
        $products = $this->getProducts($userId);
        $categories = ProductCategory::all();
        foreach ($categories as $c) {
            $temp = [];
            foreach ($products as $p) {
                if($p->category_id == $c->id)
                    $temp[] = $p;
            }
            $c['products'] = $temp;
        }
        return $categories;
    }

    public function getOrderProducts($userId)
    {
        return User::find($userId)->products()
            ->whereIn('type', ['order', 'stock_order'])
            ->get();
    }

    public function getStockProducts($userId)
    {
        return User::find($userId)->products()
            ->whereIn('type', ['stock', 'stock_order', 'stock_kg'])
            ->get();
    }

    public function getRequest($userId)
    {
        return User::find($userId)->requests()
            ->where('status', '=', '1')
            ->get();
    }


}