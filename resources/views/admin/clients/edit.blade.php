@extends('admin.layouts.admin')

@section('content')
<div class="row justify-content-md-center">
    <div class="col-md-6">
        <h1>Update User Account</h1>
    </div>
</div>
<div class="row justify-content-md-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <form action="{{route('admin-update-client',$id->id)}}" method="post">
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
                            <label class="form-control-label" for="example3cols1Input">Timezone</label>
                            <select class="form-control" name="timezone" id="timezone">
                                <option value="Australia/Adelaide">Australia/Adelaide</option>
                                <option value="Australia/Brisbane">Australia/Brisbane</option>
                                <option value="Australia/Broken_Hill">Australia/Broken_Hill</option>
                                <option value="Australia/Currie">Australia/Currie</option>
                                <option value="Australia/Darwin">Australia/Darwin</option>
                                <option value="Australia/Eucla">Australia/Eucla</option>
                                <option value="Australia/Hobart">Australia/Hobart</option>
                                <option value="Australia/Lindeman">Australia/Lindeman</option>
                                <option value="Australia/Lord_Howe">Australia/Lord_Howe</option>
                                <option value="Australia/Melbourne">Australia/Melbourne</option>
                                <option value="Australia/Perth">Australia/Perth</option>
                                <option value="Australia/Sydney">Australia/Sydney</option>
                            </select>
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
                        <button class="btn btn-primary float-right" type="submit">Update</button>
                        </center>
                    </form>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/vendor/jquery-3.3.1.min.js')}}"></script>
<script type="text/javascript">
    var timezone = "{!! $id->timezone !!}";
    $('#timezone').val(timezone);
</script>
@endsection