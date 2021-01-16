<div class="checkin">
    <!-- Modal -->
    <div class="modal fade" id="checkinModal" tabindex="-1" role="dialog" aria-labelledby="checkin" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="checkin">Sign In</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
          </div>
        </div>
      </div>
    </div>
    
    <!-- MODAL CHECK OUT -->
    <div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Sign Out</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="form_checkout" action="{{route('trakrid-signout')}}" method="post" class="needs-validation" novalidate>
                @csrf
                <div class="form-group">
                    <label for="first_name" class="col-form-label">First Name</label>
                    <input type="text" class="form-control" name="first_name" required>
                    <div class="invalid-feedback">
                        <h3>First Name is require.</h3>
                    </div>
                </div>
                <div class="form-group">
                    <label for="last_name" class="col-form-label">Last Name</label>
                    <input type="text" class="form-control" name="last_name" required>
                    <div class="invalid-feedback">
                        <h3>Last Name is require.</h3>
                    </div>
                </div>
                <div class="form-group">
                    <label for="last_name" class="col-form-label">Phone Number</label>
                    <input type="text" class="form-control" name="phoneNumber" required>
                    <div class="invalid-feedback">
                        <h3 >Phone Number is required.</h3>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary btn_entry btnCheckoutCancel">Cancel</button>
                    <button type="submit" class="btn btn-primary save_check_out btn_entry">Sign Out</button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    
    <!-- NOTIFICATION MODAL -->
    <div class="modal fade" id="notificationModal" tabindex="-1" role="dialog" aria-labelledby="notificationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notificationModalTitle">Notification</h5>
                    <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button> -->
                </div>
                <div class="modal-body">
                    <div class="" id="editor_container"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="continue">Continue</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    var container = document.getElementById('editor_container');
    var editor = new Quill( container ,{
        theme : 'snow',
        modules : {
            toolbar : false,
        },
    });
    editor.enable(false);
    
    $('#simple_checkin').on('click', function() {
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
            Swal.fire({
            title: 'Enter your trakrID',
            input: 'text',
            inputAttributes: {
                autocapitalize: 'off'
            },
            showCancelButton: true,
            showConfirmButton: true,
            confirmButtonText: 'Sign In',
            confirmButtonColor: '#a3238e',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
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
                            title:'<strong> You have already signed in at </strong> <br/>',
                            html : '<b>'+result.value.check_date+'</b>',
                            allowOutsideClick : false,
                            showCloseButton: true,
                            confirmButtonText:'<i class="fa fa-thumbs-up"></i> OK',
                            confirmButtonAriaLabel: 'Thumbs up, great!',
                        })
                    }else{
                        flowCheckpoint(result.value)
                    }
                }
            })
    })
    // forms;
    let form = document.getElementById("form_checkin");
    let form2 = $('#form_checkout');
    
    $('.btnSign_cancel').on('click' , function() {
        $('#checkinModal').modal('hide');
        // form[0].reset();
        $(form).removeClass('was-validated');
        $('.invalid-email').hide();
    });
    
    $('.btnCheckoutCancel').on('click' , function() {
        $('#checkoutModal').modal('hide');
        form2[0].reset();
        $('#form_checkout').removeClass('was-validated');
    });
    
    $('#visitor_type').on('change' , function() {
        if ( $(this).val() != 1 ) {
            $('#sign_assitance').hide();
            $('#sign_assitance').prop('checked' , false);
        }else {
            $('#sign_assitance').show();
            $('#sign_assitance').prop('checked' , true);
        }
    });
    
    $(document).on('submit' , '#form_checkin',function(e) {
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        e.preventDefault();
            $.ajax({
                url : $(this).attr('action'),
                type: $(this).attr('method'),
                data : $(this).serialize(),
                success:function(response){
                    if (response.status == 'success') {
                        // $('#checkinModal').modal('hide');
                        flowCheckpoint(response);
                        $(form).removeClass('was-validated');
                        $('.invalid-email').hide();
                    }
                    
                    if (response.status == 'fail') {
                        $('.invalid-email').show();
                        alert('Please fill out the form properly');
                    }
                }
            })
    })
    
    $(form2).on('submit' , function(e){
        e.preventDefault();
        if (this.checkValidity()) {
            $.ajax({
                url : form2.attr('action'),
                type: form2.attr('method'),
                data: form2.serialize(),
                success: function(response){
                    if (response.status == 'nodata') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'No records found',
                            html:'<p>Please check that you have entered the same information that you provided on entry</p>',
                            showConfirmButton: false,
                            showCancelButton: true,
                            cancelButtonText:'Try Again',
                            cancelButtonColor: '#a3238e'
                        })
                    }
                    
                    if (response.status == 'loggedout') {
                        Swal.fire({
                            title:'<strong> You already been signed out at </strong> <br/>',
                            html : '<b>'+response.check_date+'</b>',
                            allowOutsideClick : false,
                            showCloseButton: true,
                            confirmButtonText:'<i class="fa fa-thumbs-up"></i> Great!',
                            confirmButtonAriaLabel: 'Thumbs up, great!',
                        });
                    }
                    
                    if (response.status == 'success') {
                        $('#checkoutModal').modal('hide');
                        form2[0].reset();
                        form2.removeClass('was-validated');
                        showCheckOutMessage(response);
                    }
                    
                    if (response.validation_error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Incomplete form data.',
                        })
                    }
                }
            })
        }
    });
    
    $('#modalCheckin').on('click' , function() {
        $.ajax({
            url : "{{ $view_data['is_mobile'] ? route('notification-check' , $view_data['userid']) : route('notification-check') }}",
            method: 'GET',
            success:function(response){
                if (response.status == 'success') {
                    if (response.has_notif) {
                        var json_content = JSON.parse(response.notif.content_json);
                        editor.setContents(json_content);
                        $('#notificationModal').modal({backdrop: 'static', keyboard: false})  
                    }else{
                        // $('#checkinModal').modal('show');
                        signIn();
                    }
                }
            }
        })
    });
    
    $('#continue').on('click' , function() {
        $('#notificationModal').modal('toggle');
        signIn();
    });
    
    function signIn(){
        Swal.fire({
            showClass: {
                popup: 'swal2-noanimation',
                backdrop: 'swal2-noanimation'
            },
            html: signInHtml(),
            showConfirmButton:false,
            allowOutsideClick:true,
            showCloseButton:true
        })
    }
    
    function signInHtml(){
        var html = '';
        html = `
        <form id="form_checkin" action="{{ !$view_data['is_mobile'] ?  route( 'trakr-post' , auth()->user()->uuid ) : route( 'qr-login' ,$view_data['userid']) }}" method="post" class="needs-validation" novalidate>
            @csrf
            <div class="form-group sign_in_box">
                <label for="first_name" class="col-form-label">First Name</label>
                <input type="text" class="form-control" name="first_name" required>
                <div class="invalid-feedback">
                    <h3>First Name is require</h3>
                </div>
            </div>
            <div class="form-group sign_in_box">
                <label for="last_name" class="col-form-label">Last Name</label>
                <input type="text" class="form-control" name="last_name" required>
                <div class="invalid-feedback">
                    <h3>Last Name is require</h3>
                </div>
            </div>
            <div class="form-group sign_in_box">
                <label for="phone" class="col-form-label">Phone Number</label>
                <input type="text" class="form-control" name="phoneNumber" required>
                <div class="invalid-feedback">
                    <h3>Phone number is required</h3>
                </div>
            </div>
            <div class="form-check sign_in_box" id="sign_assitance" style="color:#000!important">
                <input type="checkbox" class="form-check-input" id="need_assistance" name="need_assistance">
                <label class="form-check-label" for="need_assistance" >I require assistance in the event of an emergency evacuation.</label>
            </div>
            <div class="form-group sign_in_box">
                <label for="visitor_type" class="col-form-label">Visitor type</label>
                <select class="form-control" name="visitor_type" required id="visitor_type">
                    <option value=1>Visitor</option>
                    <option value=2>Contractor</option>
                    <option value=3>Employee</option>
                </select>
                <div class="invalid-feedback">
                    <h3>Please select type of visitor.</h3>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary save_check_in btn_entry">Next</button>
            </div>
        </form>
        `;
        return html;
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
        })
    }
    
    function showCheckOutMessage(details){
        Swal.fire({
            title: '<strong>Goodbye, '+details.name+'</strong>',
            icon: 'success',
            allowOutsideClick : false,
            html:
            'You have successfully been signed out at <br />' +
            '<b>'+details.check_date+'</b>',
            showCloseButton: false,
            showConfirmButton:false,
            timer: 5000,
            footer: '<p> This message will automatically close in 5 seconds. </p>'
        })
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
                            console.log('herrrrrrrrrrrrrrrrrrrrrrrreeeeeee');
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
    
    function flowCheckpoint(response){
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        switch(response.type_of_visitor) {
            case '1':
                    Swal.fire({
                        showClass: {
                            popup: 'swal2-noanimation',
                            backdrop: 'swal2-noanimation'
                        },
                        input: 'textarea',
                        inputLabel: 'Who are you visiting?',
                        inputPlaceholder: 'Type here...',
                        showCancelButton: false,
                        showCloseButton: false,
                        allowOutsideClick : false,
                        inputValidator: (value) => {
                            if (!value) {
                                return 'Please provide who are you visiting.'
                            }
                        },
                    }).then(complete => {
                        if (complete.isConfirmed) {
                            Swal.showLoading();
                            $.ajax({
                                url: "{{route('visiting-who')}}",
                                method:'POST',
                                data: {trakrid: response.trakrid , visited: complete.value},
                                success:function(data){
                                    if (response.status == 'success') {
                                        if (response.questions) {
                                            showQuestions(response)
                                        }else{
                                            createTrakrID(response);
                                        }
                                    }
                                },
                            })
                        }
                    });
            break;
            case '2':
                    Swal.fire({
                        input: 'textarea',
                        inputLabel: 'Name of Company/Business',
                        inputPlaceholder:'Type here...',
                        showCancelButton:false,
                        showCloseButton:false,
                        allowOutsideClick:false,
                        inputValidator: (value)=>{
                            if (!value) {
                                return 'Please provide name of company/business.';
                            }
                        },
                    }).then(complete => {
                        if (complete.isConfirmed) {
                            Swal.showLoading;
                            $.ajax({
                                url : "{{route('business')}}",
                                method: 'POST',
                                data:{trakrid:response.trakrid, name_of_business:complete.value },
                                success:function(data){
                                    if (data.status == 'success') {
                                        if (response.questions) {
                                            showQuestions(response)
                                        }else{
                                            createTrakrID(response);
                                        }
                                    }
                                }
                            })
                        }
                    })
            break;
            case '3':
                    if (response.questions) {
                        showQuestions(response)
                    }else{
                        showCheckInMessage(response);
                    }
                    return;
            break;
        default:
        // code block
        }
    }
    
    function showQuestions( data ){
        Swal.fire({
            showClass: {
                popup: 'swal2-noanimation',
                backdrop: 'swal2-noanimation'
            },
            title: data.questions.title,
            icon: 'info',
            customClass:'questionBox',
            html: makeHtml(data.questions , data.trakrid),
            allowOutsideClick:false,
            focusConfirm: false,
            showConfirmButton:false,
        })
    }
    
    function makeHtml(questions , trakrid){
        var html = questions.content_html;
        var form = document.createElement('form');
        var button = `
            <div class="float-right">
            <button type="button"  class="btn btn-outline-secondary mr-2 btnCancelQuestion" cancel-btn-data="${trakrid}">Cancel</>
            <br/><button type="submit"  class="btn btn-primary " >Submit</>
            </div>
        `;
        var hiddenId = `<input type="hidden" name="questionId" value="${questions.id}" >`;
        var trakrid = `<input type="hidden" name="trakrid" value="${trakrid}" >`;
        $(form).attr('action' , "{{route('employee-answer')}}");
        $(form).attr('method' , 'POST');
        $(form).attr('id' , 'submitAnswer');
        $(form).append(`<p class="text-left mb-4"> ${questions.description} </p> <hr/>`);
        $(form).append(html);
        $(form).append(hiddenId);
        $(form).append(trakrid);
        $(form).find('.form-group').remove();
        $( $(form).find('.custom-control') ).each( (idx , item) => {
            $(item).css('display' , 'flex');
            $( $(item).find('input[type=radio]') ).each( (idx2 , item2) => {
                $(item2).attr('required' , 'true');
            });
        })
        $(form).append( tempCheck() );
        $(form).append(button);
        return form;
    }
    
    function tempCheck(){
        var html = `
            <div class="form-group text-center">
                <label for="temp_check" class="col-form-label">
                <h2> Temperature Check </h2>
                <span> <p> <h2>My temperature has been tested on entry today and the result was:</h2> </p> </span>
                </label>
                <input style="margin:0 auto;" type="number" step="0.01" class="form-control col-md-4" name="temp_check" placeholder="Enter your Temperature here..." required>
            </div>
        `;
        
        return html;
    }
    
    $(document).on('click' , '.btnCancelQuestion' , function(){
        var trakr_id = $(this).attr('cancel-btn-data');
        Swal.showLoading();
        $.ajax({
            url : '/trakr/visitor/cancel/'+trakr_id,
            method: 'GET',
            success:function(response){
                if (response.status === 'success') {
                    return Swal.close();
                }
                alert('Network error. Please try refreshing the page');
            }
        })
    })
    
    $(document).on('submit' ,'#submitAnswer' , function(e) {
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        e.preventDefault();
        $.ajax({
            url : $(this).attr('action'),
            method: $(this).attr('method'),
            data: $(this).serialize(),
            success:function(response){
                if (response.examStatus) {
                    createTrakrID(response);
                }else{
                    Swal.fire({
                        title: '<strong>Access Denied</strong>',
                        icon: 'error',
                        allowOutsideClick : false,
                        html:'We regret to inform you that you are not permitted to enter. Please report to the reception desk for further assistance.',
                        showCloseButton: false,
                        focusConfirm: false,
                        showConfirmButton:false,
                        timer: 10000,
                        footer: '<p> This message will automatically close in 10 seconds. </p>'
                    })
                    // form[0].reset();
                }
            }
        })
    })
    
</script>