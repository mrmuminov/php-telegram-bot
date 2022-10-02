<?php

namespace Repositories;

use App;
use Models\BaseModel;
use Yiisoft\ActiveRecord\ActiveQuery;
use Yiisoft\ActiveRecord\ActiveRecordFactory;
use Yiisoft\Db\Connection\ConnectionInterface;

abstract class BaseRepository implements RepositoryInterface
{
    public ConnectionInterface $db;
    public ?ActiveRecordFactory $arFactory;
    public ?string $modelClass = null;
    protected ?ActiveQuery $_query = null;

    public function __construct(?ConnectionInterface $db = null, ActiveRecordFactory $arFactory = null)
    {
        $this->db = $db ?? App::$database::$connection;
        $this->arFactory = $arFactory;
    }


    public function query(): ActiveQuery
    {
        if (is_null($this->_query)) {
            $this->_query = new ActiveQuery($this->modelClass, $this->db, $this->arFactory);
        }
        return $this->_query;
    }

    public function model(): BaseModel
    {
        return new $this->modelClass($this->db, $this->arFactory);
    }

}