<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Page Two</title>
    <style>
        @page {
            margin: 0px;
        }
    </style>
</head>
<body>

@php

    $logoPath = public_path('uploads/auctions/page_2.jpeg');
        $logoData = base64_encode(file_get_contents($logoPath));
        $logoMime = mime_content_type($logoPath);
        $logoBase64 = "data:$logoMime;base64,$logoData";


@endphp

<div class="" style="position: relative;">

    <img src="{!! $logoBase64 !!}" alt="" height="100%" width="100%">

</div>
</body>
</html>
