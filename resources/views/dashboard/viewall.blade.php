@extends('layouts.app')
@section('content')

<div class="row justify-content-md-center">
    <div class="col-lg-8 col-md-6">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title"> Visitors Currently Signed In 
                    <div class="float-right">
                        <form action="{{route('showAllSearch')}}" method="GET" style="display: flex">
                            <input type="text" name="search" value="{{isset($_GET['search']) ? $_GET['search'] : ''}}" class="form-control">
                            <button type="submit" name="button" class="btn btn-primary entry_md_btn ml-2"> Search </button>
                        </form>
                    </div>
                </h3>
                <table class="table">
                    <tbody>
                        @foreach($trakrs as $trakr)
                            <tr>
                                <td>{{$trakr->firstName}} {{$trakr->lastName}}</td>
                                <td>{{$trakr->type}}</td>
                                <td class="color-theme-1">{{\Carbon\Carbon::parse($trakr->created_at)->timezone(userTz())->diffForHumans()}}</td>
                                <td> <button type="button" name="dashBoardSignOut" class="btn btn-primary entry_sm_btn" visitor-id="{{$trakr->id}}">Sign Out</button> </td>
                            </tr>
                            @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/vendor/jquery-3.3.1.min.js')}}"></script>
<script src="{{ asset('js/vendor/sweetalert2@10.js') }}" charset="utf-8"></script>
<script type="text/javascript">
    $('.entry_sm_btn').on('click' , function() {
        var id = $(this).attr('visitor-id');
        var target = $(this).closest('tr');
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
                    data : {data_id : id},
                    success: function(response){
                        if (response.status) {
                            target.remove();
                            $('#visit_count').text(Number($('#visit_count').text()) - 1);
                        }
                    }
                })
            }
        })
    })
</script>
@endsection