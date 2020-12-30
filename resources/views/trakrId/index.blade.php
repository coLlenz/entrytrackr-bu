@extends('layouts.app')

@section('content')
<div class="mb-2">
    <h1>trakrID</h1>
    @if(!auth()->user()->is_admin)
        <div class="top-right-button-container">
            <button type="button" class="btn btn-primary btn-lg top-right-button  mr-1"
        onclick="window.location.href='{{route("trakr-view",auth()->user()->uuid)}}'">Check In Page</button>
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
@endsection

@section('script')
<script src="{{ asset('js/vendor/datatables.min.js') }}"></script>
<script>
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