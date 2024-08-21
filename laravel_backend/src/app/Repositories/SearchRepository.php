<?php

namespace App\Repositories;

class SearchRepository extends BaseRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function getSearchIdsByDomain(string $domain = '') {
        if (!$domain) {
            return null;
        }

        return $this->model->where('url', 'like', "%{$domain}%")->get('id');
    }

    public function getOrCreate(string $domain = '') {
        $searches = $this->getSearchIdsByDomain($domain);
        if ($searches->isEmpty()) {
           return $this->model->create(['url' => $domain]);
        }
        return $searches->first();
    }

    protected function getModel()
    {
        return app('App\Models\Search');
    }
}
