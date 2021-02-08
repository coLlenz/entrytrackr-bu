@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8">
        <h1>trakrID</h1>
    </div>
    <div class="col-md-2">
        <div class="float-right">
            <form action="{{route('searchTrakr')}}" method="GET" style="display: flex">
                <button type="submit" name="button" class="btn btn-primary entry_md_btn mr-2"> Search </button>
                <input type="text" name="search" value="{{isset($_GET['search']) ? $_GET['search'] : ''}}" class="form-control">
            </form>
        </div>
    </div>
<div class="col-md-2">
    <div class="float-right">
        <button type="button" class="btn btn-primary btn-lg top-right-button  mr-1"
        onclick="window.location.href='{{route("trakr-add")}}'">ADD NEW</button>
    </div>
</div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="">trakrID</th>
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
                            <td>{{ \Carbon\Carbon::parse($trakr->check_in_date)->timezone(userTz())->format('d-m-Y H:i') }}</td>
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
        <!-- {{$list_data->links()}} -->
        {{$list_data->onEachSide(1)->links()}}
    </div>
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
            confirmButtonText: `Proceed`,
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
                            alert('Completed')
                            // $(thiS).closest('tr').fadeOut();
                        }
                    }
                })
            }
        })
    })
})
</script>
@endsection