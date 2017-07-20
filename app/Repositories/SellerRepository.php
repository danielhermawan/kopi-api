<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 7/20/2017
 * Time: 7:12 PM
 */

namespace App\Repositories;


use App\Models\Product;
use App\Models\User;
use App\Repositories\Contracts\SellerContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Collection;

class SellerRepository implements SellerContract
{

    /**
     * @var Connection
     */
    private $db;

    /**
     * @var \Illuminate\Database\Eloquent\Builder
     */
    private $user;

    /**
     * OrderRepository constructor.
     * @param Connection $db
     * @param User $user
     */
    public function __construct(Connection $db, User $user)
    {

        $this->db = $db;
        $this->user = $user->newQuery();
    }

    public function getAll(): Collection
    {
        return $this->user->get();
    }

    public function getPaginate(int $limit = 15): LengthAwarePaginator
    {
        return $this->user->paginate($limit);
    }

    public function getDetail(int $id): User
    {
        return User::find($id);
    }

    public function create($data): User
    {
        $user = new User;
        $user->username = $data['username'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['passsword']);
        $user->name = $data['name'];
        $user->phone_number = $data['phone_number'];
        $user->gender = $data['gender'];
        $user->address = $data['address'];
        $user->save();
        return $user;
    }

    public function update(int $id, $data): User
    {
        $user = User::find($id);
        $user->username = $data['username'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['passsword']);
        $user->name = $data['name'];
        $user->phone_number = $data['phone_number'];
        $user->gender = $data['gender'];
        $user->address = $data['address'];
        $user->save();
        return $user;
    }

    public function delete($id)
    {
        User::destroy($id);
    }

    public function attachProduct(Product $product)
    {
        $sellers = $this->getAll();
        foreach ($sellers as $s) {
            $s->products()->attach($product->id, [
                'quantity' => 0
            ]);
        }
    }
}