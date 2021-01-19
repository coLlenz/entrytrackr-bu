@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-md-center">
        <div class="col-md-6">
            <div class="mb-2">
                <h1>Edit trakrID</h1>
                <div class="top-right-button-container">
                    
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-md-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                <form action="{{route("trakr-update",$trakr->id)}}" method="post" id="fedit">
                    @csrf
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" class="form-control" name="fname" value="{{$trakr->firstName}}" required>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" class="form-control" name="lname" value="{{$trakr->lastName}}" required>
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" class="form-control" name="number" value="{{$trakr->phoneNumber}}" required>
                    </div>
                    <div class="form-group">
                        <label>Enter a trakrID</label>
                        <input type="text" class="form-control" name="trakrid" value="{{$trakr->trakr_id}}" required>
                    </div>
                    <div class="form-group">
                        <label>Visitor Type</label>
                        <select class="form-control select2-single" data-width="100%" name="vtype" >
                        <option label="&nbsp;">&nbsp;</option>
                        <option value="1" {{$trakr->trakr_type_id == 1 ? "selected" : ""}}>Visitor</option>
                        <option value="2" {{$trakr->trakr_type_id == 2 ? "selected" : ""}}>Contractor</option>
                        <option value="3" {{$trakr->trakr_type_id == 3 ? "selected" : ""}}>Employee</option>
                    </select>
                    </div>
                    <div class="float-right">
                    <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
@endsection

@section('style')
@endsection