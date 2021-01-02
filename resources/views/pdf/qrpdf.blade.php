<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title> QR LOGIN </title>
        <link href="{{ public_path('css/vendor/bootstrap.min.css') }}" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <div class="row justify-content-md-center mt-4 align-items-center">
                <div class="col-md-8 text-center">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="card-title"> Contactless Sign In / Sign Out </h1>
                            <p class="card-text mb-4" > Please scan the QR code with your smartphone camera</p>
                            <img src=" {{auth()->user()->qr_path}} " alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>