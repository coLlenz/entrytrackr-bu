@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/vendor/quill.snow.css') }}" />
<div class="mb-2">
    <h1>Add Notification/Alert Template</h1>
    <div class="top-right-button-container"></div>
</div>
<div class="card">
    <div class="card-body">
    <form action="{{route('template-store')}}" method="post" id="formEditor">
        @csrf
        <div class="html-editor" id="editor"></div>
        <input type="hidden" name="editor_content" id="editor_content">
    </form>
</div>
</div>
<script type="text/javascript" src="{{ asset('js/vendor/jquery-3.3.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/vendor/quill.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/quill_modules/image-drop.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/quill_modules/image-resize.min.js') }}"></script>
<script type="text/javascript">
var toolbarOptions = [
                ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
                ['blockquote', 'code-block'],

                [{ 'header': 1 }, { 'header': 2 }],               // custom button values
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
                [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
                [{ 'direction': 'rtl' }],                         // text direction

                [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                [ 'link', 'image', 'video' ],          // add's image support
                [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
                [{ 'font': [] }],
                [{ 'align': [] }],

                ['clean']                                         // remove formatting button
            ];
    var container = document.getElementById('editor');
    var editor = new Quill( container ,{
        theme : 'snow',
        modules : {
            toolbar : toolbarOptions,
            imageDrop: true,
            imageResize: true
        },
    });
    editor.setContents()
    $('#formEditor').on('submit' , function(e){
        e.preventDefault();
        var quildata = JSON.stringify(editor.getContents());
        var editor_data = $('#editor_content').val(JSON.stringify(editor.getContents()));
        console.log(editor_data.val());
    })
    
    // var form = document.getElementById("formEditor"); // get form by ID
    //     form.onsubmit = function(e) { // onsubmit do this first
    //     e.preventDefault();
    //     var name = document.querySelector('input[name=asd]'); // set name input var
    //     name.value = JSON.stringify(editor.getContents()); // populate name input with quill data
    //     console.log(editor.getContents());
    //     return true; // submit form
    // }
</script>

@endsection