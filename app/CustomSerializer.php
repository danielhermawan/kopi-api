<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 6/16/2017
 * Time: 6:14 PM
 */

namespace App;


use League\Fractal\Resource\ResourceInterface;
use League\Fractal\Serializer\ArraySerializer;

class CustomSerializer extends ArraySerializer
{
    /**
     * Serialize a collection.
     *
     * @param string $resourceKey
     * @param array $data
     *
     * @return array
     */
    public function collection($resourceKey, array $data)
    {
        if($resourceKey == null)
            return $data;
        else
            return [$resourceKey => $data];
    }

    /**
     * Serialize the included data.
     *
     * @param ResourceInterface $resource
     * @param array $data
     *
     * @return array
     */
    public function includedData(ResourceInterface $resource, array $data)
    {
        if($resource->getResourceKey() == null)
            return $data;
        else
            return [$resource->getResourceKey() => $data];
    }

}