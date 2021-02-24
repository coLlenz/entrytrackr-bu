@extends('layouts.app')

@section('content')
    <div class="row justify-content-md-center">
        <div class="col-md-10">
            <h1> Manage Users </h1>
        </div>
        <!-- <div class="col-md-2">
            <button type="button" name="button" class="btn btn-primary btn-md float-right">Add User</button>
        </div> -->
    </div>
    <div class="row justify-content-md-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>User Name</th>
                                <th>Email</th>
                                <th class="text-center">Created</th>
                                <th class="text-center">Updated</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @if(!empty($lists))
                                    @foreach( $lists as $list )
                                    <tr>
                                        <td> {{$list->contactName}} </td>
                                        <td> {{$list->email}} </td>
                                        <td class="text-center"> 
                                            {{ \Carbon\Carbon::parse($list->created_at)->format('d-m-Y H:i') }} 
                                        </td>
                                        <td class="text-center"> 
                                            {{\Carbon\Carbon::parse($list->updated_at)->format('d-m-Y H:i') }}
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-primary dropdown-toggle mb-1" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                Actions
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="#" data="{{ $list->id }}" id="_editAccount">Edit</a>
                                            {{--    <a class="dropdown-item" href="#" data="{{ $list->id }}" >Delete</a>--}}
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
{{-- MODAL --}}
<div class="modal fade" id="editAccount" tabindex="-1" role="dialog" aria-labelledby="editAccountLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editAccountLabel">Edit Account</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editForm">
            <div class="form-group">
                <label for="username">User name</label>
                <input type="text" name="username" class="form-control" id="edit_username">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" id="edit_email">
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="editformBtn">Save changes</button>
      </div>
    </div>
  </div>
</div>
<script src="{{ asset('js/vendor/jquery-3.3.1.min.js')}}"></script>
<script type="text/javascript">
    var account = false;
    
    $('#_editAccount').on('click' , function(){
        $('#editAccount').modal('show');
        var data_ = $(this).attr('data');
        account = data_;
        fetchAccount(data_);
    });
    
    $('#editformBtn').on('click' , function(){
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        var datas = $('#editForm').serialize() + '&account=' + account;
        $.ajax({
            url: "{{route('accountDetailsSave')}}",
            type:'POST',
            data : datas,
            success:function(response){
                if (response.status == 'success') {
                    location.reload();
                }
                
                if (response.form_error) {
                    alert('Please fill up the form correctly');
                }
                
                if (response.error) {
                        alert('There\'s an error while saving your information. Please reload this page');
                }
            }
        })
    })
    
    function fetchAccount( account_id ){
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        var return_data = [];
        $.ajax({
            url : "{{route('accountDetails')}}",
            type : "POST",
            data : {account_id : account_id},
            success:function(response){
                $('#edit_username').val(response.username);
                $('#edit_email').val(response.email);
            }
        })
        
    }
</script>
@endsection