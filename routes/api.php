<?php


use App\Jobs\GenerateAuctionCatalogJob;
use Illuminate\Support\Facades\Route;

Route::middleware('internal.token')->post('/generate-catalogue/{id}', function ( $id) {
    \Illuminate\Support\Facades\Log::info('Request for auction id '. $id);
//    \App\Jobs\GenerateAuctionCatalogJob::dispatch($id);
    dispatch(new GenerateAuctionCatalogJob($id))->onQueue('pdf');
    \Illuminate\Support\Facades\Log::info('After Job '. $id);
});


