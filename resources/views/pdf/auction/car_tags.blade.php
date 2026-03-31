<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gulf Auction Pdf</title>
    <style>
        @page {
            margin-top: 30px;
            margin-bottom: 0px;
            color: #000000;
        }

        @font-face {
            font-family: 'Calibri';
            src: url({{ storage_path("fonts/Calibri_Regular.ttf") }}) format("truetype");
            font-weight: 700;
            font-style: normal;
        }

        body {
            font-family: Calibri, "sans-serif";
            margin: 0;
            padding: 0;
        }

        .header_content_section .left_section {
            float: left;
        }

        .header_content_section .right_section {
            float: right;
        }

        .header_content_section .right_section p {
            border: 1px solid black;
            padding: 10px;
            margin-top: -10px;
            font-size: 26px;
            font-weight: bold;
        }

        .header_content_section .right_section strong {
            font-weight: 600;
            font-size: 52px;
        }

        .box-1 {
            height: 110px;
            border: 1px solid gray;
            text-align: center;
            width: 370px;
            position: relative;
            font-size: 36px;
            font-weight: 500;
        }

        .box-1-name {
            position: absolute;
            padding: 10px 25px;
            border: 1px solid gray;
            left: 30%;
            top: 95px;
            background-color: #f8f8f8;
            font-size: 34px;
            font-weight: 500;
        }

        .box-2 {
            height: 110px;
            border: 1px solid gray;
            text-align: center;
            width: 380px;
            margin-left: 20px;
            position: relative;
            font-size: 36px;
            font-weight: 500;
        }

        .box-2-name {
            position: absolute;
            padding: 10px 25px;
            border: 1px solid gray;
            left: 35%;
            top: 95px;
            background-color: #f8f8f8;
            font-size: 34px;
            font-weight: 500;
        }

        .box-3 {
            height: 110px;
            border: 1px solid gray;
            text-align: center;
            min-width: 230px;
            margin-left: 10px;
            position: relative;
            font-size: 36px;
            font-weight: 500;
        }

        .box-3-name {
            position: absolute;
            padding: 10px 25px;
            border: 1px solid gray;
            left: 30%;
            top: 95px;
            background-color: #f8f8f8;
            font-size: 34px;
            font-weight: 500;
        }

        .box-4 {
            padding: 10px;
            border: 1px solid gray;
            text-align: center;
            width: 290px;
            position: relative;
            margin-top: 65px;
            font-size: 36px;
            font-weight: 500;
        }

        .box-4-name {
            position: absolute;
            padding: 10px 25px;
            border: 1px solid gray;
            left: 15%;
            top: 115px;
            background-color: #f8f8f8;
            font-size: 22px;
            font-weight: 500;
        }

        .box-5 {
            padding: 10px;
            border: 1px solid gray;
            text-align: center;
            width: 320px;
            margin-left: 20px;
            position: relative;
            margin-top: 65px;
            font-size: 36px;
            font-weight: 500;
        }

        .box-5-name {
            position: absolute;
            padding: 10px 25px;
            border: 1px solid gray;
            left: 30%;
            top: 115px;
            background-color: #f8f8f8;
            font-size: 22px;
            font-weight: 500;
        }

        .box-6 {
            padding: 10px;
            border: 1px solid gray;
            text-align: center;
            width: 310px;
            margin-left: 10px;
            position: relative;
            margin-top: 65px;
            font-size: 32px;
            font-weight: 500;
        }

        .box-6-name {
            position: absolute;
            padding: 10px 25px;
            border: 1px solid gray;
            left: 20%;
            top: 115px;
            background-color: #f8f8f8;
            font-size: 22px;
            font-weight: 500;
        }

        .box-7 {
            padding: 10px;
            border: 1px solid gray;
            text-align: center;
            width: 300px;
            position: relative;
            margin-top: 50px;
            font-size: 34px;
            font-weight: 500;
        }

        .box-7-name {
            position: absolute;
            padding: 5px 25px;
            border: 1px solid gray;
            left: 10%;
            top: 110px;
            width: 180px;
            text-align: center;
            background-color: #f8f8f8;
            font-size: 28px;
            font-weight: 500;
        }

        .box-8 {
            padding: 10px;
            border: 1px solid gray;
            text-align: center;
            width: 320px;
            position: relative;
            margin-top: 50px;
            margin-left: 50px;
            font-size: 34px;
            font-weight: 500;
        }

        .box-8-name {
            position: absolute;
            padding: 5px 25px;
            border: 1px solid gray;
            left: 20%;
            top: 110px;
            background-color: #f8f8f8;
            font-size: 26px;
            font-weight: 500;
        }

    </style>
</head>
<body>
@foreach( $auction->auction_vehicles as $auctionVehicle )
    <section class="header_section">
        <img width="300"
             src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('uploads/auctions/gulf_img_pdf.png')))}}">
    </section>
    <section class="header_content_section">
        <div class="left_section">
            <p style="font-size: 26px; font-weight: 500; font-family: Calibri,'sans-serif' ">AUCTION DATE
                : {{ \Illuminate\Support\Carbon::parse($auction->auction_at)->format('d M Y') }}</p>
        </div>
        <div class="right_section" style="margin-top: -45px;">
            <p>
                <strong style="margin-left: 25px; padding-bottom: 5px;">
                    {{sprintf('%03d', $auctionVehicle->serial)}}
                </strong>
            </p>
        </div>
    </section>
    <section class="main_content" style="margin-top: 70px">
        <table>
            <tr style="width: 100%;">
                <td style="width: 33%; position: relative">
                    <div class="box-1">
                        <p>{{ strtoupper(data_get($auctionVehicle, 'vehicle.vehicle_make.name')) }}</p>
                    </div>
                    <div class="box-1-name">MAKE</div>
                </td>
                <td style="width: 33%; position: relative">
                    <div class="box-2">
                        <p>{{ strtoupper(data_get($auctionVehicle, 'vehicle.vehicle_model.name')) }}</p>
                    </div>
                    <div class="box-2-name">MODEL</div>
                </td>
                <td style="width: 33%; position: relative">
                    <div class="box-3">
                        <p>({{data_get($auctionVehicle, 'vehicle.year')}})</p>
                    </div>
                    <div class="box-3-name">YEAR</div>
                </td>
            </tr>
        </table>

        <table>
            <tr style="width: 100%;">
                <td style="width: 33%; position: relative; margin-top: 50px">
                    <div class="box-4">
                        {{data_get($auctionVehicle, 'vehicle.odometer')}}
                    </div>
                    <div class="box-4-name">ODOMETER</div>
                </td>
                <td style="width: 33%; position: relative">
                    <div class="box-5">
                        {{ strtoupper(data_get($auctionVehicle, 'vehicle.drive_train.name')) }}
                    </div>
                    <div class="box-5-name">DRIVE TRAIN</div>
                </td>
                <td style="width: 33%; position: relative">
                    <div class="box-6">
                        {{strtoupper(data_get($auctionVehicle, 'vehicle.highlight.name'))}}
                    </div>
                    <div class="box-6-name">HIGHLIGHTS</div>
                </td>
            </tr>
        </table>


        <table style="margin-top: 20px">
            <tr>
                <td style="width: 33%; position: relative">
                    <div class="box-7">
                        {{ mask_vin_number(data_get($auctionVehicle, 'vehicle.vin')) }}
                    </div>
                    <div class="box-7-name">VIN #</div>
                </td>
                <td style="width: 33%; position: relative">
                    <div class="box-8">
                        {{ data_get($auctionVehicle, 'vehicle.start_bid_amount') }} <small>AED + 5% VAT</small>
                    </div>
                    <div class="box-8-name">STARTING BID</div>
                </td>
                <td>
                    <div style="width: 310px;">
                        <div style="float: right">
                            <span style="font-size: 28px;margin-left:20px; margin-bottom: 5px; font-weight:bold;">SCAN ME</span>
                            <br/>
                            <img width="130" style="float: right;margin-right:5px;"
                                 src="{{ 'data:image/png;base64,'.base64_encode( \SimpleSoftwareIO\QrCode\Facades\QrCode::format( 'svg' )->size( 150 )->errorCorrection( 'H' )->generate( "https://www.gulfcarauction.com/all-vehicle/".data_get($auctionVehicle, 'vehicle.lot_number') ) ) }}"
                                 alt="QR code">
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </section>

    <section class="footer_section" style="margin-top: 60px">
        <p style="border-top: 1px solid black; font-weight: bold; width: max-content; display: inline-block"><span
                style="color: darkred">GULF</span>CARAUCTION.COM</p>
    </section>
@endforeach
</body>
</html>
