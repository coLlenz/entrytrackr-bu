@extends('trakr.layouts.app')
@section('content')
<input type="text" id="desc" value="{{$description}}">
<div class="row justify-content-md-center to_center">
    <div class="col-lg-8 col-md-8 col-sm-12">
        <div class="card et_stepper_container">
            <div class="card-body ">
                <div id="entryStepper">
                    <div class="steps mb-4">
                        @foreach($questions as $key => $value)
                            <section class="et_section_none" >
                                <div class="choiceContainer">
                                <h3 class="mb-4 font-weight-bold">{{$value['question']}}</h3>
                                    @if($value['type'] == 'basic')
                                        <div class="et_choices">
                                            <button type="button" name="btn_choice" class="et_btn et_btn_primary et_trigger mr-4" data-value="A" data-idx="{{$key}}"> {{$value['answers']['a']}} </button>
                                            <button type="button" name="btn_choice" class="et_btn et_btn_secondary et_trigger" data-value="B" data-idx="{{$key}}"> {{$value['answers']['b']}} </button>
                                        </div>
                                    @else
                                    <textarea name="name" rows="8" cols="80" class="form-control freetext" data-idx="{{$key}}"></textarea>
                                    @endif
                                </div>
                            </section>
                        @endforeach
                        
                        <section class="et_section_none">
                            <div class="choiceContainer" >
                            <h3 class="mb-4 font-weight-bold">{{'Temperature Check'}}</h3>
                            <span> <p> <h2>My temperature has been tested on entry today and the result was:</h2> </p> </span>
                                <div>
                                    <input step=".1"type="number" name="name" class="form-control freetext tp" data-idx="temperature"></input>
                                </div>
                            </div>
                        </section>
                        
                    </div>

                    <div class="float-left ">
                        <button type="button" name="button" class="et_btn et_btn_secondary et_btn_cancel et_btn_clored"  > Cancel </button>
                    </div>
                    <div class="stepsControll float-right">
                        <button type="button" name="button" class="et_btn et_btn_secondary et_btn_control mr-4" data-value="Previous" > Back </button>
                        <button type="button" name="button" class="et_btn et_btn_primary et_btn_control et_btn_control_next" data-value="Next"> Continue </button>
                    </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/vendor/jquery-3.3.1.min.js')}}"></script>
<script src="{{ asset('js/vendor/sweetalert2@10.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var index = 0;
        var answers = [];
        var stepper = $('#entryStepper');
        var steps = $(stepper).find('.steps');
        var length = $(steps).children().length;
        
        showTitle();
        Stepper(index);
        
        $('.et_btn_cancel').on('click' ,function(){
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
            $.ajax({
                url :"{{route('cancelSignin' , $visitor_id)}}",
                type : 'GET',
                success : function(response){
                    if (response.status == 'success') {
                        window.history.back();
                    }
                }
            })
        });
        
        $('.et_trigger').on('click' , function(){
            var parent = $(this).parent();
            var active = $(parent).find('.et_trigger_active');
            if ($(active).hasClass('et_trigger_active')) {
                $(active).removeClass('et_trigger_active');
            }
            var dataIndex = $(this).attr('data-idx');
            var dataValue = $(this).attr('data-value');
            $(this).addClass('et_trigger_active');
            myAnswers(dataIndex , dataValue , 'basic');
        });
        
        $('.freetext').on('change keyup' , function(){
            var index = $(this).attr('data-idx');
            var text = $(this).val();
            myAnswers(index , text , 'freetext');
        });
        
        $('.et_btn_control').on('click' , function(){
            var action = $(this).attr('data-value');
            if (action === 'Next') {
                index++;
                Stepper(index , action);
            }else{
                if (index === 0 ) return;
                index--;
                Stepper(index , action);
            }
        });
        
        function Stepper(step , action){
            if ( !isLast(step) ) {
                if (action === 'Next') {
                    var prev =  $(steps).children()[step -1];
                    var next =  $(steps).children()[step];
                    $(prev).fadeOut();
                    setTimeout(function () {
                        $(next).fadeIn();
                    }, 1000);
                } else {
                    var prev =  $(steps).children()[step];
                    var current =  $(steps).children()[step + 1];
                    $(current).fadeOut();
                    setTimeout(function () {
                        $(prev).fadeIn();
                    }, 1000);
                }
            } else {
                submitAnswers();
            }
            
        }
        
        function isLast(step){
            return step == length ? true : false;
        }
        
        function myAnswers( index , value , type){
            answers[index] = { answer : value , type : type };
        }
        
        function submitAnswers(){
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
            var data = JSON.stringify(answers);
            var user_id = "{{$user_id}}";
            var question_id = "{{$question_id}}";
            var visitor_id = "{{$visitor_id}}";
            
            if (typeof answers['temperature'] === 'undefined') {
                return alert('Temperature is required.');
            }
            
            var temp = answers['temperature'].answer;
            
            $.ajax({
                url : "{{route('stepperSave')}}",
                type: 'POST',
                data : {
                    answers : data , 
                    temp:  temp , 
                    user_id : user_id , 
                    question_id: question_id , 
                    visitor_id : visitor_id
                },
                success:function(response){
                    if (!response.error) {
                        if (response.examStatus) {
                            if (response.has_trakr) {
                                return showCheckInMessage(response);
                            }else{
                                return createTrakrID(response);
                            }
                        }else{
                            return showDenied();
                        }
                    }else{
                        alert('There\'s an error submitting your data. Please re-check and submit it again.');
                    }
                }
            })
        }
        
        function showCheckInMessage(details){
            Swal.fire({
                showClass: {
                    popup: 'swal2-noanimation',
                    backdrop: 'swal2-noanimation'
                },
                title: '<strong>Welcome, '+details.name+'</strong>',
                icon: 'success',
                allowOutsideClick : false,
                html:
                'You have successfully been signed in at <br />' +
                '<b>'+details.check_date+'</b>',
                showCloseButton: false,
                showConfirmButton:false,
                timer: 5000,
                footer: '<p> This message will automatically close in 5 seconds. </p>'
            });
            
            setTimeout(function () {
                window.history.back();
            }, 5000);
        }
        
        function showDenied(){
            Swal.fire({
                title: '<strong>Access Denied</strong>',
                icon: 'error',
                allowOutsideClick : false,
                html:'We regret to inform you that you are not permitted to enter. Please report to the reception desk for further assistance.',
                showCloseButton: false,
                focusConfirm: false,
                showConfirmButton:false,
                timer: 5000,
                footer: '<p> This message will automatically close in 5 seconds. </p>'
            });
            
            setTimeout(function () {
                window.history.back();
            }, 5000);
        }
        
        function createTrakrID(trakr_data = false){
            
            if (trakr_data.has_trakr) {
                return showCheckInMessage(trakr_data);
            }
            
            Swal.fire({
                showClass: {
                    popup: 'swal2-noanimation',
                    backdrop: 'swal2-noanimation'
                },
                icon:'info',
                html:`
                <p style="font-size: 17px;" class="mb-4">For a Faster Sign In on future visits, save your contact information as a trakrID.</p>
                <p style="font-size: 17px;">Create your trakrID using letters, numbers and symbols.</p>
                `,
                input:'text',
                inputPlaceholder: 'Type trakrID here...',
                showCancelButton:true,
                cancelButtonText:'Skip',
                showConfirmButton:true,
                confirmButtonText:'Save',
                allowOutsideClick : false,
                reverseButtons:true,
                inputValidator : (value) => {
                    return new Promise((resolve) => {
                        if (value) {
                            $.ajax({
                                url : "{{route('check-trakr-id')}}",
                                method: 'POST',
                                data: {input : value},
                                success: function(response){
                                    if (response.is_existing) {
                                        resolve('trakrID not available, try again.');
                                    }else {
                                        resolve();
                                    }
                                }
                            });
                        } else {
                            resolve('Input data is required');
                        }
                    })
                },
                preConfirm:(data) => {
                    $.ajax({
                        url : "{{route('check-trakr-id')}}",
                        method: 'POST',
                        data: {input : data},
                        success: function(response){
                            if (response.is_existing) {
                                return Swal.showValidationMessage('trakrID is not Available');
                            }
                        }
                    });
                }
            }).then( btnPress => {
                if (btnPress.isConfirmed) {
                    var trakrID = btnPress.value;
                    var visitor_id = trakr_data.trakrid;
                    $.ajax({
                        url: "{{ route('save-trakr-id') }}",
                        method: "POST",
                        data: {visitor_id:visitor_id , trakr_id:trakrID },
                        success:function(trakrResponse){
                            if (trakrResponse.status == 'success') {
                                showCheckInMessage(trakr_data);
                            }
                        }
                    })
                }else{
                    showCheckInMessage(trakr_data);
                }
            })
        }
        
        function showTitle(){
            var desc = $('#desc').val();
            Swal.fire({
                icon:'info',
                title :"{{$title}}",
                html : "<p>"+desc+"</p>",
                allowOutsideClick:false,
                customClass:'questionBox_2',
                showCloseButton:true,
                confirmButtonText : 'Continue',
                confirmButtonColor:'#a3238e'
            });
        }
        
    })
</script>
@endsection