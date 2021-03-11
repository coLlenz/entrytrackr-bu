
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
                            <input type="radio" name="ass" {{ ($formdata['ass'] == '0') ? 'checked' : '' }} value="0">
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
                            <input type="radio" name="tvis" value="1" {{ ($formdata['tvis'] == '1') ? 'checked' : '' }}>
                            <span class="vs-radio">
                                <span class="vs-radio--border"></span>
                                <span class="vs-radio--circle"></span>
                            </span>
                            <span style="font-size:13px">Visitor</span>
                        </div>
                        <div class="vs-radio-con vs-radio-primary mb-1">
                            <input type="radio" name="tvis" value="2" {{ ($formdata['tvis'] == '2') ? 'checked' : '' }}>
                            <span class="vs-radio">
                                <span class="vs-radio--border"></span>
                                <span class="vs-radio--circle"></span>
                            </span>
                            <span style="font-size:13px" >Contractor</span>
                        </div>
                        <div class="vs-radio-con vs-radio-primary mb-3">
                            <input type="radio" name="tvis" value="3" {{ ($formdata['tvis'] == '3') ? 'checked' : '' }}>
                            <span class="vs-radio">
                                <span class="vs-radio--border"></span>
                                <span class="vs-radio--circle"></span>
                            </span>
                            <span style="font-size:13px" >Employee</span>
                        </div>
                        <h6 class="card-title font-bold mb-2">Access</h6>
                        <div class="vs-radio-con vs-radio-primary mb-1">
                            <input type="radio" name="acc" value="all" {{ ($formdata['acc'] == 'all') ? 'checked' : '' }} >
                            <span class="vs-radio">
                                <span class="vs-radio--border"></span>
                                <span class="vs-radio--circle"></span>
                            </span>
                            <span style="font-size:13px">All</span>
                        </div>
                        <div class="vs-radio-con vs-radio-primary mb-1">
                            <input type="radio" name="acc" value="0" {{ ($formdata['acc'] == '0') ? 'checked' : '' }}>
                            <span class="vs-radio">
                                <span class="vs-radio--border"></span>
                                <span class="vs-radio--circle"></span>
                            </span>
                            <span style="font-size:13px">Allowed</span>
                        </div>
                        <div class="vs-radio-con vs-radio-primary mb-3">
                            <input type="radio" name="acc" value="1" {{ ($formdata['acc'] == '1') ? 'checked' : '' }}>
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
                            <h4>Visitor Log</h4>
                            <p>Visitor entry and exit records for the past 7 days are shown below.<br/>
                            Use the filter options to change the date range and adjust the information that is displayed.</p>
                        </div>
                        <div class="table-responsive">
                            <table class="table zero-configuration" id="zero-configuration">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th class="text-center">Telephone number</th>
                                        <th class="text-center">Time and date of entry</th>
                                        <th class="text-center">Time and date of exit</th>
                                        <th class="text-center">Assistance</th>
                                        <th class="text-center">Access</th>
                                        <th class="text-center">Visiting/Business</th>
                                        <th class="text-center">Area(s) Accessed</th>
                                        <th class="text-center">Comments</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($table_data))
                                        @foreach($table_data as $list)
                                            <tr>
                                                <td>{{$list->firstName}} {{$list->lastName}}</td>
                                                <td class="text-center">{{$list->phoneNumber}}</td>
                                                <td class="text-center">{{ \Carbon\Carbon::parse($list->check_in_date)->timezone(userTz())->format('d-m-Y H:i') }}</td>
                                                <td class="text-center">{{$list->check_out_date ? \Carbon\Carbon::parse($list->check_out_date)->timezone(userTz())->format('d-m-Y H:i') : 'Pending'}}</td>
                                                <td class="text-center">
                                                    @if($list->assistance == 0)
                                                        <span class="badge badge-pill badge-primary">{{'No'}}</span>
                                                    @else
                                                        <span class="badge badge-pill badge-warning">{{'Yes'}}</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if($list->status == 0)
                                                        <span class="badge  badge-success">{{ 'Allowed' }}</span>
                                                    @else
                                                        <span class="badge badge-danger">Denied</span>
                                                    @endif
                                                </td>
                                                <td class="text-center"> {{ $list->trakr_type_id == 1 ? $list->who : $list->name_of_company }}</td>
                                                <td class="text-center"> {{ $list->area_access }} </td>
                                                <td class="text-center">
                                                <input type="hidden" class="comment" value="{{ isset($list->comment) && !empty($list->comment) ? $list->comment : '' }}">
                                                <i class="fa fa-commenting-o fa-2x add_comment" aria-hidden="true" title="Add comments here" data-id="{{ $list->log_id }}"></i> 
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
                                    <a href="{{ route('list-report', $_GET ) }}" class="btn btn-primary btn-md mr-2" title="Generate PDF file">Download PDF</a>
                                    <a href="{{ route('export_csv' , $_GET ) }}" class="btn btn-primary btn-md" title="Generate CSV file">Export CSV</a>
                                @endif
                            </div>
                            <div class="col-md-4">
                                {{$table_data->appends($_GET)->onEachSide(1)->links()}}
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
<script src="{{ asset('js/vendor/sweetalert2@10.js') }}" charset="utf-8"></script>
<script>
    $(document).ready(function() {
        $('.add_comment').on('click' , function() {
            var data_id = $(this).attr('data-id');
            var default_comment = $(this).prev('input').val();
            add_comment(data_id , default_comment , $(this) );
        });
        
        function add_comment( log_id  , default_comment , element){
            Swal.fire({
                customClass: {
                confirmButton: 'et_btn et_btn_clored',
                cancelButton: 'et_btn et_btn_secondary mr-2'
                },
                inputValue: default_comment,
                reverseButtons: true,
                buttonsStyling: false,
                title:'Add Comment',
                input: 'textarea',
                showCloseButton: false,
                showCancelButton:true,
                allowOutsideClick: false,
                cancelButtonText:'Close',
                confirmButtonText:'Save',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Input is required'
                    }
                },
            }).then(complete => {
                if (complete.isConfirmed) {
                    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
                    $.ajax({
                        url: "{{route('add_comment')}}",
                        type: 'POST',
                        data : {id:log_id , comment:complete.value},
                        success:function(response){
                            success(response);
                            
                            if (response.status == 'success') {
                                element.prev('input').val(complete.value)
                            }
                            
                        }
                    })
                }
            }) 
        }

        function success(response){
            Swal.fire({
                position: 'top-end',
                icon: response.icon,
                title: response.msg,
                showConfirmButton: false,
                timer: 5000
            })
        }
    })
</script>
@endsection