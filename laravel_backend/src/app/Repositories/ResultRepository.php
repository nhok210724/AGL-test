<?php

namespace App\Repositories;

class ResultRepository extends BaseRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function getResultByKeyword() {
        return $this->model;
    }

    protected function getModel()
    {
        return app('App\Models\Result');
    }

}
