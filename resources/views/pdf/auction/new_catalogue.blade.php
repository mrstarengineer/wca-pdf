{{--@foreach(data_get($auctionData, 'auction_vehicles') as $key => $value)--}}
{{--    <!DOCTYPE html>--}}
{{--<html>--}}
{{--<head>--}}
{{--    <meta charset="utf-8">--}}
{{--    <title>Auction PDF</title>--}}

{{--    @php--}}
{{--        $bg = base64_encode(file_get_contents(public_path('uploads/images/catalogue_bg.jpg')));--}}
{{--        $vehiclePhoto = public_path('uploads/images/car_default_thumbnail.jpg');--}}

{{--        $imageArr = [];--}}
{{--        foreach(data_get($value, 'vehicle.vehicle_images') as $index => $image) {--}}
{{--            if (\Illuminate\Support\Facades\Storage::exists(data_get($image, 'name'))) {--}}
{{--                $imageArr[$index] = public_path(data_get($image, 'name'));--}}
{{--            } else {--}}
{{--                $imageArr[$index] = $vehiclePhoto;--}}
{{--            }--}}
{{--            if ($index == 4) break;--}}
{{--        }--}}

{{--        for ($i = count($imageArr); $i < 5; $i++) {--}}
{{--            $imageArr[$i] = $vehiclePhoto;--}}
{{--        }--}}
{{--    @endphp--}}

{{--    <style>--}}
{{--        @page {--}}
{{--            margin: 0;--}}
{{--        }--}}

{{--        body {--}}
{{--            margin: 0;--}}
{{--            padding: 0;--}}
{{--            font-family: sans-serif;--}}
{{--        }--}}

{{--        /* ✅ DOMPDF SAFE BACKGROUND */--}}
{{--        .page-bg {--}}
{{--            position: fixed;--}}
{{--            top: 0;--}}
{{--            left: 0;--}}
{{--            right: 0;--}}
{{--            bottom: 0;--}}

{{--            background-image: url('data:image/jpeg;base64,{{ $bg }}');--}}
{{--            background-size: cover;--}}
{{--            background-position: center;--}}
{{--            background-repeat: no-repeat;--}}

{{--            z-index: -1;--}}
{{--        }--}}

{{--        .logo-left {--}}
{{--            position: absolute;--}}
{{--            top: 20px;--}}
{{--            left: 30px;--}}
{{--            width: 300px;--}}
{{--            height: 100px;--}}
{{--        }--}}

{{--        .logo-right {--}}
{{--            position: absolute;--}}
{{--            top: 0;--}}
{{--            right: 45px;--}}
{{--            width: 200px;--}}
{{--            height: 150px;--}}
{{--        }--}}

{{--        .left-image {--}}
{{--            position: absolute;--}}
{{--            top: 150px;--}}
{{--            left: 30px;--}}
{{--            width: 55%;--}}
{{--            height: 60%;--}}
{{--            object-fit: cover;--}}
{{--            border-radius: 8px;--}}
{{--        }--}}

{{--        .right-grid {--}}
{{--            position: absolute;--}}
{{--            top: 150px;--}}
{{--            right: 30px;--}}
{{--            width: 40%;--}}
{{--            height: 70%;--}}
{{--        }--}}

{{--        .small_img {--}}
{{--            position: absolute;--}}
{{--            width: 48%;--}}
{{--            height: 50%;--}}
{{--            padding: 5px;--}}
{{--        }--}}

{{--        .small_img img {--}}
{{--            width: 100%;--}}
{{--            height: 100%;--}}
{{--            object-fit: cover;--}}
{{--            border-radius: 8px;--}}
{{--        }--}}

{{--        .bottom-title {--}}
{{--            position: absolute;--}}
{{--            bottom: 25px;--}}
{{--            left: 30px;--}}
{{--            color: #B11E24;--}}
{{--            font-weight: bold;--}}
{{--            font-size: 36px;--}}
{{--        }--}}

{{--        .qr_code_section {--}}
{{--            position: absolute;--}}
{{--            right: 35px;--}}
{{--            bottom: 15px;--}}
{{--            text-align: center;--}}
{{--        }--}}
{{--    </style>--}}
{{--</head>--}}

{{--<body>--}}

{{--<!-- ✅ Background -->--}}
{{--<div class="page-bg"></div>--}}

{{--<!-- Logos -->--}}
{{--<img class="logo-left"--}}
{{--     src="{{ 'data:image/png;base64,'.base64_encode(file_get_contents(public_path('uploads/auctions/logo_left.png'))) }}">--}}

{{--<img class="logo-right"--}}
{{--     src="{{ 'data:image/png;base64,'.base64_encode(file_get_contents(public_path('uploads/auctions/right_img.png'))) }}">--}}

{{--<!-- Starting Bid -->--}}
{{--<div style="position:absolute; top:5px; right:75px; color:white; font-weight:bold;">--}}
{{--    <div style="font-size:26px;">Starting</div>--}}
{{--    <div style="font-size:26px; margin-left:40px;">Bid</div>--}}
{{--    <div style="font-size:32px; margin-left:30px;">--}}
{{--        {{ number_format(data_get($value, 'start_bid_amount')) }}--}}
{{--    </div>--}}
{{--</div>--}}

{{--<!-- Main Image -->--}}
{{--<img class="left-image"--}}
{{--     src="{{ 'data:image/jpeg;base64,'.base64_encode(file_get_contents($imageArr[0])) }}">--}}

{{--<!-- Right Images -->--}}
{{--<div class="right-grid">--}}
{{--    <div class="small_img" style="left:0; top:0;">--}}
{{--        <img src="{{ 'data:image/jpeg;base64,'.base64_encode(file_get_contents($imageArr[1])) }}">--}}
{{--    </div>--}}
{{--    <div class="small_img" style="right:0; top:0;">--}}
{{--        <img src="{{ 'data:image/jpeg;base64,'.base64_encode(file_get_contents($imageArr[2])) }}">--}}
{{--    </div>--}}
{{--    <div class="small_img" style="left:0; bottom:0;">--}}
{{--        <img src="{{ 'data:image/jpeg;base64,'.base64_encode(file_get_contents($imageArr[3])) }}">--}}
{{--    </div>--}}
{{--    <div class="small_img" style="right:0; bottom:0;">--}}
{{--        <img src="{{ 'data:image/jpeg;base64,'.base64_encode(file_get_contents($imageArr[4])) }}">--}}
{{--    </div>--}}
{{--</div>--}}

{{--<!-- Vehicle Title -->--}}
{{--@php--}}
{{--    $title = data_get($value, 'vehicle.title');--}}
{{--    $isPureSale = data_get($value, 'vehicle.sale_type') == 3;--}}
{{--@endphp--}}

{{--<div class="bottom-title">--}}
{{--    @if ($isPureSale && strlen($title) > 31)--}}
{{--        {{ substr($title, 0, 28) }}...--}}
{{--    @elseif (strlen($title) > 38)--}}
{{--        {{ substr($title, 0, 38) }}...--}}
{{--    @else--}}
{{--        {{ $title }}--}}
{{--    @endif--}}
{{--</div>--}}

{{--<!-- QR -->--}}
{{--<div class="qr_code_section">--}}
{{--    <div style="letter-spacing:3px; font-weight:bold;">SCAN ME</div>--}}
{{--</div>--}}

{{--</body>--}}
{{--</html>--}}
{{--@endforeach--}}


@foreach(data_get($auctionData, 'auction_vehicles') as $key => $value)
    <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Auction PDF</title>

    @php
        $bg = base64_encode(file_get_contents(public_path('uploads/images/catalogue_bg.jpg')));
    @endphp

    <style>
        @page {
            margin: 0;
        }
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            font-family: sans-serif;
            position: relative;
            background-image: url('data:image/jpeg;base64,{{ $bg }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        .logo-left {
            position: absolute;
            top: 20px;
            left: 30px;
            width: 120px;
        }
        .logo-right {
            position: absolute;
            top: 0px;
            right: 45px;
            width: 120px;
        }
        .left-image {
            position: absolute;
            top: 150px;
            left: 30px;
            width: 55%;
            height: 60%;
            object-fit: cover;
        }
        .right-grid {
            position: absolute;
            top: 150px;
            right: 30px;
            width: 40%;
            height: 70%;
            display: table;
            table-layout: fixed;
            border-spacing: 10px;
        }

        .grid-cell img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .small_img img {
            height: 200px;
            width: 100%;
            border-radius: 8px
        }

    </style>
</head>


<body>
<img class="logo-left" src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('uploads/auctions/logo_left.png'))) }}" alt="Logo Left" style="width: 300px; height: 100px">
<img class="logo-right" src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('uploads/auctions/right_img.png'))) }}" alt="Logo Right" style="width: 200px; height: 150px">
<div class="" style="position: absolute; top: 5px; right: 75px">
    <span style="color: white; font-weight: bold; text-transform: uppercase; font-size: 26px">Starting</span> <br>
    <span style="color: white; font-weight: bold; text-transform: uppercase; font-size: 26px; margin-left: 40px">Bid</span>
    <br>
    <span style="color: white; font-weight: bold; text-transform: uppercase; font-size: 32px; @if(data_get($value, 'start_bid_amount') == 0) margin-left: 45px; @else margin-left: 30px @endif">{!! number_format( data_get($value, 'start_bid_amount') ) !!}</span>
</div>

@php
    $vehiclePhoto = public_path('uploads/images/car_default_thumbnail.jpg');

    $imageArr = [];
    foreach(data_get($value, 'vehicle.vehicle_images') as $index => $image) {
        if(\Illuminate\Support\Facades\Storage::exists(data_get($image, 'name'))) {
            $imageArr[$index] = \Illuminate\Support\Facades\Storage::url(data_get($image, 'name'));
        }else {
           $imageArr[$index] = $vehiclePhoto;
        }
        if($index == 4) break;
    }

    // Ensure at least 5 images
    for($i = count($imageArr); $i < 5; $i++) {
        $imageArr[$i] = $vehiclePhoto;
    }

@endphp


<img class="left-image" src="{{'data:image/png;base64,'.base64_encode(file_get_contents($imageArr[0]))}}" alt="Left Large" style="border-radius: 8px; ">

<div class="right-grid">
    <div class="" style="position: relative; height: 70%; width: 100%;">
        <div class="small_img" style="position: absolute; left: 0; top: 0; width: 48%; padding: 5px; height: 50%;">
            <img  src="{{'data:image/png;base64,'.base64_encode(file_get_contents($imageArr[1]))}}" >
        </div>
        <div class="small_img" style="position: absolute; right: 0; top: 0; width: 48%; padding: 5px; height: 50%">
            <img  src="{{'data:image/png;base64,'.base64_encode(file_get_contents($imageArr[2]))}}" >
        </div>
        <div class="small_img" style="position: absolute; left: 0; bottom: 48px; width: 48%; padding: 5px; height: 50%">
            <img  src="{{'data:image/png;base64,'.base64_encode(file_get_contents($imageArr[3]))}}" >
        </div>
        <div class="small_img" style="position: absolute; right: 0; bottom: 48px; width: 48%; padding: 5px; height: 50%">
            <img  src="{{'data:image/png;base64,'.base64_encode(file_get_contents($imageArr[4]))}}" >
        </div>
    </div>
</div>

<div class="car_detail_section" style="position: absolute; bottom: 0; left: 0">
    <p style="margin-left: 30px; color: #B11E24; font-weight: bold; font-size: 36px"> @if(data_get($value, 'vehicle.sale_type') == 3 && strlen(data_get($value, 'vehicle.title')) > 31 )  {!! substr(data_get($value, 'vehicle.title'), 0, 28) !!}...   @elseif (strlen(data_get($value, 'vehicle.title')) > 38 )  {!! substr(data_get($value, 'vehicle.title'), 0, 38) !!}... @else {!! data_get($value, 'vehicle.title') !!}  @endif </p>

    <p style="margin-left: 30px; color: #B11E24; font-weight: bold; font-size: 36px">
        @php
            $title = data_get($value, 'vehicle.title');
            $isPureSale = data_get($value, 'vehicle.sale_type') == 3;
        @endphp

        @if ($isPureSale && strlen($title) > 31)
            {!! substr($title, 0, 28) !!}...
        @elseif (strlen($title) > 38)
            {!! substr($title, 0, 38) !!}...
        @else
            {!! $title !!}
        @endif
    </p>
    <p style="margin-left: 30px; margin-top: -30px; color: #414141; font-weight: bold; font-size: 32px">{!! data_get($value, 'vehicle.odometer') !!} {!! data_get($value, 'vehicle.odometer_type') !!} - {!! data_get($value, 'vehicle.drive_train.name') !!} - {!! data_get($value, 'vehicle.highlight.name') !!}</p>
</div>

@if(data_get($value, 'vehicle.sale_type') == 3)
    <div class="green_light_section" style="position: absolute; right: 210px; bottom: -5px">
        <img src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('uploads/auctions/green_light.png'))) }}" alt="Logo Left" style="width: 180px; height: 150px">
        <p style="margin-left: 17px; text-transform: uppercase; color: green; font-weight: bold; font-size: 22px; margin-top: -1px">Green Light</p>
    </div>
@endif
<div class="qr_code_section" style="position: absolute; right: 35px; bottom: 10px;">
    <p style="text-transform: uppercase; margin-left: 25px; font-weight: bold; letter-spacing: 3px">Scan Me</p> <br>
{{--    <a href="{!! "https://gulfcarauction.com/all-vehicle//all-vehicle/". data_get($value, 'vehicle.lot_number')  !!}" target="_blank"> <img width="130"--}}
{{--                                                                                                                                            src="{{ 'data:image/png;base64,'.base64_encode( \SimpleSoftwareIO\QrCode\Facades\QrCode::format( 'svg' )->size( 150 )->errorCorrection( 'H' )->generate( "https://gulfcarauction.com/all-vehicle/". data_get($value, 'vehicle.lot_number') ) ) }}"--}}
{{--                                                                                                                                            alt="QR code">--}}
{{--    </a>--}}
</div>

</body>
</html>

@endforeach
