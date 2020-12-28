@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-md-center">
        <div class="col-md-8">
            <div class="float-right">
                <button type="button" class="btn btn-primary"  name="button" id="saveQuestion">Save Changes</button>
                <button type="button" class="btn btn-primary"  name="button" id="addQuestion">Add Question</button>
            </div>
        </div>
    </div> <br>
    <div class="row justify-content-md-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                <form action="{{route('questionnaire-add-new')}}" method="POST" id="formQuestion">
                    @csrf
                    <div id="questionsHere">
                        
                    </div>
                    <button type="submit" name="button">  Save</button>
                </form>
            </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{ asset('js/vendor/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('js/vendor/sweetalert2@10.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/question.js') }}"></script>
<script type="text/javascript">
    // $('#saveQuestion').on('click' , function(e) {
    //     e.preventDefault();
    //     console.log( $('#questionsHere').html() );
    //     // console.log( $('#questionsHere').find('#question1_answer').attr('value' , 'C') );
    // })
</script>
@endsection
