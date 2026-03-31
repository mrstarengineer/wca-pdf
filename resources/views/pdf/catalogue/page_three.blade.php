<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @page {
            margin: 10px;
        }
        body {
            font-family: sans-serif;
        }
        .logo{
            text-align:center;
            margin-bottom:20px;
        }
        .logo img{
            height:70px;
        }
        .gallery-table{
            width:100%;
            border-collapse:collapse;
        }
        .main-image{
            width:80%;
        }
        .side-images{
            width:20%;
        }
        .main-image img{
            width:99%;
            height:500px;
            border-radius:8px;
        }
        .side-images img{
            width:100%;
            height:118px;
            border-radius:8px;
            margin-bottom:8px;
        }
        .footer{
            margin-top:25px;
        }
        .bid-box{
            background:orange;
            border-radius:50%;
            padding:12px;
            color:white;
            font-size:42px;
            font-weight:bold;
            display:inline-block;
        }
        .price-box{
            background:white;
            color:black;
            border-radius:12px;
            padding:6px 12px;
        }
        .vehicle-title{
            font-size:42px;
            margin-top:10px;
        }
        .qr img{
            height:90px;
        }
    </style>
</head>
<body>
@php
    $logoPath = public_path('images/WCA_LOGO.png');
    $logoData = base64_encode(file_get_contents($logoPath));
    $logoMime = mime_content_type($logoPath);
    $logoBase64 = "data:$logoMime;base64,$logoData";
    $aedPath = public_path('images/aed.png');
    $aedData = base64_encode(file_get_contents($aedPath));
    $aedMime = mime_content_type($aedPath);
    $aedBase64 = "data:$aedMime;base64,$aedData";
@endphp
    <!-- LOGO -->
<div class="logo">
    <img src="{!! $logoBase64 !!}">
</div>
<table class="gallery-table">
    <tr>
        <td class="main-image">
            <img src="https://images.hgmsites.net/lrg/2018-acura-nsx_100618872_l.jpg">
        </td>
        <td class="side-images">
            <img src="https://i.insider.com/550cbf03ecad04de2c7c008a?width=1200&format=jpeg">
            <img src="https://cdn.motor1.com/images/mgl/7ZQPRJ/s1/2024-jaguar-f-type-coupe.jpg">
            <img src="https://editorial.pxcrush.net/carsales/general/editorial/160707_Jaguar_F-Type_S_AWD_01.jpg?width=1024&height=682">
            <img src="https://www.supercars.net/blog/wp-content/uploads/2025/01/The-Most-Beautiful-Cars-Of-All-Time-scaled.webp">
        </td>
    </tr>
</table>
<div class="footer">
    <table width="100%">
        <tr>
            <td width="5%"></td>
            <td width="80%" style="text-align:center;">
                <div class="bid-box">
                    STARTING BID :
                    <span class="price-box">
                     192,500
                     <img src="{!! $aedBase64 !!}" height="28" style="display: inline-block; padding-right: 10px">
                     </span>
                </div>
                <div class="vehicle-title" style="text-transform: uppercase">
                    @php
                        $title = 'Nissan Altima 2023 EX';
                            $maxLength = 24;
                            $displayTitle = strlen($title) > $maxLength
                                ? substr($title, 0, $maxLength) . '...'
                                : $title;
                    @endphp

                    {{ $displayTitle }}
                </div>
            </td>
            <td width="15%" class="qr" style="text-align:right;padding: 0">
                <img
                    src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=https://westcarsauctions.com/vehicle-detail/"
                    style="width:90%; height:auto; object-fit:contain;"
                >
            </td>
        </tr>
    </table>
</div>
</body>
</html>
