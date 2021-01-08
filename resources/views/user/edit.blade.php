@extends('layouts.app')

@section('content')
<div class="mb-2">
    <h1>Update User Account</h1>
</div>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <form action="{{route('user-update',$id->id)}}" method="post">
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
                            <label class="form-control-label" for="example3cols1Input">Account Name</label>
                        <input name="name" type="text" class="form-control" id="example3cols1Input" placeholder="Enter Business Name" required value="{{$id->name}}">
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="example3cols1Input">Contact Name</label>
                        <input name="cname" type="text" class="form-control" id="example3cols1Input" placeholder="Enter Contact Name" required value="{{$id->contactName}}">
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="example3cols1Input">Email</label>
                            <input name="email" type="email" class="form-control" id="example3cols1Input" placeholder="Enter Email" required value="{{$id->email}}">
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="example3cols1Input">Password</label>
                            <input name="password" type="password" class="form-control" id="example3cols1Input" placeholder="Set Password" >
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="example3cols1Input">Confirm Password</label>
                            <input name="confirmpassword" type="password" class="form-control" id="example3cols1Input" placeholder="Confirm Password">
                        </div>
                        <center>
                        <button class="btn btn-primary" type="submit">Update</button>
                        </center>
                    </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

@endsection

@section('style')
@endsection