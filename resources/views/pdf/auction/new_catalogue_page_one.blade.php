<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>PDF Layout</title>

  @php
    $bg = base64_encode(file_get_contents(public_path('uploads/auctions/page_one_bg.png')));
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

  </style>
</head>
<body>
<div class="" style="position: absolute; right: 100px; top: 50px; font-weight: bold; font-size: 48px; color: #B11E24">
  <span>{!! $formattedDate !!}</span> <br>
  <span style="margin-left: 55px; color: #414141">{!! $timeFormatted !!}</span>
</div>
<div class="" style="position: absolute; right: 110px; bottom: 130px; letter-spacing: 4px; font-size: 36px; font-weight: bold; color: #414141; text-transform: uppercase ">
  <p>{!! $dayOfWeek !!}</p>
</div>
</body>
</html>

