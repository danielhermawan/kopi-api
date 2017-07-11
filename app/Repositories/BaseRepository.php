<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 6/13/2017
 * Time: 10:18 PM
 */

namespace App\Repositories;


use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    protected $database;
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     * @param $database
     */
    public function __construct(DatabaseManager $database)
    {
        $this->database = $database;
        $this->model = $this->getModel();
    }

    abstract protected function getModel();


    public function getAll()
    {
        return $this->getBuilder()->get();
    }

    public function getWhere($key, $value, $isSingle = false)
    {
        $query = $this->getBuilder()->where($key, $value);
        if($isSingle)
            return $query->first();
        else
            return $query->get();
    }

    public function getInclude($include)
    {
        return $this->getBuilder()->eagerLoading($include)->get();
    }

    public function getBuilder()
    {
        return $this->model->newQuery();
    }
}