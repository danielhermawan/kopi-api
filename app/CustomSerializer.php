<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 6/16/2017
 * Time: 6:14 PM
 */

namespace App;


use League\Fractal\Serializer\ArraySerializer;

class CustomSerializer extends ArraySerializer
{
    public function collection($resourceKey, array $data)
    {
        return ($resourceKey && $resourceKey !== 'data') ? array($resourceKey => $data) : $data;
    }

    public function item($resourceKey, array $data)
    {
        return ($resourceKey && $resourceKey !== 'data') ? array($resourceKey => $data) : $data;
    }
}