@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-md-center">
        <div class="col-md-8 col-sm-4 col-xs-6 col-lg-2 mb-4">
            <a href="#" class="card" style="cursor:default">
                <div class="card-body text-center">
                    <img src="{{asset('feedbacks/_excellent.svg')}}" alt="" height="100px" width="100px" class="mb-4">
                    <p class="lead text-center">{{$ratings['excellent'].'%'}}</p>
                </div>
            </a>
        </div>

        <div class="col-md-8 col-sm-4 col-xs-6 col-lg-2 mb-4">
            <a href="#" class="card" style="cursor:default">
                <div class="card-body text-center">
                    <img src="{{asset('feedbacks/_good.svg')}}" alt="" height="100px" width="100px" class="mb-4">
                    <p class="lead text-center">{{$ratings['good'].'%'}}</p>
                </div>
            </a>
        </div>

        <div class="col-md-8 col-sm-4 col-xs-6 col-lg-2 mb-4">
            <a href="#" class="card" style="cursor:default">
                <div class="card-body text-center">
                    <img src="{{asset('feedbacks/_average.svg')}}" alt="" height="100px" width="100px" class="mb-4">
                    <p class="lead text-center">{{$ratings['avg'].'%'}}</p>
                </div>
            </a>
        </div>

        <div class="col-md-8 col-sm-4 col-xs-6 col-lg-2 mb-4">
            <a href="#" class="card" style="cursor:default">
                <div class="card-body text-center">
                    <img src="{{asset('feedbacks/_bad.svg')}}" alt="" height="100px" width="100px" class="mb-4">
                    <p class="lead text-center">{{$ratings['bad'].'%'}}</p>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection