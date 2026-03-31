<?php

namespace App\Jobs;

use App\Services\CatalogGenerator\CatalogGeneratorService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateAuctionCatalogJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 180; // 3 minutes
    protected int $auctionId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $auctionId)
    {
        $this->auctionId = $auctionId;
    }

    public function getAuctionId(): int
    {
        return $this->auctionId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
          $catalogGeneratorService = app(CatalogGeneratorService::class);
        // $catalogGeneratorService->generateCatalogPDF(CatalogGeneratePdfType::AUCTION, $this->auctionId);
         $catalogGeneratorService->generateAuctionCatalogueNew($this->auctionId);
    }
}
