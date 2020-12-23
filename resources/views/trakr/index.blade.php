@extends('trakr.layouts.app')
@section('content')
<script src="{{ asset('js/vendor/jquery-3.3.1.min.js')}}"></script>
<style media="screen">
.trakr_box_hover:hover{
     transform: scale(1.1);
     transition: 300ms
}
</style>
<!-- MODAL CHECKIN -->
@include('trakr.modal.modals');
<!-- END MODAL CHECKIN -->
<div class="container-fluid">
    <div class="row justify-content-md-center">
        <div class="col-sm-12 col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="jumbotron">
                        <h1 class="display-4">Welcome to entrytrakr.</h1>
                    </div>
                    <div class="row icon-cards-row justify-content-md-center">
                        <div class="col-md-12 col-lg-4 col-sm-12 mb-4 entry_box trakr_box_hover">
                            <a href="#" class="card" data-toggle="modal" data-target="#checkinModal">
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
<script type="text/javascript">
$('#simple_checkin').on('click', function() {
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        Swal.fire({
        title: 'Provide your trakr ID',
        input: 'text',
        inputAttributes: {
            autocapitalize: 'off'
        },
        showCancelButton: true,
        confirmButtonText: 'Check In',
        showLoaderOnConfirm: true,
        preConfirm: (trakrid) => {
            if (trakrid) {
                return fetch(`{{route('trakrid-post')}}` , {
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'POST',
                    body : JSON.stringify({trakrid:trakrid})
                })
                .then(response => {
                    console.log(response);
                    if (!response.ok) {
                        throw new Error('Please input required field');
                    }
                    return response.json()
                })
                .catch(error => {
                    Swal.showValidationMessage('Trakr ID not found');
                })
            }else{
                Swal.showValidationMessage('Input data is required');
            }
        },
        allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                if (result.value.status == 'loggedin') {
                    Swal.fire({
                        title:'<strong> You already been signed in at </strong> <br/>',
                        html : '<b>'+result.value.check_date+'</b>',
                        allowOutsideClick : false,
                        showCloseButton: true,
                        confirmButtonText:'<i class="fa fa-thumbs-up"></i> Great!',
                        confirmButtonAriaLabel: 'Thumbs up, great!',
                    })
                }else{
                    Swal.fire({
                        title: '<strong>Welcome, '+result.value.name+'</strong>',
                        icon: 'success',
                        allowOutsideClick : false,
                        html:
                        'You have successfully been signed in at <br />' +
                        '<b>'+result.value.check_date+'</b>',
                        showCloseButton: true,
                        focusConfirm: false,
                        confirmButtonText:'<i class="fa fa-thumbs-up"></i> Great!',
                        confirmButtonAriaLabel: 'Thumbs up, great!',
                    })
                }
            }
        })
})
</script>
@endsection
