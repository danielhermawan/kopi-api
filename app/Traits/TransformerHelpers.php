<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 8/23/2016
 * Time: 1:48 PM
 */

namespace App\Traits;

use League\Fractal\Manager;
use League\Fractal\Pagination\Cursor;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\DataArraySerializer;
use Request;

trait TransformerHelpers
{

    protected $currentCursor;
    protected $previousCursor;
    protected $limit;

    /**
     * @return mixed
     */
    public function getCurrentCursor()
    {
        if($this->currentCursor === null)
            $this->currentCursor = Request::input("cursor", 0);
        return $this->currentCursor;

    }

    /**
     * @return mixed
     */
    public function getPreviosCursor()
    {
        if($this->previousCursor === null)
            $this->previousCursor = Request::input("previous", null);
        return $this->previousCursor;
    }

    /**
     * @return mixed
     */
    public function getLimit()
    {
        if($this->limit === null)
            $this->limit = Request::input("limit", 10);
        return $this->limit;
    }

    public function getIncludeArray()
    {
        return explode(",", Request::input("include"));
    }

    public function getSerializer()
    {
        return new DataArraySerializer();
    }

    public function getManager()
    {
        $manager = new Manager();
        $manager->setSerializer($this->getSerializer());
        $include = Request::input("include");
        if($include !== null)
            $manager->parseIncludes($include);
        return $manager;
    }

    /**
     * Transform item using transformer class
     * 
     * @param \Illuminate\Database\Eloquent\Model $item
     * @param \League\Fractal\TransformerAbstract $transformer
     * @param string $key
     * @return array
     */
    public function transformItem($item, $transformer, $key="data")
    {
        $manager = $this->getManager();
        $resource = new Item($item, $transformer, $key);
        return $manager->createData($resource)->toArray();
    }

    /**
     * Make paginate collection
     * 
     * @param \Illuminate\Support\Collection $model
     * @param \League\Fractal\TransformerAbstract $transformer
     * @param int $count
     * @param string $key
     * @return array
     */
    public function paginateCollection($model , $transformer, $count, $key="data")
    {
        $newCursor = $this->getCurrentCursor() + $this->getLimit();
        $cursor = new Cursor($this->getCurrentCursor(), $this->getPreviosCursor(), $newCursor, $count);
        $manager = $this->getManager();
        $resource = new Collection($model, $transformer, $key);
        $resource->setCursor($cursor);
        return $manager->createData($resource)->toArray();
    }

    public function jsonReponse($body = [], $status = 200)
    {
        return response()->json($body, $status);
    }

    public function noContent()
    {
        return response(null, 204);
    }

}