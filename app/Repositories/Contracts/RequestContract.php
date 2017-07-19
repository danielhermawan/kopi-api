<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 7/19/2017
 * Time: 9:00 PM
 */

namespace App\Repositories\Contracts;

use App\Models\Request;

interface RequestContract
{
    /**
     * Create Request
     * @param int $userId
     * @param array $products
     * @return Request
     */
    public function create(int $userId, array $products): Request;
}