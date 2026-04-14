<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use PDF;
use Illuminate\Support\Facades\Storage;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;

class AuctionCatalogueService
{
    public function generate($auctionData)
    {
        ini_set('memory_limit', '1G');
        set_time_limit(1200);

        $auctionId = $auctionData->id;

        $date = Carbon::parse($auctionData->auction_at);

        $baseData = [
            'formattedDate' => strtoupper($date->format('d F Y')),
            'timeFormatted' => $date->format('g:i A'),
//            'dayOfWeek'     => strtoupper($date->format('l')) . ' Auction',
            'dayOfWeek'     => 'Sunday Auction',
            'totalCar'      => $auctionData->auction_vehicles()->count(),
        ];

        $files = [];

        $files[] = $this->generatePdf('pdf.catalogue.page_one', [
            ...$baseData,
            'auctionData' => $auctionData
        ], "tmp_one/$auctionId.pdf");

        $files[] = $this->generatePdf('pdf.catalogue.page_two', [], "tmp_two/$auctionId.pdf");

        $chunkIndex = 1;

        $auctionData->auction_vehicles()
            ->with('vehicle')
            ->chunk(50, function ($vehicles) use (&$files, $auctionData, $baseData, $auctionId, &$chunkIndex) {

                Log::info("Processing chunk {$chunkIndex}");

                $chunkAuction = clone $auctionData;

                $chunkAuction->setRelation('auction_vehicles', $vehicles);

                $files[] = $this->generatePdf(
                    'pdf.catalogue.page_three',
                    [
                        ...$baseData,
                        'auctionData' => $chunkAuction
                    ],
                    "tmp_chunk_{$auctionId}_{$chunkIndex}.pdf"
                );

                $chunkIndex++;

                unset($vehicles, $chunkAuction);
                gc_collect_cycles();
            });

        $finalPath = "uploads/auction_catalogs/$auctionId.pdf";

        $this->mergePdfs($files, $finalPath);

        $fullPath = storage_path("app/$finalPath");

        Storage::disk('s3')->put($finalPath, fopen($fullPath, 'r'));

        $this->cleanup(array_merge($files, [$fullPath]));

        Log::info('PDF DONE: ' . $finalPath);

        return $finalPath;
    }

    private function generatePdf($view, $data, $relativePath)
    {
        $fullPath = storage_path("app/uploads/auction_catalogs/$relativePath");

        if (!file_exists(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0777, true);
        }

        if (file_exists($fullPath)) {
            unlink($fullPath);
        }

        PDF::setOptions([
            'defaultFont' => 'sans-serif',
            'isRemoteEnabled' => true
        ])
            ->loadView($view, $data)
            ->setPaper('a4', 'landscape')
            ->save($fullPath);

        return $fullPath;
    }

    private function mergePdfs($files, $destinationPath)
    {
        $fullPath = storage_path("app/$destinationPath");

        if (!file_exists(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0777, true);
        }

        $merger = PDFMerger::init();

        foreach ($files as $file) {
            $merger->addPDF($file, 'all');
        }


        $merger->merge();
        $merger->save($fullPath);
    }

    private function cleanup($files)
    {
        foreach ($files as $file) {
            if (file_exists($file)) {
                unlink($file);
            }
        }
    }
}
