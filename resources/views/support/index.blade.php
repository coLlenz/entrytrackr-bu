@extends('layouts.app')
@section('content')
<div class="contanier-fluid">
    <div class="row justify-content-md-center">
        <div class="col-md-6 col-lg-6">
            <div class="card">
                <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="contact_tab" data-toggle="tab" href="#contact_content" role="tab" aria-controls="contact_content" aria-selected="true">Contact Support</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#help" role="tab" aria-controls="help" aria-selected="false">Help Center</a>
                    </li>
                </ul>

                <div class="tab-content" id="support_tab_contents">
                    <div class="tab-pane fade show active" id="contact_content" role="tabpanel" aria-labelledby="contact_tab">
                        <form action="" class="mt-4" id="send_email">
                        <p>Complete this form to submit a support request with our Customer Support Team. Please provide as much information as possible to help as understand the nature of your request so that we can respond to you quickly.
                            In most cases you will receive a response from us within 24 hours</p>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="support_name">Name</label>
                                    <input type="text" class="form-control" id="support_name" name="support_name"  aria-describedby="support_name" placeholder="Enter name">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="support_email">Email</label>
                                    <input type="text" class="form-control" id="support_email" name="support_email"  aria-describedby="support_email" placeholder="Enter email">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="support_phone">Phone Number  <span> <i>(optional)</i> </span> </label>
                                    <input type="text" class="form-control" id="support_phone" name="support_phone"  aria-describedby="support_phone" placeholder="Enter phone">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="report_request">Message</label>
                                    <textarea name="report_request" id="" cols="30" rows="10" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <button type="submit"  class="btn btn-primary btn-lg float-right">Send</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="help" role="tabpanel" aria-labelledby="help">Help Support</div>
                   
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/vendor/jquery-3.3.1.min.js')}}"></script>
<script src="{{ asset('js/vendor/sweetalert2@10.js')}}"></script>
<script>
    $(document).ready(function() {
        
        $('#send_email').on('submit' , function(e) {
            Swal.showLoading();
            e.preventDefault();
            var form = $(this);
            ajaxSend(form);
        });

       
       function ajaxSend( form ){
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
            $.ajax({
                url : "{{ route('support_email') }}",
                type : 'POST',
                data : form.serialize(),
                success:function( response ) {
                    if (response.status == 'success') {
                        success( response )
                    }
                }
            })
       }

        function success(sett){
            Swal.fire({
                position: 'top-end',
                title: sett.msg,
                icon: sett.icon,  
            });
        }
    });
</script>
@endsection