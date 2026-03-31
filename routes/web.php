<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/generate-catalogue/{id}', function ($id) {

    \App\Jobs\GenerateAuctionCatalogJob::dispatch($id);
});

Route::get('/testing-pdf','App\Http\Controllers\TestController@test');
