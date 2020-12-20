@extends('layouts.app')

@section('content')
<div class="mb-2">
    <h1>Add Notification/Alert Template</h1>
    <div class="top-right-button-container">
        
    </div>
</div>
<div class="card">
    <div class="card-body">
        <form action="{{route("template-store")}}" method="post" id="quill-notification">
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
                <label>Name</label>
                <input type="text" class="form-control" name="name">
            </div>
            <div class="form-group">
                <label>Notification / Alert</label>
                <div class="html-editor" id="quillEditor"></div>
            </div>
            
        
            <center>
                <button type="submit" class="btn btn-primary">Add</button>
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