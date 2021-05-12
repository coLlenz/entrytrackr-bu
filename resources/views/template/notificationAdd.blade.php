@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/vendor/quill.snow.css') }}" />
<div class="container">
    <div class="row justify-content-md-center">
        <div class="col-md-8">
            <div class="float-right">
                @if(count($templates) > 0)
                    <div class="float-right">
                        <button class="btn btn-primary dropdown-toggle mb-1" type="button"
                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            Templates
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            @foreach($templates as $template)
                                <a class="dropdown-item template_option" href="#" template_data="{{$template->content_json}}">{{$template->title}}</a>
                            @endforeach
                        </div>
                    </div>
                @endif
                <a href="{{ url('/templates') }}" class="btn btn-primary mr-2">Back to Templates</a>
            </div>
        </div>
    </div> <br>
    <div class="row justify-content-md-center">
        <div class="col-md-8">
            <div class="card">
            <div class="card-body">
                <form action="{{route('template-store')}}" method="POST" id="formEditor">
                    @csrf
                    <div class="form-group">
                        <label for="template_name"> 
                            <h4>Notification Title</h4>
                        </label>
                        <input type="text" name="template_name" class="form-control" required>
                        <div class="invalid-feedback">
                            <h3>Title for this template is required.</h3>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="html-editor" id="editor" style="height: 400px;"></div>
                        <input type="hidden" name="editor_content" id="editor_content">
                    </div>
                    <button type="submit" class="btn btn-primary float-right" name="button">Save</button>
                </form>
            </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{ asset('js/vendor/jquery-3.3.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/vendor/quill.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/quill_modules/image-drop.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/quill_modules/image-resize.min.js') }}"></script>
<script src="{{ asset('js/vendor/sweetalert2@10.js')}}"></script>
<script type="text/javascript">

var toolbarOptions = [
                ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
                ['blockquote',],

                // [{ 'header': 1 }, { 'header': 2 }],               // custom button values
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                // [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
                [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
                // [{ 'direction': 'rtl' }],                         // text direction
                [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
                // [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                ['image' ],          // add's image support
                // [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
                // [{ 'font': [] }],
                [{ 'align': [] }],
                // ['clean']                                         // remove formatting button
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
    
    $('#formEditor').on('submit' , function(e){
        // editor.getContents() //json data
        // editor.root.innerHTML //
        e.preventDefault();
        var formdata = new FormData();
        formdata.append('_token' , $('input[name=_token]').val());
        formdata.append('title' , $('input[name=template_name]').val());
        // formdata.append('htmldata' , editor.root.innerHTML);
        formdata.append('jsondata' , JSON.stringify(editor.getContents()));
        
        $.ajax({
            url:"{{route('template-store')}}",
            type: 'POST',
            processData: false,
            contentType: false,
            data : formdata,
            success: function(response){
                if (response.status == 'success') {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Changes have been saved.',
                        showConfirmButton: false,
                        timer: 2000
                    })
                    setTimeout(function () {
                        window.location.href = '/templates/notification-edit/'+response.template_id;
                    }, 1500);
                }
            }
        })
    });
    
    $('.template_option').on('click' , function() {
        var template_data = JSON.parse( $(this).attr('template_data') );
        editor.setContents(template_data);
    })
    
</script>

@endsection