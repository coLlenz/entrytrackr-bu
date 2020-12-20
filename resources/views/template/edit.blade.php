@extends('layouts.app')

@section('content')
<div class="mb-2">
    <h1>Edit TrakrID</h1>
    <div class="top-right-button-container">
        
    </div>
</div>
<div class="card">
    <div class="card-body">
        <form action="{{route("trakr-update",$trakr->id)}}" method="post" id="fedit">
            @csrf
            <div class="form-group">
                <label>First Name</label>
                <input type="text" class="form-control" name="fname" value="{{$trakr->firstName}}">
            </div>
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" class="form-control" name="lname" value="{{$trakr->lastName}}">
            </div>
            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" class="form-control" name="number" value="{{$trakr->phoneNumber}}">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" name="email" value="{{$trakr->email}}">
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
        
            <center>
                <button type="submit" class="btn btn-primary">Update</button>
            </center>
        
</form>
</div>
</div>
@endsection

@section('script')
@endsection

@section('style')
@endsection