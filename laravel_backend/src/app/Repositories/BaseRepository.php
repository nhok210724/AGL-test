<?php

namespace App\Repositories;

abstract class BaseRepository
{
    protected $model;

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->model = $this->getModel();
    }

    protected abstract function getModel();
}
