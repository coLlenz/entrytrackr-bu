@extends('layouts.app')

@section('content')
<div class="mb-2">
    <h1>Edit User Guid</h1>
    <div class="top-right-button-container">
        
    </div>
</div>
<div class="card">
    <div class="card-body">
        <form action="{{route("support-update",$support->id)}}" method="post" id="quill-notification-update">
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
                <label>Title</label>
            <input type="text" class="form-control" name="title" value="{{$support->title}}">
            </div>
            <div class="form-group">
                <label>Details</label>
                <div class="html-editor" id="quillEditor">
                    {!!$support->content!!}
                </div>
            </div>
            
        
            <center>
                <button type="submit" class="btn btn-primary">Update</button>
            </center>
        
</form>
</div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/vendor/quill.min.js')}}"></script>
<script>
        // $("#fadd").on("submit", function () {
        //     var hvalue = editor.getContents();
        //     $(this).append("<textarea name='content' style='display:none'>"+hvalue+"</textarea>");
        // });
</script>
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('css/vendor/quill.snow.css')}}" />
@endsection