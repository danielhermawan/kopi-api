<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 7/12/2017
 * Time: 4:48 PM
 */

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface ProductContract
{
    public function getAll(): Collection;
    public function checkStock(int $idProduct, int $idUser, int $quantity): bool;
}