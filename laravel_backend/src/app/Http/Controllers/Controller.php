<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function json($data, int $code = 200, array $header = []) {
        return response()->json($data, $code, $header);
    }
}
