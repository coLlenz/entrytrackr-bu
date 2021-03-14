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
                
                <div class="card-body">
                    @if (Session::has('error'))
                       <div class="alert alert-danger">
                           <span>{{Session::get('error')}}</span>
                       </div>
                    @endif
                    <form action="{{route("trakr-store")}}" method="post" id="fadd">
                    @csrf
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" class="form-control" name="fname" value="{{old('fname')}}" required>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" class="form-control" name="lname" value="{{old('lname')}}" required>
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" class="form-control" name="number" value="{{old('number')}}" required>
                    </div>
                    <div class="form-group">
                        <label>Enter a trakrID</label>
                        <input type="text" class="form-control" name="trakrid" value="{{old('trakrid')}}" required>
                    </div>
                    <div class="form-group">
                        <label>Visitor Type</label>
                        <select class="form-control select2-single" data-width="100%" name="vtype" required>
                        <option value="1">Visitor</option>
                        <option value="2">Contractor</option>
                        <option value="3">Employee</option>
                        </select>
                    </div>
                    <div class="float-right">
                        <a href="{{ url()->previous() }}" type="submit" class="btn btn-primary">Cancel</a>
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