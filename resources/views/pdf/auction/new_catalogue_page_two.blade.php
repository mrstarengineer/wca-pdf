<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>PDF Layout</title>

  @php
    $bg = base64_encode(file_get_contents(public_path('uploads/auctions/page_two_bg.png')));
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

<div class="" style="position: absolute; left: 170px; top: 207px;font-size: 20px; font-weight: bold; color: white; text-transform: uppercase ">
  <p>{{ $total_car }} + Cars</p>
</div>
</body>
</html>

