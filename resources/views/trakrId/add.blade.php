@extends('layouts.app')

@section('content')
<div class="mb-2">
    <h1>Add TrakrID</h1>
    <div class="top-right-button-container">
        
    </div>
</div>
<div class="card">
    <div class="card-body">
        <form action="{{route("trakr-store")}}" method="post" id="fadd">
            @csrf
            <div class="form-group">
                <label>First Name</label>
                <input type="text" class="form-control" name="fname">
            </div>
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" class="form-control" name="lname">
            </div>
            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" class="form-control" name="number"">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" name="email">
            </div>
            <div class="form-group">
                <label>Visitor Type</label>
                <select class="form-control select2-single" data-width="100%" name="vtype">
                    <option label="&nbsp;">&nbsp;</option>
                    <option value="1">Visitor</option>
                    <option value="2">Contractor</option>
                    <option value="3">Employee</option>
                </select>
            </div>
        
            <center>
                <button type="submit" class="btn btn-primary">Add</button>
            </center>
        
</form>
</div>
</div>
@endsection

@section('script')
@endsection

@section('style')
@endsection