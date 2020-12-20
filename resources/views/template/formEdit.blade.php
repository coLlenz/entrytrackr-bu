@extends('layouts.app')

@section('content')
<div class="mb-2">
    <h1>Add Form Template</h1>
    <div class="top-right-button-container">
        
    </div>
</div>
<div class="card">
    <div class="card-body">
        <form action="{{route("form-update",$template->id)}}" method="post" id="fb-form">
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
                <input type="text" class="form-control" name="name1" value="{{$template->name}}">
            </div>
            <div class="form-group">
                <label>Form</label>
                <div id="fb-editor"></div>
            </div>
            
        
            <center>
                <button type="submit" class="btn btn-primary">Update</button>
            </center>
        
</form>
</div>
</div>
@endsection

@section('script')
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script> --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script src="{{ asset('js/vendor/form-builder.min.js')}}"></script>
<script>
    options = {
        disabledAttrs: ["access","name","class","value"],
      disabledActionButtons: ['data','save','clear'],
      disableFields: ['file','button','hidden','checkbox-group'],
      typeUserAttrs: {
        text: {
          access: {
            label: "Allow access if equal to",
            value: "",
            placeholder: 'Allow Access if value is ... '
          }               
        },
        select: {
          access: {
            label: "Allow access if equal to",
            value: "",
            placeholder: 'Allow Access if value is ... '
          }               
        },
        'radio-group': {
          access: {
            label: "Allow access if equal to",
            value: "",
            placeholder: 'Allow Access if value is ... '
          }               
        },'checkbox-group': {
          access: {
            label: "Allow access if equal to",
            value: "",
            placeholder: 'Allow Access if value is ... '
          }               
        },
        number: {
          access: {
            label: "Allow access if equal to",
            value: "",
            placeholder: 'Allow Access if value is ... '
          }               
        },autocomplete: {
          access: {
            label: "Allow access if equal to",
            value: "",
            placeholder: 'Allow Access if value is ... '
          }               
        },
    },
      dataType: 'json',
      formData: '{!! $template->content !!}'
    };
    var fbform = $("#fb-editor").formBuilder(options);
    $("#fb-form").on("submit",function(e){
        // e.preventDefault();
        var hvalue = fbform.actions.getData('json');
      // console.log(hvalue);
      $(this).append("<textarea name='content' style='display:none'>"+hvalue+"</textarea>");
        // console.log(fbform.actions.getData('json'))
    })
</script>
@endsection

@section('style')
{{-- <link rel="stylesheet" href="{{ asset('css/vendor/quill.snow.css')}}" /> --}}
@endsection