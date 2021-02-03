@extends('admin.layouts.admin')

@section('content')

<div class="mb-2">
    <h1>Upload Image</h1>
</div>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mx-auto">
            @if (session('status'))
                <div class="text-success">
                    <p>{{ session('status') }}</p>
                </div>
            @endif

                <form action="{{route('uploadClientImage', $client_id)}}" method="post" enctype="multipart/form-data" class="" id="fileUpload">
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
                        <input type="file" name="profile" class="form-control" id="image">
                    </div>
                        <center>
                        <button class="btn btn-primary " type="submit">Upload</button>
                        </center>
                    </form>
            </div>
        </div>
    </div>
</div>
@endsection
