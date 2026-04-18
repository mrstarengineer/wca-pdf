<?php

namespace App\Jobs;

use App\Models\Auction;
use App\Services\AuctionCatalogueService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use mysql_xdevapi\Exception;

class GenerateAuctionCatalogJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 1200;
    public $tries = 1;

    protected int $auctionId;

    public function __construct(int $auctionId)
    {
        $this->auctionId = $auctionId;
    }

    public function handle()
    {
        Log::info('JOB START: ' . $this->auctionId);

        try {
            $auctionData = Auction::findOrFail($this->auctionId);

            $service = new AuctionCatalogueService();

            $destinationPath = $service->generate($auctionData);

            $auctionData->update([
                'catalog_url' => $destinationPath
            ]);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }

        Log::info('JOB END: ' . $this->auctionId);
    }
}
