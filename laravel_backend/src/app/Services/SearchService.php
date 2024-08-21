<?php

namespace App\Services;

use App\Repositories\KeywordRepository;
use App\Repositories\ResultRepository;
use App\Repositories\SearchRepository;

class SearchService extends BaseService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private GoogleSearchService $googleSearchService,
        private YahooJapanService $yahooJapanService,
        private SearchRepository $searchRepo,
        private KeywordRepository $keywordRepo,
        private ResultRepository $resultRepo,
    ) { }

    public function handle(array $attributes = []) {
        $queries = data_get($attributes, 'query', []);
        $domain = data_get($attributes, 'url', '');

        [$data, $keywordNoData] = $this->handleQueries($queries, $domain);
        if ($keywordNoData) {
            $dataGoogle = $this->googleSearchService->search($keywordNoData, $domain);
            $dataYahoo = $this->yahooJapanService->search($keywordNoData, $domain);

            $data = array_merge_recursive($data, $dataGoogle, $dataYahoo);
        }
        return $data;
    }

    private function handleQueries(array $queries = [], string $domain = '') {
        $data = [];
        $keywordNoData = [];

        foreach ($queries as $query) {
            $dataKeyWord = $this->getRankingFromDB(rawurldecode($query), $domain);

            if (empty($dataKeyWord)) {
                array_push($keywordNoData, $query);
                continue;
            }

            $data[rawurldecode($query)] = [
                'google' => [
                    'ranking' => data_get($dataKeyWord, 'google_ranking', 'out of rank'),
                    'totalResult' => data_get($dataKeyWord, 'google_total_result', '0'),
                ],
                'yahoo' => [
                    'ranking' => data_get($dataKeyWord, 'yahoo_ranking', 'out of rank'),
                    'totalResult' => data_get($dataKeyWord, 'yahoo_total_result', '0'),
                ],
            ];
        }

        return [$data, $keywordNoData];
    }

    private function getRankingFromDB(string $query = '', string $domain = '') {
        $searches = $this->searchRepo->getSearchIdsByDomain($domain);
        if (empty($searches)) {
            return null;
        }

        $keyword = $this->keywordRepo->getKeywordOnSearcheIds($query, $searches->pluck('id')->toArray());
        if (empty($keyword->result)) {
            return null;
        }

        return $keyword->result;
    }
}
