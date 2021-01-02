@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs " role="tablist">
            <li class="nav-item">
                <a class="nav-link  active" id="contactus-tab" data-toggle="tab" href="#contactus" role="tab" aria-controls="contactus" aria-selected="false">Contact Support</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="userguide-tab" data-toggle="tab" href="#userguide" role="tab" aria-controls="userguide" aria-selected="true">Help Center</a>
            </li>

        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content">
            <div class="tab-pane fade  show active" id="contactus" role="tabpanel" aria-labelledby="contactus-tab">
                @if(auth()->user()->is_admin)
                <table class="data-table data-table-feature">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Business Name</th>
                            <th>Name</th>
                            <th>Email</th>
                            {{-- <th>Phone</th> --}}
                            <th>Message</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contacts as $key=>$user)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->message}}</td>
                        </tr>
                        @endforeach


            </div>

            </tbody>
            </table>
            @else
            <div class="row">
                <div class="col-md-12 mx-auto">
                    <form action="{{route('contact-store')}}" method="post">
                        @csrf
                        @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <div class="form-group">
                            <label class="form-control-label" for="name">Name</label>
                            <input name="name" type="text" class="form-control" id="name" placeholder="Enter Name" required>
                        </div>

                        <div class="form-group">
                            <label class="form-control-label" id="message">Message</label>
                            <textarea name="message" cols="30" class="form-control" rows="10"></textarea>
                        </div>
                        <button class="btn btn-primary btn-lg float-right" type="submit">Save</button>
                    </form>
                </div>
            </div>
            @endif


        </div>
        <div class="tab-pane fade" id="userguide" role="tabpanel" aria-labelledby="userguide-tab">
            <div class="row">
                <div class="col-12" id="accordion">
                    @if(auth()->user()->is_admin)
                    <form class="mb-2" action="{{route("support-store")}}" method="post" id="quill-notification">
                        @csrf

                        @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" name="title">
                        </div>
                        <div class="form-group">
                            <label>Details</label>
                            <div class="html-editor" id="quillEditor"></div>
                        </div>


                        <center>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </center>

                    </form>
                    @endif
                    @foreach ($supports as $support)
                    <div class="card mb-3">
                        <div class="d-flex flex-grow-1 min-width-zero" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <div class="card-body btn btn-empty list-item-heading text-left text-one">
                                {{$support->title}}
                            </div>
                        </div>
                        <div id="collapseOne" class="collapse" data-parent="#accordion">
                            <div class="card-body accordion-content">
                                {!! $support->content !!}
                            </div>
                        </div>
                    </div>
                    @if(auth()->user()->is_admin)
                    <button type="button" class="btn btn-primary" onclick="window.location.href='{{route("support-edit",$support->id)}}'">
                        Edit
                    </button>
                    @endif
                    @endforeach
                </div>
            </div>


        </div>

    </div>
</div>
</div>
@endsection

@section("script")
<script src="{{ asset('js/vendor/bootstrap-notify.min.js') }}"></script>
<script>
    @if(Session::has('success'))
    $.notify({
        message: '{{ session()->get('
        success ') }}'
    }, {
        type: 'success',
        placement: {
            from: "bottom",
            align: "right"
        },
    });
    @endif
</script>
@if(auth()->user()->is_admin)
<script src="{{ asset('js/vendor/quill.min.js')}}"></script>
<script src="{{ asset('js/vendor/datatables.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $table = $(".data-table-feature").DataTable({
            sDom: '<"row view-filter"<"col-sm-12"<"float-right"l><"float-left"f><"clearfix">>>t<"row view-pager"<"col-sm-12"<"text-center"ip>>>',

            drawCallback: function() {
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
@endif
@endsection
@if(auth()->user()->is_admin)
@section('style')
<link rel="stylesheet" href="{{ asset('css/vendor/quill.snow.css')}}" />
@endsection
@endif