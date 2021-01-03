@extends('layouts.app')

@section('content')
    <div class="row justify-content-md-center">
        <div class="col-md-10">
            <h1> Manage Users </h1>
        </div>
        <!-- <div class="col-md-2">
            <button type="button" name="button" class="btn btn-primary btn-md float-right">Add User</button>
        </div> -->
    </div>
    <div class="row justify-content-md-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th class="text-center">Created</th>
                                <th class="text-center">Updated</th>
                                <th class="text-center" >Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @if(!empty($lists))
                                    @foreach( $lists as $list )
                                    <tr>
                                        <td> {{$list->name}} </td>
                                        <td> {{$list->email}} </td>
                                        <td class="text-center"> 
                                            {{ \Carbon\Carbon::parse($list->created_at)->format('d F Y g:i A') }} 
                                        </td>
                                        <td class="text-center"> 
                                            {{\Carbon\Carbon::parse($list->updated_at)->format('d F Y g:i A') }}
                                        </td>
                                        <td class="text-center">
                                            <button type="button" name="delete" class="btn btn-primary btn-sm" title="Remove Access">
                                                <i class="simple-icon-trash"></i>
                                            </button>
                                            <button type="button" name="delete" class="btn btn-primary btn-sm" title="Remove Access" title="Edit user">
                                                <i class="simple-icon-pencil"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection