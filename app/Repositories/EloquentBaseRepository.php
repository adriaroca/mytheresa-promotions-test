<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use RuntimeException;

abstract class EloquentBaseRepository
{
    private $app;
    protected $model;

    /**
     * EloquentRepository constructor.
     */
    public function __construct()
    {
        $this->app = app();
        $this->makeModel();
    }

    /**
     * @return mixed
     */
    abstract public function model() : String;

    /**
     * @return Model
     * @throws RuntimeException
     */
    private function makeModel() : Model
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new RuntimeException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }
}