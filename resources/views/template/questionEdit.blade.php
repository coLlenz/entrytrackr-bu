@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-md-center">
        <div class="col-md-8">
            <div class="float-right">
                <button type="button" class="btn btn-primary"  name="button" id="saveQuestion" >Save Changes</button>
                <button type="button" class="btn btn-primary"  name="button" id="addQuestion">Add Question</button>
            </div>
        </div>
    </div> <br>
    <div class="row justify-content-md-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body clone_me">
                <form action="{{route('question-update' , $template->id)}}" method="POST" id="formQuestion">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="question_title" value="{{ $template->title }}" class="form-control"  placeholder="Enter title here.." required />
                    </div>
                    <div id="generated_container">
                        {!!html_entity_decode($template->content_html)!!}
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
    //set question from database;
    myQuestions = {!! $template->questions !!};
    
    generateHtml()
    
    $('#addQuestion').on('click' , function() {
        setConfig().queue( setSteps() ).then( results => {
            generateQuestion( results.value );
        });
    });
    
    $('#saveQuestion').on('click' , function() {
        var form = $('#formQuestion');
        var form_container = $('#generated_container');
        var form_data = new FormData();
        form_data.append('_token' , $('input[name=_token]').val())
        form_data.append('question_title' , $('input[name=question_title]').val())
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
                            title: 'Questionnaire has been save.',
                            showConfirmButton: false,
                            timer: 2000
                        })
                    }
                }
            })
        }else{
            alert('Title is Required');
        }
    });
</script>
@endsection
