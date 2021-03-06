@extends('admin.layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-md-center">
        <div class="col-md-8">
            <div class="float-right">
                <button type="button" class="btn btn-primary"  name="button" id="saveQuestion" style="display:none;" >Save Changes</button>
                <button type="button" class="btn btn-primary"  name="button" id="addQuestion">Add Question</button>
                @if(!empty($templates))
                    <button class="btn btn-primary dropdown-toggle" type="button"
                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        Templates
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        @foreach($templates as $template)
                            <a class="dropdown-item template_option" href="#" template_data="{{$template->content_html}}" template_question = "{{$template->questions}}">{{$template->title}}</a>
                        @endforeach
                    </div>
                @endif
                <a href="{{ url('/templates') }}" class="btn btn-primary">Back to Templates</a>
            </div>
        </div>
    </div> <br>
    <div class="row justify-content-md-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body clone_me">
                <form action="{{route('questionSave')}}" method="POST" id="formQuestion">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="question_title" value="" class="form-control"  placeholder="Enter title here.." required />
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="question_description" rows="3" placeholder="Description here..."></textarea>
                    </div>
                    {{-- <div class="form-check form-check-inline">
                        <input type="checkbox" class="form-check-input" id="visitor" name="toVisitor" value=1>
                        <label class="form-check-label" for="visitor">Visitor</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" class="form-check-input" id="contractor"  name="toVisitor" value=2>
                        <label class="form-check-label" for="contractor">Contractor</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" class="form-check-input" id="employee"  name="toVisitor" value=3>
                        <label class="form-check-label" for="employee">Employee</label>
                    </div> --}}
                    
                    <hr/>
                    <div id="generated_container">
                        
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{ asset('js/vendor/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('js/vendor/sweetalert2@10.js')}}"></script>
<script src="{{ asset('js/question.js')}}"></script>
<script type="text/javascript">
    generateHtml()
    
    $('#addQuestion').on('click' , function() {
        questiontype();
        // setConfig().queue( setSteps() ).then( results => {
        //     generateQuestion( results.value );
        // });
    });
    
    $(document).on('click' , '#Multiple' , function(){
        setConfig().queue( setSteps() ).then( results => {
            generateQuestion( results.value );
        });
    })
    $(document).on('click' , '#txtbase' , function(){
        txtBase();
    })
    
    $('.template_option').on('click' , function() {
        selectedTemplate( $(this).attr('template_data') , $(this).attr('template_question') )
    });
    
    $('#saveQuestion').on('click' , function() {
        var form = $('#formQuestion');
        var form_container = $('#generated_container');
        var form_data = new FormData();
        form_data.append('_token' , $('input[name=_token]').val())
        form_data.append('question_title' , $('input[name=question_title]').val())
        form_data.append('question_description' , $('textarea[name=question_description]').val())
        form_data.append('toVisitor' , JSON.stringify( getCheckBoxData() ) )
        form_data.append('question_data' , JSON.stringify(myQuestions));
        form_data.append('question_html' , form_container.html() );
        if ( fieldCheck() ) {
            $.ajax({
                url : form.attr('action'),
                method: form.attr('method'),
                processData: false,
                contentType: false,
                data: form_data,
                success : function(response){
                    if (response.status == 'success') {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Questionnaire has been saved.',
                            showConfirmButton: false,
                            timer: 2000
                        });
                        
                        setTimeout(function () {
                            window.location.href = '/admin/templates/edit/questionnaire/'+response.template_id;
                        }, 1500);
                    }
                }
            })
        }else{
            alert('Title is Required');
        }
    });
    
    function getCheckBoxData(){
        var check_data = [];
        $('.form-check-input:checked').each(function (idx , val) {
           check_data.push( $(this).val() );
        });
        
        return check_data;
    }
</script>
@endsection
