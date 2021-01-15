@extends('layouts.app')
@section('content')
<div class="container-fluid btn-download">
    <div class="row justify-content-md-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body custom_card_color">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="visitorInfo">
                                <p> Visitor Name: {{ $results->visitor_name }} </p>
                                <p> Date of Entry: {{ date('m D Y H:i' , strtotime($results->created_at)) }} </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="visitorInfo">
                                <p> Template Title: {{ $results->question_title }} </p>
                                <p> Temperature: {{ $results->temperature }} </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="">
                                <p> Status: {{ $results->status == 0 ? 'Allowed' : 'Denied'}} </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-md-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div id="resultContainer">
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div style="display:none">
        <form class="" action="{{ route('downloadResult') }}" method="POST" id="dl_submit">
            @csrf
            <input type="text" name="html" value="" id="dl_html">
        </form>
    </div>
</div>

<script type="text/javascript" src="{{ asset('js/vendor/jquery-3.3.1.min.js') }}"></script>
<script type="text/javascript">
    var data = {!! json_encode($results) !!};
    var answers  = JSON.parse(data.answers);
    
    var freetxt  = data.freetext
    
    var content_html = `{!! $questions->content_html !!}`;
    $('#resultContainer').append(content_html);
    
    var target = $('#resultContainer').find('.target');
    
    $(target).each( (idx , val) => {
        $(val).find('.float-right').remove();
        $(val).find('.form-group').find('input').remove();
        $(val).find('.form-group').append(`<p> ${answers[idx]} </p>`);
    });
    
    $( $(target).find('.txtarea').find('textarea') ).each( (idx,val) =>{
        $(val).text(freetxt[idx])
    });
    
    $('#resultContainer').append('<button class="btn btn-primary btn-lg float-right btnResultDownload" >Download</button>');
    
    $(document).on('click' ,'.btnResultDownload', function(){
        var clone = $('.btn-download').clone();
        $(clone).find('.btnResultDownload').remove();
        $('#dl_html').attr('value' , clone.html())
        $('#dl_submit').submit();
    })
    
</script>
@endsection