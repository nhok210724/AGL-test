<?php

namespace App\Services;

use App\Repositories\SearchRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GoogleSearchService extends BaseService
{
    private string $apiKey = 'AIzaSyDE8_Y5QYpoLE-aO4lGr_nsFs9ablKP7wY';
    private string $cx = '421881ef48af64290';
    private string $urlApi = 'https://www.googleapis.com/customsearch/v1';

    /**
     * Create a new class instance.
     */
    public function __construct(
        private SearchRepository $searchRepo,
    ) { }

    public function search(array $queris = [], string $domain = '') {
        $data = [];
        foreach ($queris as $value) {
            [$rank, $totalResult] = $this->getDataGoogleByApi($value, $domain);
            $data[rawurldecode($value)] = [
                'google' => [
                    'ranking' => $rank,
                    'totalResult' => $totalResult,
                ],
            ];
        }
        return $data;
    }

    private function getDataGoogleByApi(string $query = '', string $domain = '') {
        $results = [];
        $totalResult = 0;

        //call first
        $urlCall = $this->addParamToURL($query, $domain, 1);
        $response = file_get_contents($urlCall);
        $data = json_decode($response, true);

        if (!$totalResult = data_get($data, 'searchInformation.formattedTotalResults', 0)) {
            $this->saveToDB($domain, rawurldecode($query));
            return ['out of rank', $totalResult];
        }

        $results = array_merge($results, data_get($data, 'items', []));

        //call second
        $urlCall = $this->addParamToURL($query, $domain, 11);
        $response = file_get_contents($urlCall);
        $data = json_decode($response, true);

        $results = array_merge($results, data_get($data, 'items', []));

        foreach ($results as $index => $item) {
            if (strpos($item['link'], $domain) !== false) {
                $this->saveToDB(
                    $domain,
                    rawurldecode($query),
                    ($index + 1),
                    data_get($data, 'searchInformation.totalResults', 0)
                );
                return [($index + 1), $totalResult];
            }
        }

        $this->saveToDB(
            $domain,
            rawurldecode($query),
            0,
            data_get($data, 'searchInformation.totalResults', 0)
        );
        return ['out of rank', $totalResult];
    }

    private function convertURL(): string {
        return "{$this->urlApi}?key={$this->apiKey}&cx={$this->cx}";
    }

    private function addParamToURL(string $query = '', string $domain = '', int $start = 1): string {
        // return $this->convertURL() . "&q={$query}&linkSite={$domain}&start={$start}";
        return $this->convertURL() . "&q={$query}&start={$start}";
    }

    private function saveToDB(string $domain = '', string $keyword = '', int $ranking = 0, int $totalResult = 0) {
        try {
            DB::beginTransaction();
            $search = $this->searchRepo->getOrCreate($domain);
            $keywordModel = $search->keywords()->create([
                'keyword' => $keyword,
            ]);
            $keywordModel->result()->updateOrCreate([
                'keyword_id' => $keywordModel->id,
                'google_rank' => $ranking,
                'google_total_hits' => $totalResult,
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
        }

    }
}
