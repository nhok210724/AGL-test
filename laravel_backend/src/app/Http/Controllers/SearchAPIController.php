<?php

namespace App\Http\Controllers;

use App\Services\SearchService;
use Illuminate\Http\Request;

class SearchAPIController extends Controller
{
    public function __construct(private SearchService $searchService) {
    }

    public function handleApi(Request $request) {
        $data = $this->searchService->handle($request->all());
        return $this->json($data);
    }
}
