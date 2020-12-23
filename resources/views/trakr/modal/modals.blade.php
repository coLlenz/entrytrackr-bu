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
            <form id="form_checkin" action="{{route( 'trakr-post' , auth()->user()->uuid )}}" method="post" class="needs-validation" novalidate>
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
                    <input type="text" class="form-control" name="phone" required>
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
                    <input type="text" class="form-control" name="first_name_checkout" required>
                    <div class="invalid-feedback">
                        <h3>First Name is require.</h3>
                    </div>
                </div>
                <div class="form-group">
                    <label for="last_name" class="col-form-label">Last Name</label>
                    <input type="text" class="form-control" name="last_name_checkout" required>
                    <div class="invalid-feedback">
                        <h3>Last Name is require.</h3>
                    </div>
                </div>
                <div class="form-group">
                    <label for="last_name" class="col-form-label">Phone #</label>
                    <input type="text" class="form-control" name="phoneNumber_checkout" required>
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
</div>
<script type="text/javascript">
    // forms;
    let form = $('#form_checkin');
    let form2 = $('#form_checkout');
    
    $(form).on('submit' , function(e) {
        e.preventDefault();
        if (this.checkValidity()) {
            Swal.showLoading();
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
                    // check possible notifications/alerts/questionaires
                    
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
            case 2:
                alert('Contractor');
            break;
            case 3:
                alert('Employee');
            break;
        default:
        // code block
        }
    }
</script>