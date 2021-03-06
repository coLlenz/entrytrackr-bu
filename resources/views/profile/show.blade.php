@extends('layouts.app')

@section('content')
<script src="{{ asset('js/vendor/jquery-3.3.1.min.js')}}"></script>
<style media="screen">
    .entry_box:hover{
        background: #922c88;
        transition: 1s
    }
    .error{
        color: #FF0000; 
    }
    .alert-minimalist {
	background-color: rgb(241, 242, 240);
	border-color: rgba(149, 149, 149, 0.3);
	border-radius: 3px;
	color: rgb(149, 149, 149);
	padding: 4px;
}
</style>
    <section class="uk-section">
        <div class="uk-container">
            @if( !auth()->user()->sub_account )
            <div class="row">
                <div class="col-12">
                    <div class="row icon-cards-row mb-4">
                        <div class="col-md-3 col-lg-2 col-sm-4 col-6 mb-4 entry_box">
                            <a href="" class="card" data-toggle="modal" data-target="#add_user_modal">
                                <div class="card-body text-center">
                                    <i class="fa fa-user-plus" aria-hidden="true"></i>
                                    <p class="card-text font-weight-semibold mb-0">Add User</p>
                                    <!-- <p class="lead text-center">10</p> -->
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-lg-2 col-sm-4 col-6 mb-4 entry_box">
                            <a href="{{route('customerAdmins')}}" class="card">
                                <div class="card-body text-center">
                                    <i class="fa fa-users" aria-hidden="true"></i>
                                    <p class="card-text font-weight-semibold mb-0">Manage Users</p>
                                    <!-- <p class="lead text-center">10</p> -->
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updateProfileInformation()))
                @include('profile.update-profile-information-form')
            @endif
            
            @if(!auth()->user()->is_admin)
                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="mb-4"> Visitor Management </h4>

                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <p style="margin-top: 12px;">URL: {{ url( 'trakr/qr/login/'.auth()->user()->uuid.'/'.(auth()->user()->sub_account ? auth()->user()->sub_account_id : auth()->user()->id)) }} </p>
                                <a target="_blank" class="btn btn-primary btn-md mr-4" href="{{ url( 'trakr/qr/login/'.auth()->user()->uuid.'/'.(auth()->user()->sub_account ? auth()->user()->sub_account_id : auth()->user()->id) ) }}"> Visitor Sign in Page</a>
                            </div>
                        </div>
                          
                    </div>
                </div> 
                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="mb-4"> Questionnaire View Options </h4>

                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <a class="btn btn-primary btn-md mr-4 text-light" href="{{route('viewSettings')}}"> Change View </a>
                            </div>
                        </div>
                          
                    </div>
                </div> 
                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="mb-4"> Automatic Sign Out Settings </h4>
                        <p>Set the length of time (in hours) for each Visitor Type to be automatically signed out.</p>
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                @if (Session::has('message'))
                                   <div class="alert alert-info">
                                       <span>{{Session::get('message')}}</span>
                                   </div>
                                @endif
                                <form class="" action="{{route('signOutSettings')}}" method="POST" id="signOutSettings">
                                        @csrf
                                        <div class="et_signout_settings">
                                            <div class="settings_">
                                                <input type="checkbox" name="employee" value="1" id="employee" {{isset($settings->employee) && $settings->employee != 0 ? 'checked' : ''}}>
                                                <label for="employee">Employee</label>
                                                <input type="number" name="set_employee" value="{{isset($settings->employee) ? $settings->employee : 0}}" class="et_signOut_input" min="0" >
                                            </div>
                                            <div class="settings_">
                                                <input type="checkbox" name="visitor" value="1" id="visitor" {{isset($settings->visitor) && $settings->visitor != 0 ? 'checked' : ''}}>
                                                <label for="visitor">Visitor</label>
                                                <input type="number" name="set_visitor" value="{{isset($settings->visitor) ? $settings->visitor : 0}}" class="et_signOut_input" min="0" >
                                            </div>
                                            <div class="settings_">
                                                <input type="checkbox" name="contractor" value="1" id="contractor" {{isset($settings->contractor) && $settings->contractor != 0 ? 'checked' : ''}} >
                                                <label for="contractor">Contractor</label>
                                                <input type="number" name="set_contractor" value="{{isset($settings->contractor) ? $settings->contractor : 0}}" class="et_signOut_input" min="0" >
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-md" name="saveBtn">Save</button>
                                </form>
                            </div>
                        </div>
                          
                    </div>
                </div> 

                <div class="card mb-4">
                    <div class="card-body">
                    <h4 class="mb-4"> Feedback Settings </h4>
                    <p>Select the visitor type(s) to activate and collect feedback during sign out.</p>
                    <form action="{{route('feedbackSettings')}}" id="feedbackForm">
                        @csrf
                        <div class="et_signout_settings">
                            <div class="settings_">
                                <input type="checkbox" name="employee" value="1" id="feed_employee" {{isset($feedback->employee) && $feedback->employee != 0 ? 'checked' : ''}}>
                                <label for="feed_employee">Employee</label>
                            </div>
                            <div class="settings_">
                                <input type="checkbox" name="visitor" value="1" id="feed_visitor" {{isset($feedback->visitor) && $feedback->visitor != 0 ? 'checked' : ''}}>
                                <label for="feed_visitor">Visitor</label>
                            </div>
                            <div class="settings_">
                                <input type="checkbox" name="contractor" value="1" id="feed_contractor" {{isset($feedback->contractor) && $feedback->contractor != 0 ? 'checked' : ''}}>
                                <label for="feed_contractor">Contractor</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-md" name="saveBtn_feed">Save</button>
                    </form>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="mb-4"> QR Code </h4>
                        <p style=""> Print your QR code to create additional Sign In and Sign Out access points. </p>
                        
                        <div class="row justify-content-md-center">
                            <div class="col-md-12">
                                <a href="{{ route('qrpdf') }}" class="btn btn-primary btn-md" > Print PDF </a>
                            </div>
                        </div>
                        
                    </div>
                </div> 
            @endif
            
            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                @include('profile.update-password-form')
            @endif

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::twoFactorAuthentication()))
                @include('profile.two-factor-authentication-form')
            @endif
        </div>
    </section>
    <div class="card mb-4">
        <div class="modal fade modal-right" id="add_user_modal" tabindex="-1" role="dialog" aria-labelledby="add_user_modal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="add_admin_user" method="POST" action={{route('add-new-admin')}}>
                            @csrf
                            <div class="form-group">
                                <label>Full Name</label> 
                                <input type="text" class="form-control" placeholder="" name="admin_name">
                            </div>
                            <div class="form-group">
                                <label>Email</label> 
                                <input type="email" class="form-control" placeholder="" name="admin_email">
                            </div>
                            
                            <div class="form-group">
                                <label>Password</label> 
                                <input type="password" class="form-control" placeholder="" name="admin_password" id="admin_password">
                            </div>
                            
                            <div class="form-group">
                                <label>Re-type password</label> 
                                <input type="password" class="form-control" placeholder="" name="admin_password_confirmation">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button> 
                                <button type="submit" class="btn btn-primary">Add User</button>
                            </div>
                        </form>
                        <div class="error_box">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
@endsection
@section('script')
<script src="{{ asset('js/vendor/jquery.validate/jquery.validate.min.js') }}"></script>
<script src="{{ asset('js/vendor/sweetalert2@10.js')}}"></script>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });

        $('#add_admin_user').on('submit' , function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data : $(this).serialize(),
                success : function(response_data){
                    if (response_data.error) {
                        let html = '';
                        $.each(response_data.error , function(idx , val) {
                            html += `<div class="alert alert-warning" role="alert">${val}</div>`;
                        });
                        $('.error_box').html(html);
                    }else{
                        $('.error_box').html(`<div class="alert alert-warning" role="alert">${response_data.msg}</div>`).fadeIn();
                        setTimeout(function () {
                            $('#add_user_modal').modal('hide');
                            $('#add_admin_user')[0].reset();
                            $('.error_box').html('');
                        }, 1200);
                    }
                }
            })
        });

        $('#feedbackForm').on('submit' , function(form){
            form.preventDefault();
            var data = $(this).serialize();
            var url = $(this).attr('action');

            $.ajax({
                url : url ,
                type : 'POST',
                data : data,
                success:function(res){
                    if (res) {
                        success(); 
                    }
                }
            })
        });

        function success(){
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Changes has been saved.',
                showConfirmButton: false,
                timer: 2000
            })
        }
        
    });
</script>

@endsection
