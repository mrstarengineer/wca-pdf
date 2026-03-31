<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="charset=utf-8"/>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Example</title>
    <style>
        @page {
            margin: 0;
            padding: 0;
            size: 38.1cm 38.1cm;
        }

        .page-break {
            page-break-after: always;
        }

        @font-face {
            font-family: 'Modern No. 20';
            src: url({{ storage_path("fonts/ModernNo20.ttf") }}) format("truetype");
            font-weight: 700;
            font-style: normal;
        }

        @font-face {
            font-family: 'News 706';
            src: url({{ storage_path("fonts/news706.ttf") }}) format("truetype");
            font-weight: 700;
            font-style: normal;
        }

        body {
            margin: 0;
            font-family: 'Modern No. 20', sans-serif;
        }

        .white-photo-container {
            width: 100%;
            height: 180px;
            overflow: hidden;
            background-color: #ffffff;
            padding-left: 20px;
            padding-right: 20px;
        }

        .photo-container {
            width: 100%;
            height: 180px;
            overflow: hidden;
            background-color: #e0dede;
        }

        .photo-left,
        .photo-right {
            width: 30%; /* Adjust width as needed */
            margin-top: -90px;
        }

        .photo-left {
            float: left;
        }

        .photo-right {
            float: right;
            margin-right: 20px;
        }

        .bm-photo-left,
        .bm-photo-right {
            width: 30%; /* Adjust width as needed */
        }

        .bm-photo-left {
            float: left;
        }

        .bm-text-left {
            float: left;
            width: 35%;
        }

        .bm-photo-right {
            float: right;
        }

        img {
            width: 100%;
            height: auto;
        }

        .clear {
            clear: both;
        }

        .header {
            height: 100px;
            background-color: #B11E24;
            color: white;
            display: table;
            width: 100%;
        }

        .full-header {
            background-color: #B11E24;
            color: white;
            width: 100%;
            padding-bottom: 50px;
        }

        .header-content {
            display: flex;
            padding-top: 30px;
            align-items: center;
        }

        .header-content .serial {
            font-size: 48px;
            display: inline-block;
            margin-left: 15px;
            font-weight: bold;
        }

        .header-content .title {
            font-size: 48px;
            display: inline-block;
            text-align: center;
            margin-left: 10%;
            font-weight: bold;
            overflow: hidden;
        }

        .main-content {
            position: relative;
        }

        .main-content img.full-width {
            width: 100%;
        }

        .main-content img.top-right {
            position: absolute;
            top: -25px;
            right: -45px;
            width: 400px; /* Adjust as needed */
            height: auto;
        }

        .main-content .top-right-text {
            position: absolute;
            top: 115px;
            right: 87px;
            color: white;
            font-weight: 700;
            font-size: 24px;
            width: 130px;
        }

        .footer {
            background-color: #B11E24;
            color: white;
            text-align: center;
            padding: 5px 0;
            font-size: 48px;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="white-photo-container">
    <div class="photo-left">
        @if( \Illuminate\Support\Facades\File::exists(public_path('uploads/auctions/gulf_english.png')) )
        <img
            src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('uploads/auctions/gulf_english.png')))}}"
            alt="Left Photo">
        @endif
    </div>
    <div class="photo-right">
        @if( \Illuminate\Support\Facades\File::exists(public_path('uploads/auctions/gulf_arabic.png')) )
        <img
            src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('uploads/auctions/gulf_arabic.png')))}}"
            alt="Right Photo">
        @endif
    </div>
    <div class="clear"></div>
</div>

<div class="full-header">
    <div class="content" style="padding: 25px 10px">
        <div class="" style="text-align: center;">
            @if( \Illuminate\Support\Facades\File::exists(public_path('uploads/auctions/'.strtolower($day).'.png')) )
            <img
                src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('uploads/auctions/'.strtolower($day).'.png')))}}">
            @endif
        </div>
        <h2 style="text-align: center; font-size: 70px; margin-top: -20px">{{$auctionDate}}</h2>
        <div class="" style="text-align: center">
            @if( \Illuminate\Support\Facades\File::exists(public_path('uploads/auctions/whiteG.png')) )
            <img style="width: 300px;"
                 src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('uploads/auctions/whiteG.png')))}}">
            @endif
        </div>
    </div>

    <div class="" style="margin-top: 20px;">
        <div class="bm-photo-left">
            @if( \Illuminate\Support\Facades\File::exists(public_path('uploads/auctions/bmw.png')) )
            <img style="width: 95%; margin-left: 5%"
                 src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('uploads/auctions/bmw.png')))}}"
                 alt="Left Photo">
            @endif
        </div>
        <div class="bm-text-left"
             style="width: 40%; text-align: center; font-size: 62px; font-weight: bold; margin-left: 12px; font-family: 'Modern No. 20', sans-serif">
            <span style="font-size: 72px">Car Listing of</span>
            <br>
            {{ucfirst($day)}}'s Auction
            <br>
            {{$auctionDate}}</div>
        <div class="bm-photo-right">
            @if( \Illuminate\Support\Facades\File::exists(public_path('uploads/auctions/mercedez.png')) )
            <img style="width: 95%;"
                 src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('uploads/auctions/mercedez.png')))}}"
                 alt="Right Photo">
            @endif
        </div>
        <div class="clear"></div>
    </div>
</div>
<div class="">
    @if( \Illuminate\Support\Facades\File::exists(public_path('uploads/auctions/image_footer.png')) )
    <img
        src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('uploads/auctions/image_footer.png')))}}"
        alt="Right Photo">
    @endif
</div>
{{-- page end --}}

@foreach( $auction->auction_vehicles as $auctionVehicle )
    <div class="photo-container">
        <div class="photo-left">
            @if( \Illuminate\Support\Facades\File::exists(public_path('uploads/auctions/gulf_english.png')) )
            <img
                src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('uploads/auctions/gulf_english.png')))}}"
                alt="Left Photo">
            @endif
        </div>
        <div class="photo-right">
            @if( \Illuminate\Support\Facades\File::exists(public_path('uploads/auctions/gulf_arabic.png')) )
            <img
                src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('uploads/auctions/gulf_arabic.png')))}}"
                alt="Right Photo">
            @endif
        </div>
        <div class="clear"></div>
    </div>

    <div class="" style="padding-left: 20px; padding-right: 20px; background-color: #e0dede">
        <div class="header">
            <div class="header-content">
                <div class="serial">#{{$auctionVehicle->serial}}</div>
                <div class="title"
                     style="font-family: 'News 706'">{{ data_get( $auctionVehicle, 'vehicle.title' ) }}</div>
            </div>
        </div>

        <div class="main-content">
            @php
                $vehiclePhoto = public_path('uploads/images/car_default_thumbnail.jpg');
                if( !empty($auctionVehicle->vehicle->vehicle_images) && $auctionVehicle->vehicle->vehicle_images->first() && \Illuminate\Support\Facades\Storage::exists($auctionVehicle->vehicle->vehicle_images->first()->name) ) {
                    $vehiclePhoto = \Illuminate\Support\Facades\Storage::url(data_get($auctionVehicle->vehicle->vehicle_images->first(), 'name' ));
                }
            @endphp

            <img class="full-width" style="height: 1033px"
                 src="{{'data:image/png;base64,'.base64_encode(file_get_contents($vehiclePhoto))}}">
            @if( \Illuminate\Support\Facades\File::exists(public_path('uploads/auctions/img1.png')) )
            <img
                src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('uploads/auctions/img1.png')))}}"
                class="top-right">
            @endif
            <p class="top-right-text" style="font-weight: bold; font-family: 'News 706';">
                <span style="text-align: center; display: block">Starting</span>
                <span style="text-align: center; display: block">Bid</span>
                <span style="text-align: center; display: block;">{{ data_get( $auctionVehicle, 'vehicle.start_bid_amount' ) }} AED</span>
            </p>
        </div>

        <div class="footer">
            <div class="title">{{data_get($auctionVehicle, 'vehicle.odometer')}}
                Miles, {{ data_get($auctionVehicle, 'vehicle.highlight.name') }}
                , {{data_get($auctionVehicle, 'vehicle.engine_type.name')}},
                Keys: {{ data_get($auctionVehicle, 'vehicle.keys') == 1 ? 'Yes' : 'No'}}</div>
        </div>
        <div class="">
            <img
                src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('uploads/auctions/footer_car.png')))}}"
                alt="Car Footer">
        </div>
    </div>
@endforeach
</body>
</html>
