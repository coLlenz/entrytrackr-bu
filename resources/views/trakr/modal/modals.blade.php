<div class="checkin">
    <!-- Modal -->
    <div class="modal fade" id="checkinModal" tabindex="-1" role="dialog" aria-labelledby="checkin" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="checkin">Check In</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p class="text-info"> <i>NOTE: Phone number will be automatically set as a trakr ID for simple check-in</i> </p>
            <form id="form_checkin" action="{{ !$view_data['is_mobile'] ?  route( 'trakr-post' , auth()->user()->uuid ) : route( 'qr-login' ,$view_data['userid']) }}" method="post" class="needs-validation" novalidate>
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
                    <label for="phone" class="col-form-label">Phone #</label>
                    <input type="text" class="form-control" name="phoneNumber" required>
                    <div class="invalid-feedback">
                        <h3>Phone number is required.</h3>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-form-label">Email</label>
                    <input type="text" class="form-control" name="email" required>
                    <div class="invalid-feedback">
                        <h3>Please provide a valid email</h3>
                    </div>
                </div>
                <div class="form-group">
                    <label for="visitor_type" class="col-form-label">Visitor type</label>
                    <select class="form-control" name="visitor_type" required>
                        <option value=1>Visitor</option>
                        <option value=2>Contractor</option>
                        <option value=3>Employee</option>
                    </select>
                    <div class="invalid-feedback">
                        <h3>Please select type of visitor.</h3>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary save_check_in">Save</button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    
    <!-- MODAL CHECK OUT -->
    <div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Check Out</h5>
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
                    <label for="last_name" class="col-form-label">Phone #</label>
                    <input type="text" class="form-control" name="phoneNumber" required>
                    <div class="invalid-feedback">
                        <h3>Phone Number is required.</h3>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary save_check_out">Check out</button>
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
                        }).then(data => {
                            if (data.isConfirmed) {
                                flowCheckpoint(result.value);
                            }
                        })
                    }
                }
            })
    })
    // forms;
    let form = $('#form_checkin');
    let form2 = $('#form_checkout');
    
    $(form).on('submit' , function(e) {
        e.preventDefault();
        if (this.checkValidity()) {
            $.ajax({
                url : form.attr('action'),
                type: form.attr('method'),
                data : form.serialize(),
                success:function(response){
                    if (response.status == 'success') {
                        $('#checkinModal').modal('hide');
                        form[0].reset();
                        form.removeClass('was-validated');
                        Swal.fire({
                            title: '<strong>Welcome, '+response.name+'</strong>',
                            icon: 'success',
                            allowOutsideClick : false,
                            html:
                            'You have successfully been signed in at <br />' +
                            '<b>'+response.check_date+'</b>',
                            showCloseButton: true,
                            focusConfirm: false,
                            confirmButtonText:'<i class="fa fa-thumbs-up"></i> Great!',
                            confirmButtonAriaLabel: 'Thumbs up, great!',
                        }).then(isConfirmed => {
                            flowCheckpoint(response);
                        })
                    }
                }
            })
        }
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
                            title: 'No records found.',
                            showConfirmButton: false,
                            timer: 3000
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
                        Swal.fire({
                            title: '<strong>Goodbye, '+response.name+'</strong>',
                            icon: 'success',
                            allowOutsideClick : false,
                            html:
                            'You have successfully been signed out at <br />' +
                            '<b>'+response.check_date+'</b>',
                            showCloseButton: true,
                            focusConfirm: false,
                            confirmButtonText:'<i class="fa fa-thumbs-up"></i> Great!',
                            confirmButtonAriaLabel: 'Thumbs up, great!',
                        })
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
                        $('#checkinModal').modal('show');
                    }
                }
            }
        })
    });
    
    $('#continue').on('click' , function() {
        $('#notificationModal').modal('toggle');
        $('#checkinModal').modal('show');
    });
    
    $(document).on('click' , '#answerQuiz' , function(e) {
        e.preventDefault();
        alert('test');
    });
    
    function flowCheckpoint(response){
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        switch(response.type_of_visitor) {
            case '1':
                    Swal.fire({
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
                                success:function(response){
                                    if (response.status == 'success') {
                                        Swal.fire({
                                            position: 'top-end',
                                            icon: 'success',
                                            title: 'Data has been added to your logs.',
                                            showConfirmButton: false,
                                            timer: 3000
                                        })
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
                                success:function(response){
                                    if (response.status == 'success') {
                                        if (response.status == 'success') {
                                            Swal.fire({
                                                position: 'top-end',
                                                icon: 'success',
                                                title: 'Data has been added to your logs.',
                                                showConfirmButton: false,
                                                timer: 3000
                                            })
                                        }
                                    }
                                }
                            })
                        }
                    })
            break;
            case '3':
                    console.log(response);
                    if (response.questions) {
                        // var questions = JSON.parse(response.questions.questions);
                        Swal.fire({
                            title: 'Employee Questions',
                            icon: 'info',
                            html: makeHtml(response.questions , response.trakrid),
                            allowOutsideClick:false,
                            focusConfirm: false,
                            showConfirmButton:false,
                        })
                    }
                    return;
            break;
        default:
        // code block
        }
    }
    
    function makeHtml(questions , trakrid){
        var html = questions.content_html;
        var form = document.createElement('form');
        var button = '<br/><button type="submit"  class="btn btn-primary float-right" >Submit</>';
        var hiddenId = `<input type="hidden" name="questionId" value="${questions.id}" >`;
        var trakrid = `<input type="hidden" name="trakrid" value="${trakrid}" >`;
        $(form).attr('action' , "{{route('employee-answer')}}");
        $(form).attr('method' , 'POST');
        $(form).attr('id' , 'submitAnswer');
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
        $(form).append(button);
        return form;
    }
    
    $(document).on('submit' ,'#submitAnswer' , function(e) {
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        e.preventDefault();
        $.ajax({
            url : $(this).attr('action'),
            method: $(this).attr('method'),
            data: $(this).serialize(),
            success:function(response){
                if (response.examStatus) {
                    Swal.fire({
                        input: 'textarea',
                        inputLabel: 'Create Trakr ID',
                        inputPlaceholder:'eg. Phone number',
                        showCancelButton:false,
                        showCloseButton:false,
                        allowOutsideClick:false,
                        inputValidator: (value)=>{
                            if (!value) {
                                return 'Input value is required.'
                            }
                            
                            if (value) {
                                $.ajax({
                                    url : "{{route('check-trakr-id')}}",
                                    method: 'POST',
                                    data: {input : value},
                                    success:function(response){
                                        if (response.is_existing) {
                                            return value+' is already taken';
                                        }
                                    }
                                });
                            }
                        },
                    }).then( results => {
                        if (results.isConfirmed) {
                            var visitor_id = response.trakrid;
                            var trakr_id = results.value;
                            $.ajax({
                                url : "{{route('save-trakr-id')}}",
                                method : "POST",
                                data :{visitor_id : visitor_id , trakr_id: trakr_id},
                                success : function(response){
                                    if (response.status == 'success') {
                                        Swal.fire({
                                            position: 'center',
                                            icon: 'success',
                                            title: 'Trakr ID has been set.',
                                            showConfirmButton: false,
                                            timer: 2000
                                        })
                                    }
                                }
                            })
                        }
                    })
                }else{
                    Swal.fire({
                        title: '<strong>Access Denied.</strong>',
                        icon: 'error',
                        allowOutsideClick : false,
                        html:'We regret to inform you that you are not permitted to enter. Please report to the reception desk for further assistance',
                        showCloseButton: true,
                        focusConfirm: false,
                        confirmButtonText:'Okay',
                        confirmButtonAriaLabel: 'Okay',
                    })
                }
            }
        })
    })
    
</script>