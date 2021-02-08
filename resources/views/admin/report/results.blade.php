@extends('admin.layouts.admin')
@section('content')
<style media="screen">
    .p_line{
        display: inline;
    }
</style>

<div class="container-fluid btn-download">
    <div class="row justify-content-md-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body custom_card_color">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="visitorInfo">
                                <p class="font-weight-bold p_line" > Visitor Name:</p> <p class="p_line">  {{ $results->visitor_name }}</p> <br>
                                <p class="font-weight-bold p_line"> Date of Entry:</p> <p class="p_line"> {{ \Carbon\Carbon::parse($results->created_at)->timezone(userTz())->format('d-m-Y H:i') }} </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="visitorInfo">
                                <p class="font-weight-bold p_line" > Questionnaire:</p> <p class="p_line"> {{ $results->question_title }} </p> <br>
                                <p class="font-weight-bold p_line"> Temperature: </p> <p class="p_line"> {{ $results->temperature }} </p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="">
                                @if($results->status == 0)
                                <p class="font-weight-bold p_line" > Status:</p> <span class="badge badge-success">Allowed</span>
                                @else
                                <p class="font-weight-bold p_line" > Status:</p> <span class="badge badge-dark">Denied</span>
                                @endif
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
                    <div id="resultContainer"></div>
                    <table class="table">
                        <thead >
                            <tr class="bg-primary">
                                <th>#</th>
                                <th class="text-center">Question</th>
                                <th class="text-center">Response</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $basic = 0;
                                $freetxt = 0;
                            @endphp
                            @foreach( json_decode($questions->questions) as $key => $question )
                                <tr>   
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $question->question }}</td>
                                    <td class="text-center">
                                        @if( isset( $question->type ) && $question->type == 'freetext')
                                            {{ isset($results->freetext[$freetxt]) ? $results->freetext[$freetxt] : '' }}
                                            @php $freetxt++ @endphp
                                        @else
                                            {{ $results->answers[$basic] == 'A' ? 'Yes' : 'No' }}
                                            @php $basic++ @endphp
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <hr/>
                    <button class="btn btn-primary btn-lg float-right btnResultDownload" >Download</button>
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
    $(document).on('click' ,'.btnResultDownload', function(){
        var clone = $('.btn-download').clone();
        $(clone).find('.btnResultDownload').remove();
        $('#dl_html').attr('value' , clone.html())
        $('#dl_submit').submit();
    })
    {{--var data = {!! json_encode($results) !!};
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
    
    $('#resultContainer').append('<button class="btn btn-primary btn-lg float-right btnResultDownload" >Download</button>'); --}}
    
    
</script>
@endsection