<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use PDF;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;

class TestController extends Controller
{

    public function test(){


//        $pdf = PDF::setOptions([
//            'defaultFont' => 'sans-serif',
//            'isRemoteEnabled' => true
//        ])
//            ->loadView('pdf.catalogue.page_three')
//            ->setPaper('a4', 'landscape');
//
//        return $pdf->stream('catalogue.pdf');

        $auctionId = 3;

        $auctionData = Auction::with('auction_vehicles.vehicle')->find($auctionId);

        $date = Carbon::parse(data_get($auctionData, 'auction_at'));

        // Get formatted date and day
        $formattedDate = strtoupper($date->format('d F Y'));
        $timeFormatted = $date->format('g:i A');
        $dayOfWeek = strtoupper($date->format('l')). '  Auction';

        $totalCar = 150;

        // PDF Page one TODO:: need to optimize later
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::setOptions([ 'defaultFont' => 'sans-serif', 'isRemoteEnabled' => true ])
            ->loadView('pdf.catalogue.page_one', compact('formattedDate', 'dayOfWeek', 'timeFormatted', 'totalCar'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream('catalogue.pdf');

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
    }
}
