
@extends('layouts.app')

@section('content')
<style media="screen">

</style>
<section id="basic-datatable">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <form class="" action="{{route('report-filter')}}" method="GET">
                    <div class="card-body">
                        <h6 class="card-title font-bold mb-2">From</h6>
                        <div class="mb-2">
                            <input type="date" class="form-control" name="fdate" value="{{$formdata['fdate']}}">
                        </div>
                        <h6 class="card-title font-bold mb-2">To</h6>
                        <div class="mb-2">
                            <input type="date" class="form-control" name="edate" value="{{$formdata['edate']}}">
                        </div>
                        
                        <h6 class="card-title font-bold mb-2">Assistance requested</h6>
                        <div class="vs-radio-con vs-radio-primary mb-1">
                            <input type="radio" name="ass" {{ ($formdata['ass'] == 'all') ? 'checked' : '' }} value="all" >
                            <span class="vs-radio">
                                <span class="vs-radio--border"></span>
                                <span class="vs-radio--circle"></span>
                            </span>
                            <span style="font-size:13px">All</span>
                        </div>
                        <div class="vs-radio-con vs-radio-primary mb-1">
                            <input type="radio" name="ass" {{ ($formdata['ass'] == 1) ? 'checked' : '' }} value="1" >
                            <span class="vs-radio">
                                <span class="vs-radio--border"></span>
                                <span class="vs-radio--circle"></span>
                            </span>
                            <span style="font-size:13px">Yes</span>
                        </div>
                        
                        <div class="vs-radio-con vs-radio-primary mb-3">
                            <input type="radio" name="ass" {{ ($formdata['ass'] == 0) ? 'checked' : '' }} value="0">
                            <span class="vs-radio">
                                <span class="vs-radio--border"></span>
                                <span class="vs-radio--circle"></span>
                            </span>
                            <span style="font-size:13px" >No</span>
                        </div>
                        
                        <h6 class="card-title font-bold mb-2">Type of visitor</h6>
                        <div class="vs-radio-con vs-radio-primary mb-1">
                            <input type="radio" name="tvis" value="all" {{ ($formdata['tvis'] == 'all') ? 'checked' : '' }} >
                            <span class="vs-radio">
                                <span class="vs-radio--border"></span>
                                <span class="vs-radio--circle"></span>
                            </span>
                            <span style="font-size:13px">All</span>
                        </div>
                        <div class="vs-radio-con vs-radio-primary mb-1">
                            <input type="radio" name="tvis" value="1" {{ ($formdata['tvis'] == 1) ? 'checked' : '' }}>
                            <span class="vs-radio">
                                <span class="vs-radio--border"></span>
                                <span class="vs-radio--circle"></span>
                            </span>
                            <span style="font-size:13px">Visitor</span>
                        </div>
                        <div class="vs-radio-con vs-radio-primary mb-1">
                            <input type="radio" name="tvis" value="3" {{ ($formdata['tvis'] == 3) ? 'checked' : '' }}>
                            <span class="vs-radio">
                                <span class="vs-radio--border"></span>
                                <span class="vs-radio--circle"></span>
                            </span>
                            <span style="font-size:13px" >Contractor</span>
                        </div>
                        <div class="vs-radio-con vs-radio-primary mb-3">
                            <input type="radio" name="tvis" value="2" {{ ($formdata['tvis'] == 2) ? 'checked' : '' }}>
                            <span class="vs-radio">
                                <span class="vs-radio--border"></span>
                                <span class="vs-radio--circle"></span>
                            </span>
                            <span style="font-size:13px" >Staff</span>
                        </div>
                        <h6 class="card-title font-bold mb-2">Access</h6>
                        <div class="vs-radio-con vs-radio-primary mb-1">
                            <input type="radio" name="acc" checked="" value="all" {{ ($formdata['acc'] == 'all') ? 'checked' : '' }} >
                            <span class="vs-radio">
                                <span class="vs-radio--border"></span>
                                <span class="vs-radio--circle"></span>
                            </span>
                            <span style="font-size:13px">All</span>
                        </div>
                        <div class="vs-radio-con vs-radio-primary mb-1">
                            <input type="radio" name="acc" value="1" {{ ($formdata['acc'] == 1) ? 'checked' : '' }}>
                            <span class="vs-radio">
                                <span class="vs-radio--border"></span>
                                <span class="vs-radio--circle"></span>
                            </span>
                            <span style="font-size:13px">Allowed</span>
                        </div>
                        <div class="vs-radio-con vs-radio-primary mb-3">
                            <input type="radio" name="acc" value="2" {{ ($formdata['acc'] == 2) ? 'checked' : '' }}>
                            <span class="vs-radio">
                                <span class="vs-radio--border"></span>
                                <span class="vs-radio--circle"></span>
                            </span>
                            <span style="font-size:13px" >Denied</span>
                        </div>
                        <button id="filter" type="submit" class="btn btn-primary btn-block">Filter</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                {{-- <div class="card-header">
                    <h4 class="card-title">Users</h4>
                </div> --}}
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="card-header">
                            <h4>Filter Results</h4>
                        </div>
                        <div class="table-responsive">
                            <table class="table zero-configuration" id="zero-configuration">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Telephone number</th>
                                        <th>Time and date of entry</th>
                                        <th>Time and date of exit</th>
                                        <th class="text-center">Assistance</th>
                                        <th class="text-center">Access</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($table_data))
                                        @foreach($table_data as $list)
                                            <tr>
                                                <td>{{$list->firstName}} {{$list->lastName}}</td>
                                                <td>{{$list->phoneNumber}}</td>
                                                <td>{{$list->check_in_date}}</td>
                                                <td>{{$list->check_out_date}}</td>
                                                <td class="text-center">
                                                    @if($list->assistance == 1)
                                                        <span class="badge badge-pill badge-primary">{{'Yes'}}</span>
                                                    @else
                                                        <span class="badge badge-pill badge-warning">{{'No'}}</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if($list->status == 0)
                                                        <span class="badge badge-pill badge-primary">Accepted</span>
                                                    @else
                                                        <span class="badge badge-pill badge-warning">Denied</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                    @endif
                                </tbody>
                            </table>
                            @if(empty($table_data))
                            <div class="no_records" style="text-align:center;">
                                {{"No Results"}}
                            </div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                @if($table_data->count() >0)
                                    <a href="{{ route('list-report', $_GET ) }}" class="btn btn-primary btn-md">Download PDF</a>
                                @endif
                            </div>
                            <div class="col-md-4">
                                {{$table_data->appends($_GET)->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('css/vendor/dataTables.bootstrap4.min.css') }}" />
<link rel="stylesheet" href="{{ asset('css/vendor/datatables.responsive.bootstrap4.min.css') }}" />
@endsection

@section('script')
<script src="{{ asset('js/vendor/datatables.min.js') }}"></script>
@endsection