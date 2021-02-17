@extends('layouts.app')
@section('content')
    <form class="" action="index.html" method="post">
        <div class="icon_container">
            <div class="icon">
                <input type="radio" name="feedback" value="1" id="excellent" class="feedback_radio">
                <label for="excellent">
                    <img src="{{asset('feedbacks/_excellent.svg')}}" alt="">
                </label>
            </div>
            <div class="icon">
                <input type="radio" name="feedback" value="2" id="good" class="feedback_radio">
                <label for="good">
                    <img src="{{asset('feedbacks/_good.svg')}}" alt="">
                </label>
            </div>
            <div class="icon">
                <input type="radio" name="feedback" value="3" id="average" class="feedback_radio">
                <label for="average">
                    <img src="{{asset('feedbacks/_average.svg')}}" alt="">
                </label>
            </div>
            <div class="icon">
                <input type="radio" name="feedback" value="4" id="bad" class="feedback_radio">
                <label for="bad">
                    <img src="{{asset('feedbacks/_bad.svg')}}" alt="">
                </label>
            </div>
        </div>
    </form>
@endsection