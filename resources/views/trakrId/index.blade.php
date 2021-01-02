@extends('layouts.app')

@section('content')
<div class="mb-2">
    <h1>trakrID</h1>
    @if(!auth()->user()->is_admin)
        <div class="top-right-button-container">
            <button type="button" class="btn btn-primary btn-lg top-right-button  mr-1"
        onclick="window.location.href='{{route("trakr-add")}}'">ADD NEW</button>
        </div>
    @endif
</div>
<div class="card">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th class="">TrakrID</th>
                    <th class="">Name</th>
                    <th class="">Date Created</th>
                    <th class="">Visitor Type</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($list_data as $trakr )
                    <tr>

                    <td>{{$trakr->trakr_id}}</td>
                        <td>{{$trakr->firstName}} {{$trakr->lastName}}</td>
                        <td>{{$trakr->created_at}}</td>
                        <td>{{$trakr->type}}</td>
                        <td class="text-center">
                            <button class="btn btn-primary dropdown-toggle mb-1" type="button"
                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                Actions
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="{{route("trakr-edit",$trakr->id)}}">Edit</a>
                                <a class="dropdown-item" href="{{route("trakr-delete",$trakr->id)}}">Delete</a>
                                <a class="dropdown-item manualSignOut" href="#" data-id="{{$trakr->id}}">Sign Out</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </div>
            </tbody>
        </table>
        {{$list_data->links()}}
    </div>
</div>

<script src="{{ asset('js/vendor/jquery-3.3.1.min.js') }}" charset="utf-8"></script>
<script src="{{ asset('js/vendor/sweetalert2@10.js') }}" charset="utf-8"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('.manualSignOut').on('click' , function() {
        var thiS = $(this);
        var data_id = $(this).attr('data-id');
        Swal.fire({
            title: 'This will manually sign out the visitor.',
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: `Procced`,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
                Swal.showLoading();
                $.ajax({
                    url :`{{route('manualSignOut')}}`,
                    type : 'POST',
                    data : {data_id : data_id},
                    success: function(response){
                        if (response.status) {
                            $(thiS).closest('tr').fadeOut();
                        }
                    }
                })
            }
        })
    })
})
</script>
@endsection