<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Page One</title>
    <style>
        @page {
            margin: 0px;
        }
    </style>
</head>
<body>

@php

    $logoPath = public_path('uploads/auctions/part_one.jpeg');
        $logoData = base64_encode(file_get_contents($logoPath));
        $logoMime = mime_content_type($logoPath);
        $logoBase64 = "data:$logoMime;base64,$logoData";


@endphp

<div class="" style="position: relative;">
    <div class="" style="position: absolute; left: 300px; top: 150px">
        <span style="font-size: 62px; text-transform: uppercase; font-weight: bold">{!! $dayOfWeek !!}</span>
    </div>
    <div class="" style="position: absolute; left: 400px; top: 250px">
        <span style="font-size: 32px; text-transform: uppercase; font-weight: bold">{!! $formattedDate !!}-{!! $timeFormatted !!}</span>
    </div>
    <div class="" style="position: absolute; left: 400px; top: 640px">
        <span style="font-size: 62px; text-transform: uppercase; font-weight: bold">{!! $totalCar !!} +</span>
    </div>

    <img src="{!! $logoBase64 !!}" alt="" height="100%" width="100%">

</div>
</body>
</html>
