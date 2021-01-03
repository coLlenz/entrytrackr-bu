@extends('layouts.app')

@section('content')
<div class="mb-2">
    <h1>Add User</h1>
</div>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mx-auto">
            <form action="{{route('user-store')}}" method="post">
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
                        <input name="name" type="text" class="form-control" id="name" placeholder="Enter Name" required>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="example3cols1Input">Contact Name</label>
                    <input name="cname" type="text" class="form-control" id="example3cols1Input" placeholder="Enter Contact Name" required>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="email">Email</label>
                        <input name="email" type="email" class="form-control" id="email" placeholder="Enter Email" required>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="pass">Password</label>
                        <input name="password" type="password" class="form-control" id="pass" placeholder="Set Password" required>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="pass1">Confirm Password</label>
                        <input name="confirmpassword" type="password" class="form-control" id="pass1" placeholder="Confirm Password" required>
                    </div>
                    <center>
                    <button class="btn btn-primary" type="submit">Save</button>
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