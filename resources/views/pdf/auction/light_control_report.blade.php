<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Light Control Pdf</title>
    <style>
        @page {
            margin-top: 40px;
            margin-bottom: 0;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .header {
            width: 100%;
            text-align: center;
            position: relative;
            height: 100px;
        }

        .header img {
            position: absolute;
            top: 0;
        }

        .header .left {
            left: 0;
        }

        .header .center {
            left: 50%;
            transform: translateX(-50%);
        }

        .header .right {
            right: 0;
        }

        .header_text .heading-left, .header_text .heading-right {
            position: absolute;
            top: 0;
            width: 50%;
        }

        .header_text .heading-left {
            left: 20px;
            text-align: left;
        }

        .header_text .heading-right {
            right: 20px;
            text-align: right;
        }

        .table-container {
            width: 100%;
            margin-top: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        .footer {
            width: 100%;
            text-align: center;
            position: fixed;
            bottom: 0;
            left: 0;
            padding: 10px 0;
        }

        .footer .line {
            border-top: 1px solid red;
            margin-bottom: 10px;
            margin-top: 2px;
        }

        .footer .page-number::after {
            content: counter(page);
        }

        .footer-text {
            margin-top: 2px;
        }

        .footer-content {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .footer-content img {
            width: 16px;
            height: 16px;
            margin-top: 10px;
        }

    </style>
</head>
<body>

<div class="header">
    <img width="200" class="left"
         src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('uploads/images/gulf_english.png')))}}">
    <img width="80" height="80" class="center"
         src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('uploads/auctions/logo_single.png')))}}">
    <img width="200" class="right"
         src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('uploads/images/gulf_arabic.png')))}}">
</div>

<div class="" style="border-bottom: 2px solid black ; border-top: 2px solid black; height: 32px">
    <div class="header_text" style="position: relative; margin-top: -10px">
        <div class="heading-left">
            <p>{{ \Illuminate\Support\Carbon::parse($auction->auction_at)->format('l, d M, Y') }}</p>
        </div>
        <div class="heading-right">
            <p>{{ $auction->yard_display_name }}</p>
        </div>
    </div>
</div>
<div class="" style="text-align: center; margin-top: -8px">
    <p style="font-size: 16px; text-transform: uppercase">For Lights Control Team</p>
</div>
<div class="table-container">
    <table>
        <thead>
        <tr>
            <th>Run #</th>
            <th>Car Description</th>
            <th>Sale Type</th>
            <th>Starting Bid</th>
            <th>Reserve Amount</th>
        </tr>
        </thead>
        <tbody>
        @foreach( $auction->auction_vehicles as $auctionVehicle )
            <tr>
                <td>{{ sprintf('%03d', $auctionVehicle->serial) }}</td>
                <td>{{ strtoupper(data_get($auctionVehicle, 'vehicle.title')) }}</td>
                <td>{{ array_key_exists($auctionVehicle->vehicle->sale_type, trans('auction.vehicle_sale_type')) ? trans('auction.vehicle_sale_type.'.$auctionVehicle->vehicle->sale_type) : '' }}</td>
                <td>{{ data_get($auctionVehicle, 'vehicle.start_bid_amount') }}</td>
                <td>{{ $auctionVehicle->vehicle->sale_type == \App\Enums\VehicleSaleType::ON_RESERVE ? $auctionVehicle->vehicle->reserve_amount : '-' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<div class="footer">
  <div class="page-number" style="font-size: 13px">Page </div>
</div>

{{--<div class="footer">--}}
{{--    <div class="page-number" style="font-size: 13px">Page</div>--}}
{{--    <div class="line"></div>--}}
{{--    <div class="footer-content">--}}
{{--        <img--}}
{{--            src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('uploads/auctions/map.png')))}}"--}}
{{--            alt="Map Icon"> <span style="margin-right: 5px; font-size: 11px">Al Sajja Industrial - Emirates Industrial City Sharja, United Arab Emirates</span>--}}
{{--        <img--}}
{{--            src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('uploads/auctions/phone.png')))}}"--}}
{{--            alt="Phone Icon"> <span style="margin-top: -3px; font-size: 11px">(+971) 558 800 800</span>--}}
{{--    </div>--}}
{{--</div>--}}
</body>
</html>
