<?php

use Illuminate\Support\Facades\Route;

Route::get('/search', 'SearchAPIController@handleApi');
