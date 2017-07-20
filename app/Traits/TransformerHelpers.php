<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 8/23/2016
 * Time: 1:48 PM
 */

namespace App\Traits;

use App\CustomSerializer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use League\Fractal\Manager;
use League\Fractal\Pagination\Cursor;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;
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
        return new CustomSerializer();
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
    public function transformItem(Model $item, TransformerAbstract $transformer, string $key=null)
    {
        $manager = $this->getManager();
        $resource = new Item($item, $transformer, $key);
        return $manager->createData($resource)->toArray();
    }

    /**
     * Transform item using transformer class
     *
     * @param \Illuminate\Database\Eloquent\Collection $item
     * @param \League\Fractal\TransformerAbstract $transformer
     * @param string $key
     * @return array
     */
    public function transformCollection($item, TransformerAbstract $transformer, string $key=null)
    {
        $manager = $this->getManager();
        $resource = new Collection($item, $transformer, $key);
        return $manager->createData($resource)->toArray();
    }

    /**
     * Make cursor collection
     * 
     * @param \Illuminate\Support\Collection $model
     * @param \League\Fractal\TransformerAbstract $transformer
     * @param int $count
     * @param string $key
     * @return array
     */
    public function cursorCollection($model, $transformer, $count, $key=null)
    {
        $newCursor = $this->getCurrentCursor() + $this->getLimit();
        $cursor = new Cursor($this->getCurrentCursor(), $this->getPreviosCursor(), $newCursor, $count);
        $manager = $this->getManager();
        $resource = new Collection($model, $transformer, $key);
        $resource->setCursor($cursor);
        return $manager->createData($resource)->toArray();
    }

    /**
     * Make paginate collection
     *
     * @param LengthAwarePaginator $paginator
     * @param TransformerAbstract $transformer
     * @param string|null $key
     * @return array
     */
    public function paginateCollection(LengthAwarePaginator $paginator, TransformerAbstract $transformer, string $key=null): array
    {
        $collection = new Collection($paginator->items(), $transformer, $key);
        $collection->setPaginator(new IlluminatePaginatorAdapter($paginator));
        return $this->getManager()->createData($collection)->toArray();
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