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
<div class="container-fluid">
    <div class="row justify-content-md-center">
        <div class="col-sm-12 col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="jumbotron">
                        <h1 class="display-4">Welcome to entrytrakr.</h1>
                    </div>
                    <div class="row icon-cards-row justify-content-md-center">
                        <div class="col-md-12 col-lg-4 col-sm-12 mb-4 entry_box trakr_box_hover" id="modalCheckin">
                            <a href="#" class="card" data-toggle="" data-target="">
                                <div class="card-body text-center">
                                <h1><i class="simple-icon-login"></i><h1>
                                <h2 class="card-text font-weight-semibold mb-0">Sign In</h2>
                                <!-- <p class="lead text-center">10</p> -->
                                </div>
                            </a>
                        </div>
                        <div class="col-md-12 col-lg-4 col-sm-12 mb-6 entry_box trakr_box_hover" id="simple_checkin">
                            <a href="#" class="card" data-toggle="" data-target="#">
                                <div class="card-body text-center">
                                <h1><i class="simple-icon-key"></i></h1>
                                <h2 class="card-text font-weight-semibold mb-0">Sign In with trakrID</h2>
                                <!-- <p class="lead text-center">10</p> -->
                                </div>
                            </a>
                        </div>
                        <div class="col-md-12 col-lg-6 col-sm-12 mb-6 entry_box trakr_box_hover">
                            <a href="#" class="card" data-toggle="modal" data-target="#checkoutModal">
                                <div class="card-body text-center">
                                    <h1><i class="simple-icon-logout"></i></h1>
                                    <h2 class="card-text font-weight-semibold mb-0">Sign Out</h2>
                                </div>
                            </a>
                        </div>
                    </div> 
                    
                    <!-- <div class="row icon-cards-row justify-content-md-center">
                        {{QrCode::size(250)->backgroundColor(255,255,204)->generate('MyNotePaper')}}
                    </div> -->
                    
                    <hr>
                    <div class="row justify-content-md-center">
                        <div class="col-md-6">
                            <p class="text-center" >Our terms of use and privacy can be found on our website <a target="_blank" class="text-primary" href="//www.entrytrakr.com/">www.entrytrakr.com</a></p>
                        </div>
                    </div>
                </div>
            </div>
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

