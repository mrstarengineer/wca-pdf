<?php

namespace App\Services\CatalogGenerator;

use App\Enums\CatalogGeneratePdfType;
use App\Models\Auction;
use App\Models\Catalogue;
use App\Models\Vehicle;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use PDF;
use Carbon\Carbon;
use Webklex\PDFMerger\Facades\PDFMergerFacade;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;

class CatalogGeneratorService extends BaseService
{
    private const TEMPLATES = [
        CatalogGeneratePdfType::BUY_NOW => [
            'temp' => 'app/uploads/buy_now_catalogs/tmp',
            'pdf_catalog_view' => 'pdf.auction.manual_catalog_pdf',
            'merge_pages' => [[1, 2], 'all', [4]] // Format: [prefix pages, content, suffix pages]
        ],
        CatalogGeneratePdfType::AUCTION => [
            'temp' => 'app/uploads/auction_catalogs/tmp',
            'pdf_catalog_view' => 'pdf.auction.catalog_pdf',
            'merge_pages' => ['all', 'all'] // Format: [template pages, content]
        ]
    ];

    /**
     * Generate catalog based on type
     *
     * @param string $type 'buy_now' or 'auction'
     * @param int $id Catalog or Auction ID
     * @param array|null $vehicleIds Optional vehicle IDs for buy now catalog
     * @return string Generated catalog URL
     * @throws \RuntimeException
     */
    public function generateCatalogPDF(string $type, int $id, ?array $vehicleIds = null): string
    {
        try {
            $this->validateTypePresentTemplate($type);
            $template = self::TEMPLATES[$type];

            [
                'model' => $model,
                'view_data' => $viewData,
                'final_path' => $finalPath
            ] = $this->generateProcessingData($type, $id, $vehicleIds);

            /* Generate PDF which only have the content
            *  and will save it to temporary path to merge with company layout pages */
            $contentPdf = $this->generateContentPdf($template['pdf_catalog_view'], $viewData);

            /* Setup Temp file path for temporary generate the PDF
            *  before merging with company layout pages with checking if the directory exists */
            $tempFilePath = $this->setupTempFilePath($type, $id);

            /* PDF Saved to temporary folder ( /tmp) to process further*/
            $contentPdf->save($tempFilePath);
            Log::info("PDF content saved to temporary path: {$tempFilePath}");

            /* Get the freshed saved PDF from temporary folder path,
            *  and merge company layout with it */
            $this->mergePdfs($type, $tempFilePath);

            /* Get the pdf from temp folder and upload to the s3 destination ( final path) */
            $this->handleS3StorageUpload($tempFilePath, $finalPath);

            $this->handleDatabaseRecordUpdate($type, $model, $finalPath);

            // Cleanup, mainly delete the temp file
            $this->cleanup($tempFilePath);

            return Storage::disk('s3')->url($finalPath);

        } catch (\Exception $e) {
            Log::error("Error generating {$type} catalog: " . $e->getMessage(), [
                'id' => $id,
                'trace' => $e->getTraceAsString()
            ]);
            throw new \RuntimeException("Failed to generate {$type} catalog: {$e->getMessage()}", 0, $e);
        }
    }

    private function validateTypePresentTemplate(string $type): void
    {
        if (!isset(self::TEMPLATES[$type])) {
            throw new \InvalidArgumentException("Invalid catalog type: {$type}");
        }
    }

    private function generateProcessingData(string $type, int $id, ?array $vehicleIds): array
    {
        if ($type === CatalogGeneratePdfType::BUY_NOW) {
            $catalogue = Catalogue::findOrFail($id);
            $vehicles = Vehicle::whereIn('id', $vehicleIds)->get();

            return [
                'model' => $catalogue,
                'view_data' => compact('vehicles'),
                'final_path' => "uploads/bnc/{$id}.pdf"
            ];
        }

        if ($type === CatalogGeneratePdfType::AUCTION) {
            $auction = Auction::with('auction_vehicles.vehicle.vehicle_images')->findOrFail($id);
            $auctionDate = Carbon::parse($auction->auction_at)->format('d-m-Y');
            $day = Carbon::parse($auction->auction_at)->format('l');

            return [
                'model' => $auction,
                'view_data' => compact('auction', 'auctionDate', 'day'),
                'final_path' => "uploads/auction_catalogs/{$id}.pdf"
            ];
        }
    }

    private function generateContentPdf(string $view, array $data): \Barryvdh\DomPDF\PDF
    {
        return PDF::setOptions(['isRemoteEnabled' => true])->loadView($view, $data);
    }

    private function setupTempFilePath(string $type, int $id): string
    {
        $tempPath = storage_path(self::TEMPLATES[$type]['temp']);
        if (!file_exists($tempPath)) {
            mkdir($tempPath, 0777, true);
        }
        return "{$tempPath}/{$id}.pdf";
    }

    private function mergePdfs(string $type, string $tempFilePath): void
    {
        /* @var PDFMergerFacade $merger */
        $merger = PDFMergerFacade::init();

        if ($type === CatalogGeneratePdfType::BUY_NOW) {
            $this->mergeBuyNowCatalogueWithExistingPdf($merger, $tempFilePath);
        }

        if ($type === CatalogGeneratePdfType::AUCTION) {
            $this->mergeAuctionCatalogueWithExistingPdf($merger, $tempFilePath);
        }

        $merger->merge();
        $merger->save($tempFilePath);
    }

    private function mergeBuyNowCatalogueWithExistingPdf($oMerger, string $tempFilePath): void
    {
        $oMerger->addPDF(public_path('uploads/auctions/buy_now_catalogue.pdf'), [1, 2]);
        $oMerger->addPDF($tempFilePath, 'all');
        $oMerger->addPDF(public_path('uploads/auctions/buy_now_catalogue.pdf'), [4]);
    }

    private function mergeAuctionCatalogueWithExistingPdf($oMerger, string $tempFilePath): void
    {
        $oMerger->addPDF(public_path('uploads/auctions/auction_catalogue.pdf'), 'all');
        $oMerger->addPDF($tempFilePath, 'all');
    }

//    private function handleS3StorageUpload(string $tempFilePath, string $finalPath): void
//    {
//        $upload = Storage::disk('s3')->put($finalPath, file_get_contents($tempFilePath));
//        Log::info("PDF uploaded ({$upload}) to S3 at: {$finalPath}");
//    }

    private function handleS3StorageUpload(string $tempFilePath, string $finalPath): void
    {
        if (!file_exists($tempFilePath)) {
            Log::error("Temp file does not exist: {$tempFilePath}");
            throw new \RuntimeException("Temp file not found: {$tempFilePath}");
        }

        $fileSize = filesize($tempFilePath);
        Log::info("Attempting to upload file. Path: {$tempFilePath}, Size: {$fileSize}");

        $upload = Storage::disk('s3')->put($finalPath, file_get_contents($tempFilePath));

        if (!$upload) {
            Log::error("Failed to upload PDF to S3 at path: {$finalPath}");
            throw new \RuntimeException("S3 upload failed for path: {$finalPath}");
        }

        Log::info("PDF uploaded successfully to S3 at: {$finalPath}");
    }

    private function handleDatabaseRecordUpdate(string $type, Model $model, string $uploadedPath): void
    {
        if ($type === CatalogGeneratePdfType::BUY_NOW) {
            /* @var Catalogue $model */
            $model->update(['file' => $uploadedPath]);
        } else {
            /* @var Auction $model */
            $model->update(['catalog_url' => $uploadedPath]);
        }
    }

    private function cleanup(string $tempFilePath): void
    {
        if (file_exists($tempFilePath)) {
            unlink($tempFilePath);
        }
    }

    public function generateAuctionCatalogueNew($auctionId)
    {

        try {

            ini_set('memory_limit', '6G');
            ini_set('max_execution_time', 1200);
            set_time_limit(1200);

            $auctionData = Auction::with('auction_vehicles.vehicle')->find($auctionId);

            $date = Carbon::parse(data_get($auctionData, 'auction_at'));

            // Get formatted date and day
            $formattedDate = strtoupper($date->format('d F Y'));
            $timeFormatted = $date->format('g:i A');
            $dayOfWeek = strtoupper($date->format('l')). '  Auction';

            // PDF Page one TODO:: need to optimize later
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::setOptions([ 'defaultFont' => 'sans-serif', 'isRemoteEnabled' => true ])
                ->loadView('pdf.auction.new_catalogue_page_one', compact('formattedDate', 'dayOfWeek', 'timeFormatted'))
                ->setPaper('a4', 'landscape');

            $path = 'uploads/auction_catalogs/tmp_one';
            $tempPath = storage_path('app' . DIRECTORY_SEPARATOR . $path);
            if ( !file_exists(dirname($tempPath)) ) {
                mkdir(dirname($tempPath), 0777, true);
            }

            $fileName_one = $path . DIRECTORY_SEPARATOR . $auctionId . '.pdf';
            if ( Storage::disk('local')->exists($fileName_one) ) {
                Storage::disk('local')->delete($fileName_one);
            }
            $pdf->save(Storage::disk('local')->path($fileName_one));


            $total_car = count(data_get($auctionData, 'auction_vehicles'));
            // PDF Page two TODO:: need to optimize later
            $pdf_two = PDF::setOptions([ 'defaultFont' => 'sans-serif', 'isRemoteEnabled' => true ])
                ->loadView('pdf.auction.new_catalogue_page_two', compact('total_car'))
                ->setPaper('a4', 'landscape');

            $path = 'uploads/auction_catalogs/tmp_two';
            $tempPath = storage_path('app' . DIRECTORY_SEPARATOR . $path);
            if ( !file_exists(dirname($tempPath)) ) {
                mkdir(dirname($tempPath), 0777, true);
            }

            $fileName_two = $path . DIRECTORY_SEPARATOR . $auctionId . '.pdf';
            if ( Storage::disk('local')->exists($fileName_two) ) {
                Storage::disk('local')->delete($fileName_two);
            }
            $pdf_two->save(Storage::disk('local')->path($fileName_two));

            // PDF Page two TODO:: need to optimize later
            $pdf_three = PDF::setOptions([ 'defaultFont' => 'sans-serif', 'isRemoteEnabled' => true ])
                ->loadView('pdf.auction.new_catalogue', compact('auctionData'))
                ->setPaper('a4', 'landscape');

            $path = 'uploads/auction_catalogs/tmp_three';
            $tempPath = storage_path('app' . DIRECTORY_SEPARATOR . $path);
            if ( !file_exists(dirname($tempPath)) ) {
                mkdir(dirname($tempPath), 0777, true);
            }

            $fileName_three = $path . DIRECTORY_SEPARATOR . $auctionId . '.pdf';
            if ( Storage::disk('local')->exists($fileName_three) ) {
                Storage::disk('local')->delete($fileName_three);
            }
            $pdf_three->save(Storage::disk('local')->path($fileName_three));


            $destinationPath = 'uploads/auction_catalogs/' . $auctionId . '.pdf';

            // merge with existing pdf
            /* @var \Webklex\PDFMerger\PDFMerger $oMerger */
            $oMerger = PDFMerger::init();
            $oMerger->addPDF(Storage::disk('local')->path($fileName_one), 'all');
            $oMerger->addPDF(Storage::disk('local')->path($fileName_two), 'all');
            $oMerger->addPDF(Storage::disk('local')->path('uploads/auction_catalogs/static_page/page_three_pdf.pdf'), 'all');
            $oMerger->addPDF(Storage::disk('local')->path($fileName_three), 'all');
            $oMerger->merge();
            $oMerger->save(Storage::disk('local')->path($destinationPath));


            Storage::disk('s3')->put($destinationPath, file_get_contents(Storage::disk('local')->path($destinationPath)));

            // delete pdf file
            Storage::disk('local')->delete($fileName_one);
            Storage::disk('local')->delete($fileName_two);
            Storage::disk('local')->delete($destinationPath);

            $auctionData->update([ 'catalog_url' => $destinationPath ]);

        } catch ( \Exception $e ) {

            Log::info('pdf generate failed'. $e->getMessage());
            //return response()->json([ 'success' => false, 'message' => 'pdf generate failed', 'error' => $e->getMessage() ], 400);
        }
    }
}
