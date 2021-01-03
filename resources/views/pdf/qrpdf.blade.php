<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title> QR LOGIN </title>
    <style media="screen">
        *{
            font-family: 'Roboto', sans-serif;
        }
        .container {
            margin: auto;
            width: 80%;
            border: 3px solid #a3238e;
            padding: 20px;
            border-radius: 8px;
            margin-top: 40px;
        }
        
        .justify-content-md-center{
            text-align: center;
        }
        .title{
            font-size: 40px;
        }
    </style>
    </head>
    <body>
        <div class="container">
            <div class="row justify-content-md-center mt-4 align-items-center">
                <div class="col-md-8 text-center">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="card-title title"> 
                                Contactless <br />
                                Sign In & Sign Out
                            </h1>
                            <p class="card-text mb-4" > Please scan the QR code with your smartphone camera</p> 
                            <br><br><br>
                            <img src="{{ url(auth()->user()->qr_path) }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>