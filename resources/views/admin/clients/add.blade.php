@extends('admin.layouts.admin')

@section('content')
<div class="row justify-content-md-center">
    <div class="col-md-6">
        <h1>Add User</h1>
    </div>
</div>
<div class="row justify-content-md-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <form action="{{route('admin-save-clients')}}" method="post">
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
                            <label class="form-control-label" for="name">Account Name</label>
                            <input name="name" type="text" class="form-control" id="name" placeholder="Enter Name" value={{ old('name') }}>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="example3cols1Input">Contact Name</label>
                        <input name="cname" type="text" class="form-control" id="example3cols1Input" placeholder="Enter Contact Name" value={{ old('cname') }}>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="email">Email</label>
                            <input name="email" type="email" class="form-control" id="email" placeholder="Enter Email" value={{ old('email') }}>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="pass">Password</label>
                            <input name="password" type="password" class="form-control" id="pass" placeholder="Set Password" >
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="pass1">Confirm Password</label>
                            <input name="password_confirmation" type="password" class="form-control" id="pass1" placeholder="Confirm Password" >
                        </div>
                        <center>
                        <button class="btn btn-primary float-right" type="submit">Save</button>
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