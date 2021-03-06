@extends('trakr.layouts.app')
@section('content')
<link rel="stylesheet" href="{{ asset('css/vendor/quill.snow.css') }}" />
<script src="{{ asset('js/vendor/jquery-3.3.1.min.js')}}"></script>
<style media="screen">
.trakr_box_hover:hover{
     transform: scale(1.1);
     transition: 300ms
}
</style>
<div class="container border border-light">
    <div class="row justify-content-center">
        <div class="col-md-12 text-center">
            <h1 class="text-light" style="font-size: 30px;">WELCOME</h1>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-4 col-sm-12 mb-4 entry_box trakr_box_hover" id="modalCheckin">
            <a href="#" class="card" data-toggle="" data-target="">
                <div class="card-body text-center">
                    <h1><i class="simple-icon-login"></i><h1>
                    <h2 class="card-text font-weight-semibold mb-0">Sign In</h2>
                </div>
            </a>
        </div>
        <div class="col-md-12 col-lg-4 col-sm-12 mb-4 entry_box trakr_box_hover" id="simple_checkin">
            <a href="#" class="card" data-toggle="" data-target="#">
                <div class="card-body text-center">
                    <h1><i class="simple-icon-login"></i><h1>
                    <h2 class="card-text font-weight-semibold mb-0">Sign In with trakrID</h2>
                </div>
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8 col-sm-12 mb-4 entry_box trakr_box_hover">
            <a href="#" class="card" data-toggle="modal" data-target="#checkoutModal">
                <div class="card-body text-center">
                    <h1><i class="simple-icon-logout"></i></h1>
                    <h2 class="card-text font-weight-semibold mb-0">Sign Out</h2>
                </div>
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-sm-8 col-md-6 col-lg-6 col-xl-4">
            <a href="#" class="card" data-toggle="modal">
                <div class="card-body text-center">
                    <h1>Contactless Entry</h1>
                    <img class=""  src="{{ auth()->user()->qr_path }}" alt="" height="250" width="250">
                </div>
                <div class="card-footer">
                    <p class="text-center font-medium card-text mb-0" style="font-size: 17px;">
                        Scan the QR code with your smartphone camera to <br>
                        <strong>Sign In</strong> or <strong>Sign Out</strong>
                    </p>
                </div>
            </a>
        </div>
    </div>

</div>
<script src="{{ asset('js/vendor/sweetalert2@10.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/vendor/quill.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/quill_modules/image-drop.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/quill_modules/image-resize.min.js') }}"></script>
<!-- MODAL CHECKIN -->
@include('trakr.modal.modals');
<!-- END MODAL CHECKIN -->
@endsection
