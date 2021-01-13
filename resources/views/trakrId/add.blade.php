@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-md-center">
        <div class="col-md-6">
            <div class="mb-2">
                <h1>Add trakrID</h1>
                <div class="top-right-button-container">
            
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-md-center">
        <div class="col-md-6">
            <div class="card">
                 @if (session('success'))
                    <div class="alert alert-success">
                        <span>{{session('success')}}</span>
                    </div>
                 @endif
               
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
                        <input type="text" class="form-control" name="number">
                    </div>
                    <div class="form-group">
                        <label>Enter a trakrID</label>
                        <input type="text" class="form-control" name="trakrid">
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
                    <div class="float-right">
                        <button type="submit" class="btn btn-primary">Add</button>
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