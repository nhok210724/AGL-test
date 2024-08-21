<?php

namespace App\Services;

class YahooJapanService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function search(array $queries = [], string $domain = '') {
        $data = [];
        foreach ($queries as $query) {
            $data[rawurldecode($query)] = [
                'yahoo' => [
                    'ranking' => 'out of rank',
                    'totalResult' => 0,
                ],
            ];
        }
        return $data;
    }
}
