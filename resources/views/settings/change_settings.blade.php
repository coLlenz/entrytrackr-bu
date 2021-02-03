@extends('layouts.app')
@section('content')
<div class="row justify-content-md-center">
    <div class="col-md-6 col-lg-4 mb-4 col-sm-12">
        @if(empty($settings) || $settings->settings == 0 )
            <div class="card et_view_selected" data-value="0">
        @else
            <div class="card et_view_not_selected change_view_settings" data-value="0">
        @endif
            <div class="position-relative">
                <img class="card-img-top"src="https://qrlogins.s3-ap-southeast-2.amazonaws.com/question_view/one_page_questionnaire.png" alt="Card image cap"> 
                @if(empty($settings) || $settings->settings == 0)
                    <span class="badge badge-pill badge-secondary position-absolute badge-top-left">DEFAULT</span>
                @endif
            </div>
            <div class="card-body">
                <p class="list-item-heading mb-4"> <h3>One Page Questionnaire</h3> </p>
                <footer>
                    
                </footer>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-4 col-sm-12">
        @if(isset($settings) && $settings->settings == 1)
            <div class="card et_view_selected" data-value="1">
        @else
            <div class="card et_view_not_selected change_view_settings" data-value="1">
        @endif
            <div class="position-relative">
                <img class="card-img-top"  src="https://qrlogins.s3-ap-southeast-2.amazonaws.com/question_view/stepper_questionnaire.png" alt="Card image cap"> 
            </div>
            <div class="card-body">
                <p class="list-item-heading mb-4"> <h3> Stepper Questionnaire </h3> </p>
                    @if(isset($settings) && $settings->settings == 1)
                        <span class="badge badge-pill badge-secondary position-absolute badge-top-left">SELECTED</span>
                    @endif
                <footer>
                    
                </footer>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/vendor/jquery-3.3.1.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.change_view_settings').on('click' , function(){
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
            var settings = $(this).attr('data-value');
            $.ajax({
                url: "{{route('saveSettings')}}",
                type : "POST",
                data : {settings : settings },
                success:function(response){
                    location.reload();
                }
            })
        });
    });
</script>
@endsection