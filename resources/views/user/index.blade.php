@extends('layouts.app')

@section('content')
<div class="mb-2">
    <h1>User Accounts</h1>
    <div class="top-right-button-container">
        <button type="button" class="btn btn-outline-primary btn-lg top-right-button  mr-1"
    onclick="window.location.href='{{route("user-add")}}'">ADD NEW</button>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <table class="data-table data-table-feature">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Account Name</th>
                    <th>Contact Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $key=>$user)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->contactName}}</td>
                        <td>{{$user->email}}</td>
                        <td>
                            <button class="btn btn-primary dropdown-toggle mb-1" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        Actions
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="{{route("user-edit",$user->id)}}">Edit</a>
                                <a class="dropdown-item" href="{{route("user-delete",$user->id)}}">Delete</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                
                
            </div>

            </tbody>
        </table>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/vendor/datatables.min.js') }}"></script>
<script src="{{ asset('js/vendor/bootstrap-notify.min.js') }}"></script>
<script>
    @if(session()->has('success'))
    $.notify({ message: '{{ session()->get('success') }}' },{type: 'success',
        placement: {
            from: "bottom",
            align: "right"
          },
        });
    @endif
      $(document).ready(function() {
       $table = $(".data-table-feature").DataTable({
        sDom: '<"row view-filter"<"col-sm-12"<"float-right"l><"float-left"f><"clearfix">>>t<"row view-pager"<"col-sm-12"<"text-center"ip>>>',
        
        drawCallback: function () {
          $($(".dataTables_wrapper .pagination li:first-of-type"))
            .find("a")
            .addClass("prev");
          $($(".dataTables_wrapper .pagination li:last-of-type"))
            .find("a")
            .addClass("next");

          $(".dataTables_wrapper .pagination").addClass("pagination-sm");
        },
        language: {
          paginate: {
            previous: "<i class='simple-icon-arrow-left'></i>",
            next: "<i class='simple-icon-arrow-right'></i>"
          },
          search: "_INPUT_",
          searchPlaceholder: "Search...",
          lengthMenu: "Items Per Page _MENU_"
        },
      });
      
    });
</script>
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('css/vendor/dataTables.bootstrap4.min.css') }}" />
<link rel="stylesheet" href="{{ asset('css/vendor/datatables.responsive.bootstrap4.min.css') }}" />
@endsection