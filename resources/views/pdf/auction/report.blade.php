<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        @font-face {
            font-family: 'MyriadPro';
            src: url({{ storage_path("fonts/MyriadPro-Light.otf") }}) format("truetype");
            font-weight: 700;
            font-style: normal;
        }

        body {
            font-family: 'MyriadPro', 'sans-serif';
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
            left: 5px;
            text-align: left;
        }

        .header_text .heading-right {
            right: 5px;
            text-align: right;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }

        .header-table td {
            vertical-align: top;
            padding: 5px;
        }

        .customer-info h1, .customer-info p {
            margin: 0;
            padding: 0;
        }

        .logo img {
            max-width: 100%;
            height: auto;
        }

        h1,
        h2 {
            margin-top: 0;
            margin-bottom: 0;
            font-weight: 500;
            line-height: 1.2;
        }

        table {
            caption-side: bottom;
            border-collapse: collapse;
        }

        table tr td, thead tr th {
            border: 1px solid #333;
            padding: 4px;
            font-size: 10px;
            text-align: center;
        }

        .border-light td {
            border: 1px solid #afa8a8;
        }

        .heading td {
            font-size: 12px;
            text-align: center;
        }

        .heading.text-left td {
            text-align: left;
        }

        .tr-text-right td {
            text-align: right;
        }

        th {
            font-weight: bold;
        }

        table.custom_tbl_class tbody tr td {
            color: #414141;
            font-size: 11px;
        }

    </style>
</head>

<body class="">
<div>
    <div class="header">
        <img width="200" class="left"
             src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('uploads/images/gulf_english.png')))}}">
        <img width="80" height="80" class="center"
             src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('uploads/auctions/logo_single.png')))}}">
        <img width="200" class="right"
             src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('uploads/images/gulf_arabic.png')))}}">
    </div>

    <div class="" style="border-bottom: 1px solid #000000; border-top: 1px solid #000000; height: 32px">
        <div class="header_text" style="position: relative; margin-top: -10px">
            <div class="heading-left">
                <p>AUCTION
                    DATE: {{ strtoupper(\Illuminate\Support\Carbon::parse($auction->auction_at)->format('l, d M Y')) }}</p>
            </div>
            <div class="heading-right">
                <p>{{ $auction->yard_display_name }}</p>
            </div>
        </div>
    </div>

    <div style="text-align: center; margin-top: 15px;">
        <strong style="font-size: 16px; text-transform: uppercase">Auction Report (Summary)</strong>
    </div>

    <table class="header-table">
        <tr style="background-color: white !important;">
            <td class="logo" style="border: none !important; font-size: 12px">
                <strong>TOTAL VEHICLES: {{ $counters['total'] }}</strong>
            </td>
            <td style="border: none !important; font-size: 12px">SOLD VEHICLES: {{$counters['sold']}}</td>
            <td style="border: none !important; font-size: 12px">UNSOLD VEHICLES: {{$counters['unsold']}}</td>
            <td style="border: none !important; font-size: 12px">ON APPROVAL: {{ $counters['on_approval'] }}</td>
        </tr>
    </table>

    <div style="border-bottom: 1px solid #000000;"></div>

    <div style="text-align: center; margin-top: 15px;">
        <strong style="font-size: 16px; text-transform: uppercase">Auction Report (Detail)</strong>
    </div>

    <div style="border-bottom: 1px solid #000000;">
        <h4 style="text-transform: uppercase; font-size: 14px;">Sold Vehicle</h4>
        @php $totalCommission = 0; @endphp
        <table class="custom_tbl_class" cellpadding="1"
               style="width: 100%; font-size: 12px; margin-top: -15px; margin-bottom: 15px;">
            <tbody>
            <tr>
                <th>RUN #</th>
                <th>VEHICLE</th>
                <th>SELLING PRICE</th>
                <th>SELLER</th>
                <th>GCA COMMISSION</th>
            </tr>
            @foreach($auction->auction_vehicles->where('status', \App\Enums\AuctionVehicleStatus::SOLD) as $auctionVehicle)
                @php
                    $gcaCommission = data_get($auctionVehicle, 'vehicle.gca_commission', 0);
                    $totalCommission += $gcaCommission;
                @endphp
                <tr>
                    <td style="text-align: center; border: none;">{{ $auctionVehicle->serial_display_name }}</td>
                    <td style="text-align: center; border: none;">
                        {{ data_get($auctionVehicle, 'vehicle.title') }} <br>
                        {{ data_get($auctionVehicle, 'vehicle.vin') }}
                    </td>
                    <td style="text-align: center; border: none;">{{ $auctionVehicle->current_bid_amount . ' AED' }}</td>
                    <td style="text-align: center; border: none;">{{ data_get($auctionVehicle, 'vehicle.seller.name') }}</td>
                    <td style="text-align: center; border: none;">{{ $gcaCommission. ' AED' }}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td colspan="3" style="border: none;"></td>
                <td style="border: none;">TOTAL</td>
                <td style="border: none; font-size: 12px;">{{ $totalCommission. ' AED' }}</td>
            </tr>
            </tfoot>
        </table>
    </div>

    <div style="border-bottom: 1px solid #000000;">
        <h4 style="margin-top: 20px; text-transform: uppercase; font-size: 14px;">Selling On Approval</h4>
        @php $totalCommission = 0; @endphp
        <table class="custom_tbl_class" cellpadding="1"
               style="width: 100%; font-size: 12px; margin-top: -15px; margin-bottom: 15px;">
            <tbody>
            <tr>
                <th>RUN #</th>
                <th>VEHICLE</th>
                <th>START BID</th>
                <th>RESERVE</th>
                <th>MAX BID</th>
                <th>SELLER</th>
                <th>GCA COMMISSION</th>
            </tr>
            @foreach($auction->auction_vehicles->where('status', \App\Enums\AuctionVehicleStatus::ON_APPROVAL) as $auctionVehicle)
                @php
                    $gcaCommission = calculate_selling_commission($auctionVehicle->current_bid_amount, data_get($auctionVehicle, 'vehicle.commission'));
                    $totalCommission += $gcaCommission;
                @endphp
                <tr>
                    <td style="text-align: center; border: none; font-size: 12px;">{{ $auctionVehicle->serial_display_name }}</td>
                    <td style="text-align: center; border: none; font-size: 12px;">
                        {{ data_get($auctionVehicle, 'vehicle.title') }}<br>
                        {{ data_get($auctionVehicle, 'vehicle.vin') }}
                    </td>
                    <td style="text-align: center; border: none; font-size: 12px;">{{ data_get($auctionVehicle, 'vehicle.start_bid_amount') }}</td>
                    <td style="text-align: center; border: none; font-size: 12px;">{{ data_get($auctionVehicle, 'vehicle.reserve_amount') }}</td>
                    <td style="text-align: center; border: none; font-size: 12px;">{{ $auctionVehicle->current_bid_amount }}</td>
                    <td style="text-align: center; border: none; font-size: 12px;">{{ data_get($auctionVehicle, 'vehicle.seller.name') }}</td>
                    <td style="text-align: center; border: none; font-size: 12px;">{{ $gcaCommission. ' AED' }}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td colspan="5" style="border: none;"></td>
                <td style="border: none;">TOTAL</td>
                <td style="border: none; font-size: 12px;">{{ $totalCommission. ' AED' }}</td>
            </tr>
            </tfoot>
        </table>
    </div>

    <div>
        <h4 style="margin-top: 30px; text-transform: uppercase; font-size: 14px;">Unsold Vehicle</h4>
        @php $sl = 1; @endphp
        <table class="custom_tbl_class" cellpadding="1" style="width: 100%; font-size: 12px; margin-top: -15px;">
            <tbody>
            <tr>
                <th>RUN #</th>
                <th>VEHICLE</th>
                <th>STARTING BID</th>
                <th>SELLER NAME</th>
            </tr>
            @foreach($auction->auction_vehicles->where('status', \App\Enums\AuctionVehicleStatus::UNSOLD) as $auctionVehicle)
                <tr>
                    <td style="text-align: center; border: none; font-size: 12px;">{{ $auctionVehicle->serial_display_name }}</td>
                    <td style="text-align: center; border: none; font-size: 12px;">
                        {{ data_get($auctionVehicle, 'vehicle.title') }}<br>
                        {{ data_get($auctionVehicle, 'vehicle.vin') }}
                    </td>
                    <td style="text-align: center; border: none; font-size: 12px;">{{ $auctionVehicle->current_bid_amount }}</td>
                    <td style="text-align: center; border: none; font-size: 12px;">{{ data_get($auctionVehicle, 'vehicle.seller.name') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
</body>

</html>
