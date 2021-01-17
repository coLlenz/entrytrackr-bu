@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-md-center">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h2> Visitor's Logs </h2>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center" >Status</th>
                                    <th class="text-center">Date & Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!$logs->isEmpty())
                                    @foreach( $logs as $log )
                                    <tr>
                                        <td class="text-center">{{ $log->action == 0 ? 'Sign In' : 'Sign Out' }}</td>
                                        <td class="text-center">{{ date('D-m-y H:i' , strtotime($log->created_at) ) }}</td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection