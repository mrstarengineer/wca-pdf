@foreach(data_get($auctionData, 'auction_vehicles') as $key => $value)
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

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            height: 70px;
        }

        .gallery-table {
            width: 100%;
            border-collapse: collapse;
        }

        .main-image {
            width: 65%;
        }

        .side-images {
            width: 35%;
        }

        .main-image img {
            width: 99%;
            height: 500px;
            border-radius: 8px;
        }

        .side-images img {
            width: 100%;
            height: 170px;
            border-radius: 8px;
            margin-bottom: 8px;
        }

        .footer {
            margin-top: 15px;
        }

        .bid-box {
            background: orange;
            border-radius: 50%;
            padding: 12px;
            color: white;
            font-size: 42px;
            font-weight: bold;
            display: inline-block;
        }

        .price-box {
            background: white;
            color: black;
            border-radius: 12px;
            padding: 6px 12px;
        }

        .vehicle-title {
            font-size: 42px;
            margin-top: 10px;
        }

        .qr img {
            height: 90px;
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
    <!-- LOGO -->
<div class="logo">
    <img src="{!! $logoBase64 !!}">
</div>
<div class="">
    <table class="gallery-table">
        <tr>
            <td class="main-image">
                <img src="{{'data:image/png;base64,'.base64_encode(file_get_contents($imageArr[0]))}}">
            </td>
            <td class="side-images">
                <table>
                    <tr>
                        <td>
                            <img src="{{'data:image/png;base64,'.base64_encode(file_get_contents($imageArr[1]))}}">
                        </td>
                        <td>
                            <img src="{{'data:image/png;base64,'.base64_encode(file_get_contents($imageArr[2]))}}">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img src="{{'data:image/png;base64,'.base64_encode(file_get_contents($imageArr[3]))}}">
                        </td>
                        <td>
                            <img src="{{'data:image/png;base64,'.base64_encode(file_get_contents($imageArr[4]))}}">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
<div class="footer">
    <table width="100%">
        <tr>
            <td width="5%"></td>
            <td width="80%" style="text-align:center;">
                <div class="bid-box">
                    STARTING BID :
                    <span class="price-box">
                     {!! number_format(data_get($value, 'vehicle.start_bid_amount')) !!}
                     <img src="{!! $aedBase64 !!}" height="28" style="display: inline-block; padding-right: 10px">
                     </span>
                </div>
                <div class="vehicle-title" style="text-transform: uppercase">
                    @php
                        $title = data_get($value, 'vehicle.title');
                               $maxLength = 29;
                               $displayTitle = strlen($title) > $maxLength
                                   ? substr($title, 0, $maxLength) . '...'
                                   : $title;
                    @endphp

                    {{ $displayTitle }}
                </div>
            </td>

            <td width="15%" class="qr" style="text-align:right;padding: 0; position: relative">
                <img
                    src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=https://westcarsauctions.com/vehicle-detail/{{ data_get($value, 'vehicle.lot_number') }}"
                    style="width:90%; height:auto; object-fit:contain;"
                >
                <span style="position: absolute; right: 20px; top: -60px; font-size: 18px; text-transform: uppercase; font-weight: bold">View Details</span>
            </td>
        </tr>
    </table>
</div>
</body>
</html>

@endforeach
