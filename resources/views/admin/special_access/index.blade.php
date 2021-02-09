@extends('admin.layouts.admin')
@section('content')
<div class="row ">
    <div class="col-lg-8">
        <h1>Special Access</h1>
    </div>
</div>
<div class="row justify-content-md-center">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <th class="text-center">Name</th>
                        <th class="text-center">Action</th>
                    </thead>
                    <tbody>
                        @if(!$has_access->isEmpty())
                            @foreach($has_access as $access)
                                <td class="text-center">{{$access->contactName}}</td>
                                <td class="text-center"> <a href="#" class="access-trigger" data-toggle="modal" data-target="#Modal" access-id="{{$access->id}}">Edit</a> </td>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Select Account</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="" action="{{route('special-save')}}" method="post" id="special_access_form">
            @csrf
            <select class="form-control" id="form_select" name="to_account">
              @foreach($accounts as $account)
              <option value="{{$account->id}}">{{$account->name}}</option>
              @endforeach
            </select>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="special_access">Save</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="{{ asset('js/vendor/jquery-3.3.1.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var access_id = '';
        
        $('.access-trigger').on('click' , function(){
            $('#Modal').modal('show');
            access_id = $(this).attr('access-id');
        });
        
        $('#special_access').on('click' , function(e){
            e.preventDefault();
            var action = $('#special_access_form').attr('action');
            var formData = $('#special_access_form').serializeArray();
            formData.push({ name: "from_account", value: access_id });
            $.ajax({
                url : action,
                type : 'POST',
                data : formData,
                success : function(response) {
                    if (response.status) {
                        alert('Done');
                        $('#Modal').modal('hide');
                    }
                }
            })
        })
    })
</script>
@endsection