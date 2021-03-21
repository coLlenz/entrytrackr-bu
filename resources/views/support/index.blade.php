@extends('layouts.app')
@section('content')
<div class="contanier-fluid">
    <div class="row justify-content-md-center">
        <div class="col-md-6 col-lg-6">
            <div class="card">
                <div class="card-body">
                <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-support-tab" data-toggle="tab" href="#nav-support" role="tab" aria-controls="nav-support" aria-selected="true">Contact Support</a>
                <a class="nav-item nav-link" id="nav-help-tab" data-toggle="tab" href="#nav-help" role="tab" aria-controls="nav-help" aria-selected="false">Help Center</a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-support" role="tabpanel" aria-labelledby="nav-support-tab">
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
            <div class="tab-pane fade" id="nav-help" role="tabpanel" aria-labelledby="nav-help-tab">
                <p class="mt-4">
                    Search our library for help on how to use the various feature of Entrytrakr. 
                    If you can't find what you are looking for, please contact our customer support team using the 'Contact Support' tab on this page.
                </p>
               
                @if (!$help->isEmpty())
                <div id="accordion">
                    @foreach ( $help as $list )
                    <div class="card">
                        <div class="card-header" id="heading{{$list->id}}">
                        <h5 class="mb-0">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapse{{$list->id}}" aria-expanded="true" aria-controls="collapse{{$list->id}}">
                                {{ $list->title }}
                            </button>
                        </h5>
                        </div>

                        <div id="collapse{{$list->id}}" class="collapse" aria-labelledby="heading{{$list->id}}" data-parent="#accordion">
                        <div class="card-body">
                            {!! $list->content !!}
                        </div>
                        </div>
                    </div>        
                    @endforeach
                </div>
                @endif
            </div>
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