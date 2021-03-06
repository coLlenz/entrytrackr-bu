@extends('layouts.app')

@section('content')
<div class="mb-2">
    <h1>Templates</h1>
    <div class="top-right-button-container">
        <button type="button" class="btn btn-primary btn-lg top-right-button  mr-1" data-toggle="dropdown" aria-haspopup="true"
    aria-expanded="false">ADD NEW</button> 
    <div class="dropdown-menu dropdown-menu-right mt-3">
        <a class="dropdown-item" href="{{route('notification-add')}}">Notification</a>
        <a class="dropdown-item" href="{{route('questionnaire-add')}}">Questionnaire</a>
    </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        @if(Session::has('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
        @endif
        <table class="table ">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Date Created</th>
                    <th>Date Last Updated</th>
                    @if(!auth()->user()->is_admin)
                    <th class="text-center">Status</th>
                    @endif
                    <th class="text-center" >Action</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($templates))
                    @foreach ($templates as $template )
                    <tr>
                        <td>{{$template->title}}</td>
                        <td>{{$template->template_type == 1 ? 'Notification' : 'Questionnaire' }}</td>
                        <td>{{ \Carbon\Carbon::parse($template->created_at)->format('d-m-Y H:i') }}</td>
                        <td>{{ \Carbon\Carbon::parse($template->updated_at)->format('d-m-Y H:i') }}</td>
                        <td class="text-center">
                            @if($template->status)
                                <span class="badge badge-primary mb-1">Active</span>
                            @else
                                <span class="badge badge-warning mb-1">Disabled</span>
                            @endif
                        </td>
                        <td class="text-center">
                        <button class="btn btn-primary dropdown-toggle mb-1" type="button"
                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            Actions
                        </button>
                        @if($template->template_type == 1)
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            @if($template->status)
                                <a class="dropdown-item" href="{{route("deactivate",$template->id)}}">Deactivate</a>
                                @else
                                <a class="dropdown-item" href="{{route("activate",$template->id)}}">Activate</a>
                            @endif
                            <a class="dropdown-item" href="{{route("notification-edit",$template->id)}}">Edit</a>
                            <a class="dropdown-item" href="{{route("template-delete",$template->id)}}">Delete</a>
                        </div>
                        @else
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            @if($template->status)
                                <a class="dropdown-item" href="{{route("deactivate",$template->id)}}">Deactivate</a>
                                @else
                                <a class="dropdown-item" href="{{route("change_status",$template->id)}}">Activate</a>
                            @endif
                            <a class="dropdown-item" href="{{route("copy-template",$template->id)}}">Copy</a>
                            <a class="dropdown-item" href="{{route("question-edit",$template->id)}}">Edit</a>
                            <a class="dropdown-item" href="{{route("template-delete",$template->id)}}">Delete</a>
                        </div>
                        @endif
                    </td>
                </tr>
                @endforeach
            @endif
            </tbody>
        </table>
        <p class="text-center">{{ (empty($templates) ? 'No records found.' : '') }}</p>
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