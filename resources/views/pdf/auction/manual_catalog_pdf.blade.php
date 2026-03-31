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
            font-size: 52px;
            display: inline-block;
            margin-left: 15px;
            font-weight: bold;
        }

        .header-content .title {
            font-size: 52px;
            display: inline-block;
            text-align: center;
            margin-left: 5px;
            font-weight: bold;
            overflow: hidden;
        }
        .header-content .header_right {
            font-size: 52px;
            display: inline-block;
            text-align: center;
            margin-left: 10px;
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
@php $i = 1; @endphp
@foreach( $vehicles as $vehicle )
    <div class="photo-container">
        <div class="photo-left">
            <img
                    src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('uploads/auctions/gulf_english.png')))}}"
                    alt="Left Photo">
        </div>
        <div class="photo-right">
            <img
                    src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('uploads/auctions/gulf_arabic.png')))}}"
                    alt="Right Photo">
        </div>
        <div class="clear"></div>
    </div>

    <div class="" style="padding-left: 20px; padding-right: 20px; background-color: #e0dede">
        <div class="header">
            <div class="header-content">
                <div class="serial">#{{$i++}}</div>
                <div class="title"
                     style="font-family: 'News 706'">| {{ $vehicle->title }}</div>
                <div class="header_right"> - {{ optional($vehicle->engine_type)->name}}</div>
            </div>
        </div>

{{--        <div class="main-content">--}}
{{--            @php--}}
{{--                $vehiclePhoto = public_path('uploads/images/car_default_thumbnail.jpg');--}}
{{--                if( !empty($vehicle->vehicle_images) && $vehicle->vehicle_images->first() && \Illuminate\Support\Facades\Storage::exists($vehicle->vehicle_images->first()->name) ) {--}}
{{--                    $vehiclePhoto = \Illuminate\Support\Facades\Storage::url(data_get($vehicle->vehicle_images->first(), 'name' ));--}}
{{--                }--}}
{{--            @endphp--}}
{{--            <img class="full-width" style="height: 1033px"--}}
{{--                 src="{{'data:image/png;base64,'.base64_encode(file_get_contents($vehiclePhoto))}}">--}}
{{--            <img--}}
{{--                    src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('uploads/auctions/img1.png')))}}"--}}
{{--                    class="top-right">--}}
{{--            <p class="top-right-text" style="font-weight: bold; font-family: 'News 706';">--}}
{{--                <span style="text-align: center; display: block">Price</span>--}}
{{--                <span style="text-align: center; display: block;">{{ $vehicle->selling_price }} AED</span>--}}
{{--            </p>--}}
{{--        </div>--}}

      @php

        $defaultPhoto = public_path('uploads/images/car_default_thumbnail.jpg');
        $vehiclePhotoData = file_get_contents($defaultPhoto); // fallback

        if (!empty($vehicle->vehicle_images) && $vehicle->vehicle_images->first()) {
            $path = data_get($vehicle->vehicle_images->first(), 'name');
            try {
                if (Illuminate\Support\Facades\Storage::disk('s3')->exists($path)) {
                    $vehiclePhotoData = Illuminate\Support\Facades\Storage::disk('s3')->get($path); // ✅ Direct read from S3
                }
            } catch (Exception $e) {
                Log::info('some error for pdf'. $e->getMessage());
            }
        }

        $base64VehiclePhoto = base64_encode($vehiclePhotoData);
        $base64DefaultImage = base64_encode(file_get_contents(public_path('uploads/auctions/img1.png')));
      @endphp

      <div class="main-content">
        <img class="full-width" style="height: 1033px"
             src="data:image/jpeg;base64,{{ $base64VehiclePhoto }}">

        <img src="data:image/png;base64,{{ $base64DefaultImage }}"
             class="top-right">

        <p class="top-right-text" style="font-weight: bold; font-family: 'News 706';">

          <span style="color: yellow; text-align: center; display: block; font-weight: bold">BUY NOW</span>

          <span style="color: yellow; text-align: center; display: block;">{{ $vehicle->selling_price }} AED</span>
          <br />
          <span style="text-align: center; display: block; font-weight: bold">BEFORE</span>
          <span style="color: black;text-align: center; display: block; text-decoration: line-through">{{ ceil($vehicle->selling_price + (($vehicle->selling_price * 15) /100)) }} AED</span>
        </p>

      </div>

        <div class="footer">
            <div class="title">CLEAN TITLE, {{$vehicle->odometer}}
                M, {{ optional($vehicle->highlight)->name }}
                ,
                Lot # {{ $vehicle->lot_number }}</div>
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
