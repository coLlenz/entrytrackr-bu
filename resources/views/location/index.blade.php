@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <h1>Locations</h1>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th class="text-center">QR</th>
                                    <th>Date Created</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if( !$lists->isEmpty() )
                                    @foreach($lists as $list)
                                        <tr>
                                            <td>{{$list->name}}</td>
                                            <td>{{$list->email}}</td>
                                            <td class="text-center">
                                                <a class="text-primary"  href="{{$list->qr_path}}" target="_blank">{{$list->qr_path}}</a>
                                            </td>
                                            <td>{{date('d-m-y H:i' , strtotime($list->created_at)) }}</td>
                                            <td class="text-center">
                                                <a href="{{route('visit' , [$list->uuid , $list->id] )}}" class="text-primary" >Visit</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        <h3 class="text-center"> <i> {{ $lists->isEmpty() ? 'No Results' : ''}} </i> </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection