<?php

namespace App\Repositories;

class KeywordRepository extends BaseRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function getKeywordOnSearcheIds(string $query = '', array $searchIds = []) {
        if (empty($query)) {
            return null;
        }

        return $this->model
            ->where('keyword', 'like', "%{$query}%")
            ->whereIn('search_id', $searchIds)
            ->with(['result'])
            ->first();
    }

    protected function getModel()
    {
        return app('App\Models\Keyword');
    }
}
