<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Services\AuctionCatalogueService;

class TestController extends Controller
{


    public function test()
    {
        $auctionId = 29;

        $auctionData = Auction::with('auction_vehicles.vehicle')
            ->findOrFail($auctionId);

        $service = new AuctionCatalogueService();

        $destinationPath = $service->generate($auctionData);

        $updated = $auctionData->update([
            'catalog_url' => $destinationPath
        ]);

        dd($updated);


    }



}
