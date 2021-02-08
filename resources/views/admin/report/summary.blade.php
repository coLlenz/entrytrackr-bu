@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="">
                        <form class="" action="{{ route('byVisitor') }}" method="GET" id="by_visitor">
                            @csrf
                            <label for="type_of_visitor">Visitor Type</label> <br>
                            <select class="mb-2 custom_entr_select" name="type_of_visitor" id="type_of_visitor">
                                <option value="all">All</option>
                                <option value="1" {{$formdata == '1' ? 'selected' : ""}}>Visitor</option>
                                <option value="2" {{$formdata == '2' ? 'selected' : ""}}>Contractor</option>
                                <option value="3" {{$formdata == '3' ? 'selected' : ""}} >Employee</option>
                            </select>
                        </form>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center">Visitor Name</th>
                                <th class="text-center">Time and Date of Entry</th>
                                <th class="text-center">Temperature</th>
                                <th class="text-center">Questionnaire Title</th>
                                <th class="text-center">Access</th>
                                <th class="text-center">Result</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lists as $list)
                                <tr>
                                    <td class="text-center">{{$list->visitor_name}}</td>
                                    <td class="text-center">{{ \Carbon\Carbon::parse($list->created_at)->timezone(userTz())->format('d-m-Y H:i')}}</td>
                                    <td class="text-center">{{$list->temperature}}</td>
                                    <td class="text-center">{{$list->question_title}}</td>
                                    <td class="text-center">
                                        @if($list->status == 0)
                                            <span class="badge  badge-success">{{ 'Allowed' }}</span>
                                        @else
                                            <span class="badge badge-danger">Denied</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{route('viewResults' ,[ $list->question_id , $list->id] )}}" > View </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <h3 class="text-center"> <i> {{ $lists->isEmpty() ? 'No Results' : ''}} </i> </h3>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/vendor/jquery-3.3.1.min.js')}}"></script>
<script src="{{ asset('js/vendor/sweetalert2@10.js')}}"></script>
<script type="text/javascript">
    $('#type_of_visitor').on('change' , function(e) {
        $('#by_visitor').submit();
    });
</script>
@endsection
